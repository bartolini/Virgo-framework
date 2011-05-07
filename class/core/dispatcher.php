<?php

/**
 * WWW dispatcher class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 * 
 */
class CoreDispatcher {

    /**
     * Max no. of delegations.
     */
    const MAX_DELEGATIONS = 10;

    /**
     * Wildcards for requests.
     *
     * @var array
     */
    private static $wildcards = array(
        '*' => '[a-z0-9_-]*',
        '+' => '[a-z0-9_-]+',
        '%s' => '[a-z]+',
        '%d' => '[0-9]+',
    );

    /**
     * Preprocess functions for request.
     *
     * @var array
     */
    private static $preprocess = array();

    /**
     * Adds a wildcard for url parsing. 
     * 
     * @param string $wildcard 
     * @param string $regexp 
     */
    public static function addWildcard($wildcard, $regexp) {
        self::$wildcards[$wildcard] = $regexp;
    }

    /**
     * Adds a url preprocess function.
     * 
     * @param function $function 
     */
    public static function addPreprocess($function) {
        self::$preprocess[] = $function;
    }

    /**
     * Constructor.
     */
    public function __construct() {
        // checking the request:
        preg_match('/^[^.?]*/', $_SERVER["REQUEST_URI"], $request);
        $pageRequest = strtolower($request[0]);

        // url preprocessing:
        foreach(self::$preprocess as $function) {
            $pageRequest = $function($pageRequest);
        }

        // loading pages map:
        $pagesInitData = parse_ini_file(CoreConfig::object()->pagesMap);

        // matching page class:
        foreach ($pagesInitData as $pageClass => $urlPattern) {
            $wildcardPatterns = array_keys(self::$wildcards);
            $wildcardRegexps = array_values(self::$wildcards);
            $wildcardPatterns[] = "/";
            $wildcardRegexps[] = "\/";
            $urlPattern = str_replace(
                $wildcardPatterns, $wildcardRegexps, $urlPattern
            );
            if (preg_match("/^{$urlPattern}$/", $pageRequest)) {
                $pageClassName = $pageClass;
                break;
            }
        }

        // if page class has not been found use 404 page:
        if (!isset($pageClassName)) {
            header("HTTP/1.0 404 Not Found");
            $pageClassName = CoreConfig::object()->page404;
        }

        // init and render page:
        $delegations = 0;
        do {
            $delegated = false;
            try {
                $page = new $pageClassName();
                $page->setRequest($pageRequest);
                $page->render();
            } catch (CoreExceptionDelegate $exception) {
                if ($delegations > self::MAX_DELEGATIONS) {
                    throw new CoreExceptionFramework("Max delegations of ".self::MAX_DELEGATIONS." reached!");
                }
                $delegations++;
                $delegated = true;
                $pageClassName = $exception->getMessage();
            } catch (CoreExceptionRedirect $exception) {
                header("Location: ".$exception->getMessage());
                die();
            } catch (CoreExceptionReload $exception) {
                header("Location: ".$pageRequest);
                die();
            }
        } while ($delegated);
    }

}
