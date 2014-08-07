<?php

namespace Example;
use Rust\HTTP\ResponseCodes;

class Addition {

    function __construct() {

    }

    /**
     * The framework will call us with our expected parameter names.
     * Since the framework will validate the input we can safely 
     * use these values.
     */
    function addTwoNumbers($params) {
        return $this->add($params['lhand'], $params['rhand']);
    }

    /**
     * A function to add two numbers.
     *
     * @param $lhand - some positive or negative whole number
     * @param $rhand - some positive or negative whole number
     * @return array[200|500] with value or error message
     */
    function add($lhand, $rhand) {
        $result = array();
        try {
            $result[ResponseCodes::GOOD] = array('result'=>($lhand + $rhand));
        } catch (\Exception $e) {
            $result[ResponseCodes::ERROR] = array('failure'=>print_r($e,true));
        }
        return $result;
        //return array(200=>"'stuf'");
    }
}