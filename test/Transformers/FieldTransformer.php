<?php

namespace Test\Transformers;

use Test\Entities\Field;

use DictTransformer\Item;

/**
 * @package App\Transformers
 */
class FieldTransformer
{

    const KEY = 'fields';

    /**
     * @param Field $field
     *
     * @return array
     */
    public function transform(Field $field) : array
    {
        return [
            'id'    => $field->getId(),
            'level' => $field->getLevel(),
        ];
    }

    /**
     * @param Field $field
     *
     * @return Item
     */
    public function settlement(Field $field) : Item
    {
        $settlement = $field->getSettlement();

        return new Item($settlement, new SettlementTransformer);
    }
}