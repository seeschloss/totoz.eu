<?php foreach ($nodes as $nid => &$totoz): ?>
  <?php 
  unset($totoz['nid']);
  unset($totoz['uid']);
  $totoz['tags'] = array_values($totoz['tags']);
  ?>
<?php endforeach; ?>
<?php
  echo json_encode(array('results' => $total, 'totozes' => array_values($nodes)), JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>
