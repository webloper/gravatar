<?php

/**
 * Gravatar Exception Class
 *
 * @package   Gravatar
 * @author    Ravi Kumar
 * @version   0.1.0
 * @copyright Copyright (c) 2014, Ravi Kumar
 * @license   https: //github.com/webloper/gravatar/blob/master/LICENSE MIT
 **/
namespace Webloper\Gravatar\Exception;

use Webloper\Gravatar\Exception;

class EmailRequiredException extends Exception
{
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        if (empty($message)) {
            $message = 'Email is required.';
        }
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
