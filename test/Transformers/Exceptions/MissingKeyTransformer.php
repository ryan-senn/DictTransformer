<?php

namespace Test\Transformers\Exceptions;

/**
 * @package App\Transformers
 */
class MissingKeyTransformer
{

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}