<dl>
  <dt><?php echo t('MD5 sum') ?></dt>
    <dd><?php echo $md5 ?></dd>
  <dt><?php echo t('Weight') ?></dt>
    <dd><?php echo _totoz_human_filesize($weight) ?></dd>
  <dt><?php echo t('Format') ?></dt>
    <dd><?php echo $format ?></dd>
  <dt><?php echo t('Dimensions') ?></dt>
    <dd><?php echo $width ?>×<?php echo $height ?></dd>
  <dt><?php echo t('Animated') ?></dt>
    <dd><?php echo $animated ? t('Yes') : t('No') ?></dd>
  <?php if ($animated): ?>
  <dt><?php echo t('Length') ?></dt>
    <dd><?php echo $length ?> ms</dd>
  <dt><?php echo t('Frames') ?></dt>
    <dd><?php echo count($frames) ?></dd>
  <?php endif; ?>
</dl>
