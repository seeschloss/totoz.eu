<?php
  global $base_url;

  foreach ($nodes as $nid => &$totoz) {
    $tags = join(', ', $totoz['tags']);

    $time = strtotime($totoz['created']);

    $totoz = array(
      'key' => 'item',
      'value' => array(
        'title' => $totoz['name'],
        'description' => '<img src="' . $totoz['url'] . '"><br /><p>Tags: ' . $tags . '</p>',
        'link' => url('node/' . $totoz['nid'], array('absolute' => TRUE)),
        'guid' => $totoz['nid'],
        'pubDate' => date('r', $time),
      ),
    );
  }

  echo format_xml_elements(
    array(
      array(
        'key' => 'rss',
        'attributes' => array(
          'version' => '2.0',
        ),
        'value' => array(
          'channel' => array(
            'title' => t('Latest totoz'),
            'description' => t('The latest images posted on totoz.eu'),
            'link' => url('latest'),
            'ttl' => 3600,
          ) + $nodes,
        ),
      )
    )
  );
?>
