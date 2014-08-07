<?php

namespace Example;
use Rust\HTTP\ResponseCodes;

class Controller {

    /**
     * run method accepts path and params to aid testing
     * outside of a web request.
     * @param path - a url to test with 
     * @param params - a hash of name value pairs
     * @return array if the output method is null in your route configuration
     */
    function run($path=null,$params=null) {
        $controller = new \Rust\Service\Controller;
        $routes = self::getRoutes();
		$result = $controller->run($routes, $path, $params);
        print_r("here\n");
    }

    /**
     * Done using "nowdoc" format where the contents are NOT parsed at all.
     * Don't swap " for ' because proper json uses " 
     */
    public static function getRoutes() {
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
        echo "Route definition issue ";
        switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
            break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
            break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
            break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
        default:
            echo ' - Unknown error';
            break;
       
        }
        echo ".\n FIX THIS ROUTE DEFINITION:\n";
        print_r($routes);
        exit(1);
    }
    
}