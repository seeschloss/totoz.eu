<?php 
foreach ($tags as $tid => &$tag) {
  $tag = array(
    'key' => 'tag',
    'value' => $tag,
  );
}
?>
<totoz>
  <name><?php echo $node->title ?></name>
  <username><?php echo $user->name ?></username>
  <created><?php echo date('c', $node->created) ?></created>
  <url><?php echo $url ?></url>
  <md5sum><?php echo $md5 ?></md5sum>
  <weight><?php echo $weight ?></weight>
  <format><?php echo $format ?></format>
  <width><?php echo $width ?></width>
  <height><?php echo $height ?></height>
  <length><?php echo $length ?></length>
  <frames><?php echo count($frames) ?></frames>
  <nsfw><?php echo $nsfw ?></nsfw>
  <tags><?php echo format_xml_elements($tags); ?></tags>
</totoz>
