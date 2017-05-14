<?php

namespace Test\Transformers;

use Test\Entities\Settlement;

class SettlementTransformer
{

    const KEY = 'settlements';

    /**
     * @param Settlement $settlement
     *
     * @return array
     */
    public function transform(Settlement $settlement) : array
    {
        return [
            'id'   => $settlement->getId(),
            'name' => $settlement->getName(),
        ];
    }
}