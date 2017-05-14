<?php

namespace DictTransformer\Exceptions;

use Exception;

class InvalidIdException extends Exception
{

    protected $message = "Data does not contain the configured ID.";
}