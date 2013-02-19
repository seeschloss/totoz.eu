<?php
  global $base_url;
?>
<?php foreach ($nodes as $nid => &$totoz): ?>
  <?php 

  $tags = join(', ', $totoz['tags']);

  $ctime = strtotime($totoz['created']);
  $mtime = strtotime($totoz['changed']);

  $totoz = array(
    'key' => 'post',
    'attributes' => array(
      'id' => $totoz['nid'],
      'time' => date('YmdHis', $mtime),
    ),
    'value' => array(
      'info' => $tags,
      'message' => '[:' . $totoz['name'] . ']',
      'login' => $totoz['username'],
    ),
  );
  ?>
<?php endforeach; ?>
<?php
  echo format_xml_elements(array(array('key' => 'board', 'attributes' => array('site' => $base_url), 'value' => $nodes)));
?>
