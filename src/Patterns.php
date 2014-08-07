<?php

namespace Example;

/**
 * This is a place to define regex patterns for RESTFul routes
 */
class Patterns {

    /**
     * This function has all of our patterns. 
     * Even though it's in 'nowdoc' format, you still have to escape
     * slashes e.g. \ must be \\\\ because there's a double decode
     * this data will be json_decoded to get a hash. 
     */
    static function getPatterns() {
        $patterns = <<<'PATTERNS'
        {
            "RE_DATE"            : "^(1[89][0-9]{2}|2[0-9]{3})[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$",
            "RE_TIMESTAMP"       : "^(1[89][0-9]{2}|2[0-9]{3})[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01]) ([01][0-9]|2[0-3])[:][0-5][0-9]:[0-5][0-9]$",
            "RE_NUMBER"          : "^[1-9][0-9]*$",
			"RE_ZERO_OR_ONE"	 : "^0|1$",
			"RE_NUMBER_0TO2"	 : "^[0-2]$",
			"RE_NUMBER_0TO9"	 : "^[0-9]$",
			"RE_NUMBER_0TO99"	 : "^[0-9]{0,2}$",
			"RE_NUMBER_0TO999"	 : "^[0-9]{0,3}$",
            "RE_NUMBER_ADD"      : "[\\\\-]{0,1}[0-9]{1,6}",
			"RE_NUMBER_1TO30"	 : "^[1-9]|[12][0-9]|30$",
			"RE_NUMBER_1TO39"	 : "^[1-9]|[12][0-9]|3[0-9]$",
			"RE_PRINTABLE_CHARS" : "^[:print:]+$",
			"RE_SINGLE_CHAR"	 : "^[A-Za-z]$",
			"RE_TRUE_FALSE"		 : "^(true|TRUE|false|FALSE)$",
			"RE_WORD"			 : "^[\\\\w+]\\\\s*$",
			"RE_WORDS_COMMA_SEP" : "^\\\\w+[,]?+$"
        }
PATTERNS;

        return $patterns;
    }

    /**
     * Take a json string and convert it to a PHP hash
     * @return hash of patterns.
     */
    static function getPatternsHash() {
        $p = self::getPatterns();
        $hash = json_decode($p, true);
        if (json_last_error() == 0) {
            return $hash;
        }
        $m = null;
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                break;
            case JSON_ERROR_DEPTH:
                $m = 'Maximum stack depth exceeded.';
            case JSON_ERROR_STATE_MISMATCH:
                $m = 'Underflow or the modes mismatch.';
            case JSON_ERROR_CTRL_CHAR:
                $m = 'Unexpected control character found.';
            case JSON_ERROR_SYNTAX:
                $m = 'Syntax error, malformed JSON.';
            case JSON_ERROR_UTF8:
                $m = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            default:
                $m = 'Unknown error.';
        }

        if (!empty($m)) {
            throw new \Exception("JSON Parsing error: $m");
        }
    }
}