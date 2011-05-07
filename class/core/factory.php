<?php

/**
 * Simple objects factory.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
class CoreFactory {

    /**
     * Database connection.
     *
     * @var PDO
     */
    private $db;

    /**
     * Object prototype.
     *
     * @var CoreFactorizable
     */
    private $prototype = null;

    /**
     * Source table name.
     *
     * @var string
     */
    private $table = null;

    /**
     * Fields list.
     *
     * @var array
     */
    private $fields = array("*");

    /**
     * Primary key.
     *
     * @var string
     */
    private $primaryKey = "id";

    /**
     * Factory initialization.
     */
    public function __construct() {
    }

    /**
     * Prototype setter.
     *
     * @param CoreFactorizable $object
     */
    public function setPrototype(CoreFactorizable $object) {
        $this->prototype = $object;
        $this->db = CoreDao::connection($object->getDbConnection());
        if ($object->getTable()) {
            $this->table = $object->getTable();
        }
        if ($object->getPrimaryKey()) {
            $this->primaryKey = $object->getPrimaryKey();
        }
    }

    /**
     * Primary key setter.
     *
     * @param string $primaryKey
     */
    public function setPrimary($primaryKey) {
        $this->primaryKey = $primaryKey;
    }

    /**
     * Table name setter.
     *
     * @param string $tableName
     */
    public function setTable($tableName) {
        $this->table = $tableName;
    }

    /**
     * Fields list setter.
     *
     * @param array $fields
     */
    public function setFields($fields) {
        $this->fields = $fields;
    }

    /**
     * Retrieves single object.
     *
     * @param integer $id
     * @return CoreFactorizable
     */
    public function getSingleObject($id) {
        $collection = $this->getCollection(array($id));
        return empty($collection) ? null : array_shift($collection);
    }

    public function getAllObjects($orderBy) {
        // simple checkout
        $this->basicCheckout();

        // preparing fields list:
        $fieldsList = implode(",", $this->fields);

        // fetching from database
        $query = $this->db->query("
            SELECT {$fieldsList}
            FROM {$this->table}
            ORDER BY {$orderBy}
        ");

        // retrieving data
        return ($query) ? $this->retrieveCollection($query->fetchAll(PDO::FETCH_ASSOC)) : array();
    }

    /**
     * Retrieves collection of objects.
     *
     * @param array $objectIds
     * @return array $collection
     */
    public function getCollection($objectIds) {
        // if no ids given there's nothing to do
        if (empty($objectIds)) {
            return array();
        }

        // simple checkout
        $this->basicCheckout();

        // preparing ids to avoid sql injection
        foreach ($objectIds as $index => $value) {
            $objectIds[$index] = (int)$value;
        }
        $objectIds = implode(",", $objectIds);

        // preparing fields list:
        $fieldsList = implode(",", $this->fields);
        
        // fetching from database
        $query = $this->db->query("
            SELECT {$fieldsList} FROM {$this->table}
            WHERE {$this->primaryKey} IN ({$objectIds})
            ORDER BY FIELD({$this->primaryKey}, {$objectIds})
        ");

        // retrieving data
        return ($query) ? $this->retrieveCollection($query->fetchAll(PDO::FETCH_ASSOC)) : array();
    }

    public function findObjects($where, $orderBy = "") {
        // simple checkout
        $this->basicCheckout();

        // preparing fields list:
        $fieldsList = implode(",", $this->fields);

        // fetching from database
        $query = "SELECT {$fieldsList} FROM {$this->table} WHERE {$where}";
        if (!empty($orderBy)) {
            $query .= " ORDER BY {$orderBy}";
        }

        // fetching from database
        $query = $this->db->query($query);

        // retrieving data
        return ($query) ? $this->retrieveCollection($query->fetchAll(PDO::FETCH_ASSOC)) : array();
    }

    /**
     * Basic checkout if this factory can retrieve objects.
     */
    private function basicCheckout() {
        if (is_null($this->prototype) || is_null($this->table)) {
            throw new CoreExceptionFramework("Prototype and/or table not set!");
        }
    }

    /**
     * Retrieves collection of objects from data.
     *
     * @param array $objectsData
     * @return array $collection
     */
    private function retrieveCollection($data) {
        $collection = array();
        foreach ($data as $objectData) {
            $object = clone $this->prototype;
            $object->setData($objectData);
            $collection[] = $object;
        }
        return $collection;
    }
}
