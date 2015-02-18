<?php

namespace Example;
use Rust\HTTP\ResponseCodes;

class Controller {

    // define our features
    static $features = array('route_func'=>'getRoutesArray');

    /**
     * run method accepts path and params to aid testing
     * outside of a web request.
     * @param path - a url to test with 
     * @param params - a hash of name value pairs
     * @return array if the output method is null in your route configuration
     */
    function run($path=null,$params=null) {
        $controller = new \Rust\Service\Controller();
        $routes = self::getRoutes();
        $result = $controller->run($routes, $path, $params);
    }

    /**
     * Function to fetch a features. 
     */
    public function getFeature($feature) {
        if (empty($feature) || is_string($feature) === FALSE) {
            throw new \Exception("The getFeature method requires a string key as an argument");
        }
        $value = self::$features[$feature];
        if (empty($value)) {
            throw new \Exception("The feature request is missing. There must be a configuration problem or a code bug.");
        }
        return $value;
    }

    /**
     * Test a feature and call the desired routes function
     */
    public function getRoutes() {
        $method = $this->getFeature('route_func');
        if (!method_exists($this, $method)) {
            throw new \Exception('The method configured does not exist. method: ' . $method);
        }
        $routes = $this->$method();
        return $routes;
    }

    /**
     * Here is an example defining routes using php's array syntax
     */
    public function getRoutesArray() {
        $pat    = Patterns::getPatternsHash();
        $routes = array(
            'std_out'=> 'Rust\\Output\\JsonOutput',
            'std_err'=> 'Rust\\Output\\JsonError',
            'name'   => 'Example Rust RESTFul API',
            'docs'   => 'This api is an example',
            'routes' => array(
                array(
                    'rule'  => ";^/svc/example/add/({$pat['RE_NUMBER_ADD']})/({$pat['RE_NUMBER_ADD']}).json$;",
                    'name'  => 'Add two numbers',
                    'params'=> array('script_path','lhand','rhand'),
                    'action'=> 'GET',
                    'class' => 'Example\\Addition',
                    'method'=> 'addTwoNumbers',
                    'docs'  => 'Add two numbers of 1 to 6 digits'
                    )
                )
            );
        return $routes;
    }

    /**
     * Here is an example using php's "nowdoc" format.
     * It's nice to do but there are some caveates. If you go this route
     * you need to double encode the \ because when the "nowdoc" is put
     * into the $routes variable \\\\ will become \\. The call to 
     * json_decode requires \\ so that foo\\bar will be viewed as \. 
     * Also, don't swap " for ' because proper json uses " 
     */
    public static function getRoutesNowdoc() {
        $p      = new Patterns();
        $pat    = json_decode($p->getPatterns(), true);
        $routes = <<<ROUTE_DEFINITION
            {
                "std_out": "Rust\\\\Output\\\\JsonOutput",
                "std_err": "Rust\\\\Output\\\\JsonError",
                "name"   : "Example Rust RESTFul API",
                "docs"   : "This api is an example",
                "routes":[
        {
            "rule"  : ";^/svc/example/add/({$pat['RE_NUMBER_ADD']})/({$pat['RE_NUMBER_ADD']}).json$;",
            "name"  : "Add two numbers",
            "params": ["script_path","lhand","rhand"],
            "action": "GET",
            "class" : "Example\\\\Addition",
            "method": "addTwoNumbers",
            "docs"  : "Add two numbers of 1 to 6 digits"
        }]
            }
        ROUTE_DEFINITION;

        $rts = json_decode($routes,true);
        if (json_last_error() == 0) {
            return $rts;
        }
        
        $m = "Route definition issue ";
        switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $m .= ' - No errors';
            break;
        case JSON_ERROR_DEPTH:
            $m .= ' - Maximum stack depth exceeded';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $m .= ' - Underflow or the modes mismatch';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $m .= ' - Unexpected control character found';
            break;
        case JSON_ERROR_SYNTAX:
            $m .= ' - Syntax error, malformed JSON';
            break;
        case JSON_ERROR_UTF8:
            $m .= ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
        default:
            $m .= ' - Unknown error';
            break;
       
        }
        $m .= ".\n FIX THIS ROUTE DEFINITION:\n";
        throw new \Exception($m);
    }
}