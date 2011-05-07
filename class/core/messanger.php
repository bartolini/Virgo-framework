<?php

/**
 * Session messanger.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
class CoreMessanger {

    /**
     * Error messages.
     *
     * @var array
     */
    private $errors = array();

    /**
     * Warning messages.
     *
     * @var array
     */
    private $warnings = array();

    /**
     * Infos messages.
     *
     * @var array
     */
    private $infos = array();

    /**
     * Returns true if there are any messages.
     *
     * @return boolean
     */
    public function isFull() {
        $messages = CoreSession::get("messages");
        return !empty($messages["errors"]) || !empty($messages["warnings"]) || !empty($messages["infos"]);
    }

    /**
     * Returns messages and flushes session.
     *
     * @return array
     */
    public function retrieve() {
        $messages = CoreSession::get("messages");
        CoreSession::delete("messages");
        return $messages;
    }

    /**
     * Adds a message.
     *
     * @param string $message
     */
    public function addError($message) {
        $this->errors[] = $message;
    }
    
    /**
     * Adds a message.
     *
     * @param string $message
     */
    public function addWarning($message) {
        $this->warnings[] = $message;
    }
    
    /**
     * Adds a message.
     *
     * @param string $message
     */
    public function addInfo($message) {
        $this->infos[] = $message;
    }

    /**
     * Object destructor.
     */
    public function __destruct() {
        CoreSession::set(
            "messages",
            array(
                "errors" => $this->errors,
                "warnings" => $this->warnings,
                "infos" => $this->infos,
            )
        );
    }

}
