<?php

namespace DictTransformer\Exceptions;

use Exception;

class MissingKeyException extends Exception
{

    protected $message = "Transformer is missing the KEY constant.";
}