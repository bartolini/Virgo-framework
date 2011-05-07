<?php

/**
 * Simple container.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
class CoreContainer {

    /**
     * Container data.
     *
     * @var array
     */
    private $container = array();

    /**
     * Sets container data.
     *
     * @param string $key
     * @param mixed $data
     */
    public function set($key, $data) {
        $this->checkData($data);
        $this->container[$key] = $data;
    }

    /**
     * Appends data to container.
     *
     * @param string $key
     * @param mixed $data
     */
    public function append($key, $data) {
        if (!isset($this->container[$key])) {
            $this->set($key, $data);
            return;
        }
        $this->checkData($data);
        if (!is_array($this->container[$key])) {
            $this->container[$key] = array($this->container[$key]);
        }
        array_push($this->container[$key], $data);
    }

    /**
     * Prepends data to container.
     *
     * @param string $key
     * @param mixed $data
     */
    public function prepend($key, $data) {
        if (!isset($this->container[$key])) {
            $this->set($key, $data);
            return;
        }
        $this->checkData($data);
        if (!is_array($this->container[$key])) {
            $this->container[$key] = array($this->container[$key]);
        }
        array_unshift($this->container[$key], $data);
    }

    /**
     * Retrieves container data as string.
     *
     * @param string $key
     * @param string $separator
     * @return string
     */
    public function retrieve($key, $separator = "") {
        if (isset($this->container[$key])) {
            return $this->concat($this->container[$key], $separator);
        }
        return null;
    }

    /**
     * Sets container data.
     *
     * @param string $key
     * @param mixed $data
     */
    public function  __set($key, $data) {
        $this->set($key, $data);
    }

    /**
     * Retrieves container data.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key) {
        return (isset($this->container[$key])) ? $this->container[$key] : null;
    }

    /**
     * Concats data.
     *
     * @param mixed $data
     * @param string $separator
     * @return string
     */
    private function concat($data, $separator) {
        if (!is_array($data)) {
            return $data;
        }
        $result = array();
        foreach ($data as $index => $value) {
            $result[$index] = (is_array($value)) ? $this->concat($value, $separator) : $value;
        }
        return implode($separator, $result);
    }

    /**
     * Checks data type.
     *
     * @param mixed $data
     */
    private function checkData($data) {
        if (is_object($data)) {
            throw new CoreExceptionFramework("Simple data types allowed only!");
        } elseif (is_array($data)) {
            foreach($data as $value) {
                $this->checkData($value);
            }
        }
    }

}
