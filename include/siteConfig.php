<?php

// basic config
CoreConfig::object()->debug         = true;
CoreConfig::object()->templates     = FRAME_PATH."/templates/";
CoreConfig::object()->thirdParty    = FRAME_PATH."/3rdparty/";
CoreConfig::object()->subConfigs    = FRAME_PATH."/config/";
CoreConfig::object()->page404       = "CorePage404";
