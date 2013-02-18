<?php foreach ($nodes as $nid => &$totoz): ?>
  <?php 
  unset($totoz['nid']);

  foreach ($totoz['tags'] as $tid => &$tag) {
    $tag = array(
      'key' => 'tag',
      'value' => $tag,
    );
  }

  unset($totoz['uid']);
  $totoz = array(
    'key' => 'totoz',
    'value' => $totoz,
  );
  ?>
<?php endforeach; ?>
<?php
  echo format_xml_elements(array(array('key' => 'totozes', 'attributes' => array('results' => $total), 'value' => $nodes)));
?>
