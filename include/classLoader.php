<?php

require_once FRAME_PATH."/class/core/autoloader.php";
require_once FRAME_PATH."/class/core/autoloader/default.php";

CoreAutoloader::register(
    new CoreAutoloaderDefault()
);

function __autoload($className) {
    CoreAutoloader::autoload($className);
}
