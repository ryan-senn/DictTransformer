<?php

namespace DictTransformer\Exceptions;

use Exception;

class InvalidResourceException extends Exception
{

    protected $message = "The given resource is invalid. Use either Item or Collection.";
}