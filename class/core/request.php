<?php

/**
 * HTTP request class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 **/
class CoreRequest {

    /**
     * Original request.
     *
     * @var string
     **/
    private $request = null;

    /**
     * Request constructor.
     **/
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Returns request parameter.
     *
     * @return string
     **/
    public function parameter()
    {
        $exploded = $this->exploded();
        return array_pop($exploded);
    }

    /**
     * Returns exploded request.
     *
     * @return array
     **/
    public function exploded()
    {
        return explode("/", ltrim($this->request, "/"));
    }

    /**
     * String representation.
     * Returns original request.
     *
     * @return string
     **/
    public function __toString()
    {
        return $this->request;
    }
}
