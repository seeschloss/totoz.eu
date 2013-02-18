<?php foreach ($users as $nid => &$user): ?>
  <?php 
  $user = array(
    'key' => 'user',
    'value' => $user,
  );
  ?>
<?php endforeach; ?>
<?php
  echo format_xml_elements(array(array('key' => 'users', 'attributes' => array('results' => $total), 'value' => $users)));
?>
