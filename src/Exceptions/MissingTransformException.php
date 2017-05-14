<?php

namespace DictTransformer\Exceptions;

use Exception;

class MissingTransformException extends Exception
{

    protected $message = "Transformer must implement a transform method.";
}