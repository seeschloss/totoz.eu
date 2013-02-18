<div class="totoz-list">
<ul>
<?php foreach ($nodes as $nid => $totoz): ?>
  <?php 
    $details_path = 'node/' . $nid;
  ?>
  <li class="<?php if ($totoz['nsfw']) {echo 'nsfw';} ?>">
    <article>
      <header>
        <h2><span class="totoz-open">[:</span><?php echo $totoz['name'] ?><span class="totoz-close">]</span></h2>
      </header>
      <div>
        <?php echo l('<img src="' . $totoz['url'] . '" />', $details_path, array('html' => TRUE)) ?>
      </div>
      <footer class="submitted">
        <?php echo l($totoz['username'], 'user/' . $totoz['uid']) ?>
      </footer>
    </article>
  </li>
<?php endforeach; ?>
</ul>
</div>
