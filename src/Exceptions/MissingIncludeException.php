<?php

namespace DictTransformer\Exceptions;

use Exception;

class MissingIncludeException extends Exception
{

    protected $message = "Transformer is missing the requested include method.";
}