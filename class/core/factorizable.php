<?php

/**
 * Simple factorizable object.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
abstract class CoreFactorizable {

    /**
     * Object data.
     *
     * @var array
     */
    protected $data = array();

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = null;

    /**
     * Primary key.
     *
     * @var string
     */
    protected $primaryKey = null;

    /**
     * Database connection identifier.
     *
     * @var string
     */
    protected $dbConnection = "main";

    /**
     * Object initialization.
     */
    public function  __construct() {
    }

    /**
     * Object data setup.
     *
     * @param array $data
     * @param boolean $update
     */
    public function setData($data, $update = true) {
        if ($update) {
            $this->data = $data + $this->data;
        } else {
            $this->data = $data;
        }
    }

    /**
     * Returns object data.
     *
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Returns object table.
     *
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * Sets table name.
     *
     * @param string $dbConnection
     */
    public function setTable($table) {
        $this->table = $table;
    }

    /**
     * Returns database connection name.
     *
     * @return string
     */
    public function getDbConnection() {
        return $this->dbConnection;
    }

    /**
     * Sets database connection name.
     *
     * @param string $dbConnection
     */
    public function setDbConnection($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Returns primary key.
     *
     * @return string
     */
    public function getPrimaryKey() {
        return $this->primaryKey;
    }

    /**
     * Sets primary key.
     *
     * @param string $primaryKey
     */
    public function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }

    /**
     * Automagic setter.
     *
     * @param string $name
     * @param mixed $value
     */
    public function  __set($name,  $value) {
        $this->data[$name] = $value;
    }

    /**
     * Automagic getter.
     *
     * @param string $name
     * @return mixed
     */
    public function  __get($name) {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
}
