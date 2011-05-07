<?php

define('FRAME_PATH', realpath(dirname(__FILE__)."/../"));
require FRAME_PATH."/include/classLoader.php";
require FRAME_PATH."/include/siteConfig.php";
require FRAME_PATH."/include/phpSetup.php";

new Bootstrap();
new CoreDispatcher();
