<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 14/09/2019
 * Time: 22:06
 */

namespace Mariska\Router\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct(string $message = "Not found", int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}