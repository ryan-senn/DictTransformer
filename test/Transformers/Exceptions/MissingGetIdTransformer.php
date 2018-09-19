<?php

namespace Test\Transformers\Exceptions;

/**
 * @package App\Transformers
 */
class MissingGetIdTransformer
{

    const KEY = 'fields';

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}