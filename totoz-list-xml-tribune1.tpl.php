<?php foreach ($nodes as $nid => &$totoz): ?>
  <?php 
  $id = $totoz['nid'];
  unset($totoz['nid']);
  unset($totoz['nsfw']);
  unset($totoz['username']);
  unset($totoz['tags']);

  $totoz['filename'] = $totoz['name'] . '.gif';

  unset($totoz['uid']);
  $totoz = array(
    'key' => 'totoz',
    'value' => $totoz,
    'attributes' => array(
      'id' => $id,
    ),
  );
  ?>
<?php endforeach; ?>
<?php
  echo format_xml_elements(array(array('key' => 'totozes', 'attributes' => array('results' => $total), 'value' => $nodes)));
?>
