<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 19.5.2019 г.
 * Time: 14:00
 */

namespace WatchApp\Services\Helpers;


use WatchApp\Exceptions\ApplicationException;

class HelperService
{
    public function safe_json_encode($value, $options = 0, $depth = 512, $utfErrorFlag = false)
    {
        $encoded = json_encode($value, $options, $depth);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                throw new ApplicationException('Maximum stack depth exceeded'); // or trigger_error() or throw new Exception()
            case JSON_ERROR_STATE_MISMATCH:
                throw new ApplicationException('Underflow or the modes mismatch'); // or trigger_error() or throw new Exception()
            case JSON_ERROR_CTRL_CHAR:
                throw new ApplicationException('Unexpected control character found');
            case JSON_ERROR_SYNTAX:
                throw new ApplicationException('Syntax error, malformed JSON'); // or trigger_error() or throw new Exception()
            case JSON_ERROR_UTF8:
                $clean = $this->utf8ize($value);
                if ($utfErrorFlag) {
                    throw new ApplicationException('UTF8 encoding error'); // or trigger_error() or throw new Exception()
                }

                return $this->safe_json_encode($clean, $options, $depth, true);
            default:
                throw new ApplicationException('Unknown error'); // or trigger_error() or throw new Exception()

        }
    }

    private function utf8ize($mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } else if (is_string ($mixed)) {
            return utf8_encode($mixed);
        }

        return $mixed;
    }
}