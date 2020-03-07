<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.02.20
 * Time: 16:41
 */

namespace App\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class ApplicationException extends HttpException
{
    public function __construct(string $message, int $code, Exception $previous = null)
    {
        parent::__construct($code, $message, $previous);
    }
}