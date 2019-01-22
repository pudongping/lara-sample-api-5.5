<?php
/**
 * User: alex
 * Date: 2019-1-21
 */

namespace App\Exceptions;

use App\Models\Code;
use Exception;


class ApiException extends Exception{
    function __construct(int $code = 0, $params = null, $message = null)
    {
        Code::setCode($code, $message, $params);
        list($code, $msg) = Code::getCode();
        parent::__construct('api exception: ' . $msg);
    }
}