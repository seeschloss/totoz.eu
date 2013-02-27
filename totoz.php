<?php

$sfw = isset($_GET['sfw']) ? $_GET['sfw'] : 'sfw';
$totoz = str_replace('.gif', '', strtolower($_GET['totoz']));
$totoz = str_replace('.png', '', strtolower($totoz));
$totoz = str_replace('.jpg', '', strtolower($totoz));
$try_hfr = TRUE;

// I found using this goto was around 20% faster than the
// easy to read and clean functions I was using previously.
// The only time this goto is used is when a totoz was not
// found, after tentatively downloading it from HFR.
// The variable $try_hfr indicates whether we have already
// passed by this goto.
begin:

$filepath      = '/home/seeschloss/totoz.eu/' . $sfw . '/' . $totoz . '.gif';
$filepath_sfw  = '/home/seeschloss/totoz.eu/sfw/' . $totoz . '.gif';
$filepath_nsfw = '/home/seeschloss/totoz.eu/nsfw/' . $totoz . '.gif';

if (file_exists($filepath)) {
  // Our totoz exists and is allowed (SFW or NSFW totoz/NSFW domain, or SFW totoz/SFW domain).
  header_remove();
  $last_modified = filemtime($filepath);
  header('Last-Modified: ' . date('r', $last_modified));
  header('Expires: ' . date('r', strtotime('+15 days')));

  if ($sfw == 'nsfw' and !file_exists($filepath_sfw)) {
    header('X-Safe-For-Work: No');
  } else {
    header('X-Safe-For-Work: Yes');
  }

  if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and $if_modified_since = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) and $if_modified_since <= $last_modified) {
    header('HTTP/1.0 304 Not Modified');
    exit();
  }

  header('Content-Length: ' . filesize($filepath));

  $fi = new finfo(FILEINFO_MIME_TYPE, '/home/seeschloss/totoz.eu/magic.mime');
  $mime_type = $fi->file($filepath);
  header('Content-Type: ' . $mime_type);

  readfile($filepath);
} elseif ($sfw == 'sfw' and file_exists($filepath_nsfw))  {
  // Our totoz is NSFW but we asked for a SFW one.
  header_remove();
  header('HTTP/1.0 403 Not Safe For Work');
  header('Content-Type: text/plain');
  echo 'This totoz is not safe for work.';
} else if ($try_hfr) {
  // The totoz doesn't exist, let's ask HFR.
  $url = 'http://totoz.eu/totoz-from-hfr/' . $totoz;
  $result = file_get_contents($url);
    // don't bother with the call's result, we'll just make another pass

  $try_hfr = FALSE;
  goto begin;
} else {
  header_remove();
  header('HTTP/1.0 404 Not Found');
  header('Content-Type: text/plain');
  echo 'This totoz does not exist.';
}

?>
