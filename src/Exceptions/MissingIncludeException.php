<?php

namespace DictTransformer\Exceptions;

use Exception;

class MissingIncludeException extends Exception
{

    public function __construct(string $transformer, string $include)
    {
        $message = "Transformer is missing the requested include method. Transformer: {$transformer}, Include: {$include}";

        parent::__construct($message);
    }
}