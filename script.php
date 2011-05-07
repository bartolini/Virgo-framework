<?php

set_time_limit(0);

define('FRAME_PATH', realpath(dirname(__FILE__)));
require FRAME_PATH."/include/classLoader.php";
require FRAME_PATH."/include/siteConfig.php";
require FRAME_PATH."/include/phpSetup.php";

if (count($argv) < 2) {
    die("Usage: php script.php PutScriptClassNameHere\n");
}

new $argv[1];
