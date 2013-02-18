<?php
  echo json_encode(array('results' => $total, 'users' => array_values($users)), JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>
