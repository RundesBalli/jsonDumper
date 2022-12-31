<?php
/**
 * jsonDumper
 * 
 * Simple JSON dumper with token and file listing.
 * 
 * @author    RundesBalli <GitHub@RundesBalli.com>
 * @copyright 2022 RundesBalli
 * @see       https://github.com/RundesBalli/jsonDumper
 */

/**
 * public/dumper.php
 * 
 * Create a JSON file from any raw JSON input.
 */

/**
 * Include the config file.
 */
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'config.php');

/**
 * Set the content-type header to JSON.
 */
header("Content-Type: application/json; charset=UTF-8");

/**
 * Check if the token is provided and correct.
 */
if(empty($_GET['token']) OR trim($_GET['token']) != $token) {
  /**
   * End script, because a wrong token has been provided.
   */
  http_response_code(403);
  die(json_encode([
    'error' => 'wrongToken'
  ]));
}

/**
 * Check if raw data is provided.
 */
$rawData = file_get_contents("php://input");
if(empty($rawData)) {
  /**
   * End script, because no data has been provided.
   */
  http_response_code(400);
  die(json_encode([
    'error' => 'noData'
  ]));
}

/**
 * Decode JSON data.
 */
$input = json_decode($rawData, TRUE);
if(json_last_error() != JSON_ERROR_NONE) {
  /**
   * End script, because the provided data is not in JSON format.
   */
  http_response_code(400);
  die(json_encode([
    'error' => 'invalidJson'
  ]));
}

/**
 * Check if the dump directory is existent.
 */
$directory = __DIR__.DIRECTORY_SEPARATOR.'dumps'.DIRECTORY_SEPARATOR;
if(!file_exists($directory)) {
  /**
   * The directory does not exist. Create it.
   */
  if(!mkdir($directory)) {
    /**
     * End script, because the directory can not be created.
     */
  http_response_code(500);
    die(json_encode([
      'error' => 'directoryNotCreateable'
    ]));
  }
}

/**
 * Check if the new file is writeable.
 */
$filename = $directory.date('Y-m-d_H-i-s').'_'.md5(random_bytes(4096)).'.json';
$fp = fopen($filename, 'w');
if(!$fp) {
  /**
   * End script, because the file can not be created.
   */
  http_response_code(500);
  die(json_encode([
    'error' => 'fileNotWriteable'
  ]));
}

/**
 * Write to file.
 */
fwrite($fp, json_encode($input));
fclose($fp);

/**
 * Everything ok.
 */
http_response_code(200);
die(json_encode([
  'error' => NULL,
  'success' => TRUE
]));
?>
