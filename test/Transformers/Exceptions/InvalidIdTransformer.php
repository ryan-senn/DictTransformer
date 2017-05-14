<?php

namespace Test\Transformers\Exceptions;

/**
 * @package App\Transformers
 */
class InvalidIdTransformer
{

    const KEY = 'fields';
    const ID = 'missing';

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}