<?php

/**
 * Script abstract class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 *
 */
abstract class CoreScript {

    /**
     * Site config object.
     *
     * @var CoreConfig
     */
    protected $config;

    /**
     * Default database connection.
     *
     * @var PDO
     */
    protected $db;

    /**
     * Constructor - simple initialization & execution.
     */
    public function __construct() {
        $this->config = CoreConfig::object();
        $this->db = CoreDao::connection();
        $this->execute();
    }

    /**
     * Script execution - abstract method.
     */
    abstract protected function execute();

}
