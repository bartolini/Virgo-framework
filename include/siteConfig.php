<?php

// basic config
CoreConfig::object()->debug         = true;
CoreConfig::object()->templates     = FRAME_PATH."/templates/";
CoreConfig::object()->thirdParty    = FRAME_PATH."/3rdparty/";
CoreConfig::object()->pagesMap      = FRAME_PATH."/pages.ini";
CoreConfig::object()->subConfigs    = FRAME_PATH."/config/";
CoreConfig::object()->page404       = "CorePage404";

// databases config
CoreConfig::object()->dbConfig = array(
    "main" => array(
        "dbSchema"      => "mysql",
        "dbHostname"    => "127.0.0.1",
        "dbDatabase"    => "database",
        "dbUsername"    => "username",
        "dbPassword"    => "password"
    ),
);
