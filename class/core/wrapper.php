<?php

/**
 * Abstract class wrapper. 
 * 
 * @author Bartlomiej.biskupek <bartlomiej.biskupek@gmail.com> 
 */
abstract class CoreWrapper {

    /**
     * Wrapped object reference. 
     * 
     * @var object
     */
    private $object;

    /**
     * Wrapper constructor. 
     * 
     * @param object $object 
     */
    public function __construct($object) {
        $this->object = $object;
        $this->initialize();
    }
    
    /**
     * Automagic call method. 
     * 
     * @param object $method 
     * @param array $arguments 
     */
    public function __call($method, $arguments) {
        $hash = $this->generateHash($arguments);
        if ($this->preExecution($method, $hash)) {
            $result = $this->getResult($method, $hash);
        } else {
            $result = call_user_func_array(array($this->object, $method), $arguments);
            $this->postExecution($method, $hash, $result);
        }
        return $result;
    }

    /**
     * Wrapper initialization 
     */
    protected function initialize() {
    }

    /**
     * Precall. 
     * 
     * @param string $method 
     * @param string $hash 
     * @return boolean
     */
    protected function preExecution($method, $hash) {
        return false;
    }

    /**
     * Returns cached results for call. 
     * 
     * @param string $method 
     * @param string $hash 
     * @return mixed
     */
    protected function getResult($method, $hash) {
    }

    /**
     * Postcall.
     * 
     * @param string $method 
     * @param string $hash 
     * @param mixed $result 
     */
    protected function postExecution($method, $hash, $result) {
    }

    /**
     * Generates hash for method call. 
     * 
     * @param array $arguments 
     * @return string
     */
    protected function generateHash($arguments) {
        $hash = array();
        foreach($arguments as $argument) {
            if (is_array($argument)) {
                $hash[] = "array(".$this->generateHash($argument).")";
            } elseif (is_object($argument)) {
                $hash[] = spl_object_hash($argument);
            } else {
                $hash[] = $argument;
            }
        }
        $hash = implode(",", $hash);
        return $hash;
    }

}
