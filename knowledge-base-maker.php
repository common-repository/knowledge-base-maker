<?php
/**
 * Plugin Name: Knowledge Base Maker
 * Description: WordPress Knowledge Base plugin allow to create many Knowledge Base Maker articles.
 * Version: 1.1.8
 * Author: Felix Moira
 * Author URI: 
 * License: GPLv2
 */

if(!defined('YKB_FILE_NAME')) {
	define('YKB_FILE_NAME', plugin_basename(__FILE__));
}

if(!defined('YKB_FOLDER_NAME')) {
	define('YKB_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

define('YKB_PREF', plugin_basename(__FILE__));
require_once(dirname(__FILE__).'/com/boot.php');
require_once(YKB_CLASS_PATH.'YkbInit.php');
$ykbInit = new YkbInit();