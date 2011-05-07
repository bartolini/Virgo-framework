<?php

error_reporting(CoreConfig::object()->debug ? E_ALL : 0);
set_exception_handler(array("CoreExceptionHandler", "handleException"));
