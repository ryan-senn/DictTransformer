<?php

namespace Test\Transformers;

use DictTransformer\NullableItem;
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

    /**
     * @param Field $field
     *
     * @return Item
     */
    public function settlement2(Field $field) : Item
    {
        $settlement2 = $field->getSettlement2();

        return new Item($settlement2, new Settlement2Transformer);
    }

    public function nullableSettlement(Field $field) : NullableItem
    {
        $nullableSettlement = $field->getSettlement();

        return new NullableItem($nullableSettlement, new SettlementTransformer);
    }
}