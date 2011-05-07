<?php

/**
 * Application url template class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 *
 */
final class CoreUrlTemplate {

    /**
     * Url template.
     *
     * @var string
     */
    private $url;

    /**
     * Url default params.
     *
     * @var array
     */
    private $params;

    /**
     * Object constructor.
     */
    public function __construct($url, $defaultParams = array()) {
        $this->url = $url;
        $this->params = $this->normalize($defaultParams);
    }

    /**
     * Builds url.
     *
     * @param array $params
     */
    public function getUrl($params = array()) {
        $url = $this->url;
        $params = $this->normalize($params) + $this->params;
        preg_match_all("/:([a-z0-9]+)/", $url, $matches);
        foreach($matches[1] as $match) {
            if (!isset($params[$match])) {
                throw new CoreExceptionFramework("Undefined URL parameter: '{$match}'.");
            }
            $url = str_replace(":{$match}", $params[$match], $url);
        }
        return $url;
    }

    /**
     * Normalizes an array.
     *
     * @param array $params 
     */
    private function normalize($params) {
        if (empty($params)) {
            return array();
        }
        $names = array_keys($params);
        $values = array_values($params);
        array_walk($names, array($this, "normalizeName"));
        array_walk($values, array($this, "normalizeName"));
        return array_combine($names, $values);
    }

    /**
     * Normalizes single name.
     *
     * @param string $name
     */
    private function normalizeName(&$name) {
        $name = iconv("UTF-8", "ASCII//TRANSLIT", mb_strtolower($name, "UTF-8"));
        $name = preg_replace("/[^a-z0-9 ]/", "", $name);
        $name = preg_replace("/ +/", "-", $name);
        $name = trim($name, "-");
    }
}
