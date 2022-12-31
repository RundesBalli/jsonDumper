<?php
/**
 * public/showDumps.php
 * 
 * Show all dumps.
 */

/**
 * Include the config file.
 */
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'config.php');

/**
 * Check if the token is provided and correct.
 */
if(empty($_GET['token']) OR trim($_GET['token']) != $token) {
  /**
   * End script, because a wrong token has been provided.
   */
  http_response_code(403);
  die('<h1>Forbidden</h1>');
}

echo '<h1>Files</h1>';

/**
 * Read file list.
 */
$files = array_diff(
  scandir(
    __DIR__.DIRECTORY_SEPARATOR.'dumps',
    SCANDIR_SORT_DESCENDING
  ),
  [
    '.',
    '..'
  ]
);

if(empty($files)) {
  die('<p>No files. :-(</p>');
}

/**
 * Check if a file should be deleted.
 */
if(!empty($_GET['del'])) {
  $key = array_search($_GET['del'], $files);
  if($key === FALSE) {
    echo '<p>This file does not exist.</p>';
  } else {
    unlink(__DIR__.DIRECTORY_SEPARATOR.'dumps'.DIRECTORY_SEPARATOR.$files[$key]);
    header('Location: ./showDumps.php?token='.$token);
    die();
  }
}


/**
 * Show files.
 */
foreach($files as $file) {
  echo '<p><a href="./dumps/'.$file.'" target="_blank">'.$file.'</a> - <a href="./showDumps.php?token='.$token.'&del='.$file.'">del</a></p>';
}
?>
