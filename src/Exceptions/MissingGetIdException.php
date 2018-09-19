<?php

namespace DictTransformer\Exceptions;

use Exception;

class MissingGetIdException extends Exception
{

    protected $message = "Entity does not have a getId method.";
}