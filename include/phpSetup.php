<?php

setlocale(LC_CTYPE, 'en_US.UTF8');
error_reporting(CoreConfig::object()->debug ? E_ALL : 0);
set_exception_handler(array("CoreExceptionHandler", "handleException"));
