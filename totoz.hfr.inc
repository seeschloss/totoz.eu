<?php

/**
 * Create a new totoz with user hfr (uid 4) from hardware.fr forums
 * if the totoz exists on HFR and if it doesn't exist on totoz.eu.
 */
function totoz_hfr_import($totoz_name) {
  $totoz_name = basename($totoz_name, '.gif');

  $main_url = 'http://forum-images.hardware.fr/images/perso/' .
    rawurlencode($totoz_name) .
    '.gif';

  $result = drupal_http_request($main_url);
  if (!empty($result->error)) {
    $totoz_perso = explode(':', $totoz_name);
    if (count($totoz_perso) == 2 and is_numeric($totoz_perso[1])) {
      $perso_url = 'http://forum-images.hardware.fr/images/perso/' .
        $totoz_perso[1] .
        '/' .
        $totoz_perso[0] .
        '.gif';

      $result = drupal_http_request($perso_url);

      if (!empty($result->error)) {
        drupal_not_found();
        drupal_exit();
      }
    } else {
      drupal_not_found();
      drupal_exit();
    }
  }

  $hfr_tags = totoz_hfr_tags($totoz_name);

  $totoz_image_data = $result->data;

  $created = strtotime($result->headers['last-modified']);
  $node = new stdClass();
  $node->type = 'totoz';
  $node->title = $totoz_name;
  $node->created = $created;
  $node->promote = 1;
  $node->uid = user_load_by_name('hfr')->uid;
  $node->field_nsfw = array(
    LANGUAGE_NONE => array(
      0 => array(
        'value' => 0
      )
    )
  );

  $vocabulary = taxonomy_vocabulary_load(1); // "Tags" vid
  $node->field_tags = array(LANGUAGE_NONE => array());
  foreach ($hfr_tags as $tag) {
    $terms = taxonomy_term_load_multiple(array(), array('vid' => $vocabulary->vid, 'name' => $tag));

    if (empty($terms)) {
      $term = (object)array(
        'vid' => (int)$vocabulary->vid,
        'name' => $tag,
        'description' => '',
        'format' => '',
        'weight' => 0,
        'vocabulary_machine_name' => 'tags',
      );
      taxonomy_term_save($term);
    } else {
      $term = array_pop($terms);
    }

    $node->field_tags[LANGUAGE_NONE][] = array(
      'tid' => $term->tid,
    );
  }

  $dst = 'public://totoz/' .
    strtolower(substr($node->title, 0, 230)) .
    '.gif';
  $file = file_save_data($totoz_image_data, $dst, FILE_EXISTS_RENAME);
  touch(drupal_realpath($file->uri), $node->created);
  $node->field_image = array(
    LANGUAGE_NONE => array(
      0 => array(
        'fid' => $file->fid,
      ),
    ),
  );

  if ($nodes = node_load_multiple(array(), array('type' => 'totoz', 'title' => $totoz_name)) and count($nodes)) {
    $node = reset($nodes);
  } else {
    node_save($node);
  }

  $file = file_load($node->field_image[LANGUAGE_NONE][0]['fid']);
  $path = drupal_realpath($file->uri);

  $fi = new finfo(FILEINFO_MIME_TYPE, '/home/seeschloss/totoz.sauf.ca/magic.mime');
  $mime_type = $fi->file($path);
  header('Content-Type: ' . $mime_type);
  header('Content-Length: ' . filesize($path));
  readfile($path);

  drupal_exit();
}

function totoz_hfr_tags($totoz_name) {
  $tags = array();

  $url = 'http://forum.hardware.fr/wikismilies.php?config=hfr.inc&detail=' .
    rawurlencode('[:'.$totoz_name.']');
  $result = drupal_http_request($url);
  if (empty($result->error)) {
    $dom = new DomDocument();
    @$dom->loadHTML($result->data);
    foreach ($dom->getElementsByTagName('input') as $element) {
      if ($element->getAttribute('name') == 'keywords0') {
        $tags = explode(' ', (string)$element->getAttribute('value'));
      }
    }
  }

  return $tags;
}

