<?php

namespace Test\Transformers\Exceptions;

/**
 * @package App\Transformers
 */
class MissingIncludeTransformer
{

    const KEY = 'tiles';

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}