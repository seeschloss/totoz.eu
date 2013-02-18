<?php 
echo json_encode(array(
  'name' => $node->title,
  'username' => $user->name,
  'created' => date('c', $node->created),
  'url' => $url,
  'md5sum' => $md5,
  'weight' => $weight,
  'format' => $format,
  'width' => $width,
  'height' => $height,
  'length' => $length,
  'frames' => count($frames),
  'nsfw' => $nsfw,
  'tags' => $tags,
), JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>
