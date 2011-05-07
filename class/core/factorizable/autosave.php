<?php

/**
 * Factorizable object with autosave.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
abstract class CoreFactorizableAutosave extends CoreFactorizable {

    /**
     * Turns autosave on/off.
     *
     * @var boolean
     */
    protected $autosave = false;

    /**
     * Data changed flag.
     *
     * @var boolean
     */
    protected $dataChanged = false;

    /**
     * Destructor.
     */
    public function __destruct() {
        if ($this->autosave && $this->dataChanged) {
            $this->saveData();
        }
    }

    /**
     * Automagic setter.
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        parent::__set($name, $value);
        $this->dataChanged = true;
    }

    /**
     * Sets object data.
     *
     * @param array $data
     */
    public function setData($data) {
        parent::setData($data);
        $this->dataChanged = true;
    }

    /**
     * Saves object and sets flag.
     */
    public function save() {
        $this->saveData();
        $this->dataChanged = false;
    }

    /**
     * Abstract method - actual data saving.
     */
    protected abstract function saveData() {
    }

}
