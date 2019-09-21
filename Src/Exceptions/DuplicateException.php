<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 14/09/2019
 * Time: 22:55
 */

namespace Mariska\Router\Exceptions;

use Exception;
use Throwable;

class DuplicateException extends Exception
{

    public function __construct(string $message = "Duplicate", int $code = 20, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}