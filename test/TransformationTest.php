<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use DictTransformer\DictTransformer;

use DictTransformer\Item;
use DictTransformer\Collection;

use Test\Entities\Tile;
use Test\Entities\Field;
use Test\Entities\Settlement;
use Test\Entities\Settlement2;

use Test\Transformers\TileTransformer;
use Test\Transformers\FieldTransformer;

class TransformationTest extends TestCase
{

    public function testItemWithNumbers()
    {
        $tile = new Tile(1, 1, 2);

        $data = (new DictTransformer)->transform(new Item($tile, new TileTransformer));

        $expected = [
            'result'   => 1,
            'entities' => [
                'tiles' => [
                    1 => [
                        'id' => 1,
                        'x'  => 1,
                        'y'  => 2,
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }

    public function testItemWithStrings()
    {
        $tile = new Tile('asd8A', 1, 2);

        $data = (new DictTransformer)->transform(new Item($tile, new TileTransformer));

        $expected = [
            'result'   => 'asd8A',
            'entities' => [
                'tiles' => [
                    'asd8A' => [
                        'id' => 'asd8A',
                        'x'  => 1,
                        'y'  => 2,
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }

    public function testCollectionWithNumbers()
    {
        $tiles = [
            new Tile(1, 1, 2),
            new Tile(2, 1, 3),
            new Tile(55, 3, 4),
        ];

        $data = (new DictTransformer)->transform(new Collection($tiles, new TileTransformer));

        $expected = [
            'result'   => [1, 2, 55],
            'entities' => [
                'tiles' => [
                    1  => [
                        'id' => 1,
                        'x'  => 1,
                        'y'  => 2,
                    ],
                    2  => [
                        'id' => 2,
                        'x'  => 1,
                        'y'  => 3,
                    ],
                    55 => [
                        'id' => 55,
                        'x'  => 3,
                        'y'  => 4,
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }

    public function testCollectionWithStrings()
    {
        $tiles = [
            new Tile('kdsJU7d', 1, 2),
            new Tile('hd7DG', 1, 3),
            new Tile('dsf54DFf', 3, 4),
        ];

        $data = (new DictTransformer)->transform(new Collection($tiles, new TileTransformer));

        $expected = [
            'result'   => ['kdsJU7d', 'hd7DG', 'dsf54DFf'],
            'entities' => [
                'tiles' => [
                    'kdsJU7d'  => [
                        'id' => 'kdsJU7d',
                        'x'  => 1,
                        'y'  => 2,
                    ],
                    'hd7DG'    => [
                        'id' => 'hd7DG',
                        'x'  => 1,
                        'y'  => 3,
                    ],
                    'dsf54DFf' => [
                        'id' => 'dsf54DFf',
                        'x'  => 3,
                        'y'  => 4,
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }

    public function testIncludeItem()
    {
        $settlement = new Settlement(19, 'Brisbane');
        $field = new Field(1, 10, $settlement);

        $data = (new DictTransformer)->transform(new Item($field, new FieldTransformer), ['settlement']);

        $expected = [
            'result'   => 1,
            'entities' => [
                'fields'      => [
                    1 => [
                        'id'         => 1,
                        'level'      => 10,
                        'settlement' => 19,
                    ],
                ],
                'settlements' => [
                    19 => [
                        'id'   => 19,
                        'name' => 'Brisbane',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }

    public function testIncludeCollection()
    {
        $fields = [
            new Field(1, 10),
            new Field(6, 5),
            new Field(77, 7),
        ];

        $tile = new Tile(4, 5, 6, $fields);

        $data = (new DictTransformer)->transform(new Item($tile, new TileTransformer), ['fields']);

        $expected = [
            'result'   => 4,
            'entities' => [
                'tiles'  => [
                    4 => [
                        'id'     => 4,
                        'x'      => 5,
                        'y'      => 6,
                        'fields' => [1, 6, 77],
                    ],
                ],
                'fields' => [
                    1  => [
                        'id'    => 1,
                        'level' => 10,
                    ],
                    6  => [
                        'id'    => 6,
                        'level' => 5,
                    ],
                    77 => [
                        'id'    => 77,
                        'level' => 7,
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }

    public function testNestedIncludes()
    {
        $settlement1 = new Settlement(4, 'Brisbane');
        $settlement2 = new Settlement('dsfdsf', 'Sydney');
        $settlement3 = new Settlement(8, 'Melbourne');

        $fields = [
            new Field(1, 10, $settlement1),
            new Field('Fjde3', 5, $settlement2),
            new Field(77, 7, $settlement3),
        ];

        $tile = new Tile(4, 5, 6, $fields);

        $data = (new DictTransformer)->transform(new Item($tile, new TileTransformer), ['fields.settlement']);

        $expected = [
            'result'   => 4,
            'entities' => [
                'tiles'       => [
                    4 => [
                        'id'     => 4,
                        'x'      => 5,
                        'y'      => 6,
                        'fields' => [1, 'Fjde3', 77],
                    ],
                ],
                'fields'      => [
                    1       => [
                        'id'         => 1,
                        'level'      => 10,
                        'settlement' => 4,
                    ],
                    'Fjde3' => [
                        'id'         => 'Fjde3',
                        'level'      => 5,
                        'settlement' => 'dsfdsf',
                    ],
                    77      => [
                        'id'         => 77,
                        'level'      => 7,
                        'settlement' => 8,
                    ],
                ],
                'settlements' => [
                    4        => [
                        'id'   => 4,
                        'name' => 'Brisbane',
                    ],
                    'dsfdsf' => [
                        'id'   => 'dsfdsf',
                        'name' => 'Sydney',
                    ],
                    8        => [
                        'id'   => 8,
                        'name' => 'Melbourne',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }

    public function testCollectionWithMultipleIncludes()
    {
        $settlement1 = new Settlement(4, 'Brisbane');
        $settlement2 = new Settlement('dsfdsf', 'Sydney');
        $settlement3 = new Settlement(8, 'Melbourne');

        $settlement10 = new Settlement2(5, 'Brisbane2');
        $settlement20 = new Settlement2('erttredsfdsf', 'Sydney2');
        $settlement30 = new Settlement2(99, 'Melbourne2');

        $fields = [
            new Field(1, 10, $settlement1, $settlement10),
            new Field('Fjde3', 5, $settlement2, $settlement20),
            new Field(77, 7, $settlement3, $settlement30),
        ];

        $tile = new Tile(4, 5, 6, $fields);

        $data = (new DictTransformer)->transform(new Item($tile, new TileTransformer), [
            'fields.settlement',
            'fields.settlement2',
        ]);

        $expected = [
            'result'   => 4,
            'entities' => [
                'tiles'        => [
                    4 => [
                        'id'     => 4,
                        'x'      => 5,
                        'y'      => 6,
                        'fields' => [1, 'Fjde3', 77],
                    ],
                ],
                'fields'       => [
                    1       => [
                        'id'          => 1,
                        'level'       => 10,
                        'settlement'  => 4,
                        'settlement2' => 5,
                    ],
                    'Fjde3' => [
                        'id'          => 'Fjde3',
                        'level'       => 5,
                        'settlement'  => 'dsfdsf',
                        'settlement2' => 'erttredsfdsf',
                    ],
                    77      => [
                        'id'          => 77,
                        'level'       => 7,
                        'settlement'  => 8,
                        'settlement2' => 99,
                    ],
                ],
                'settlements'  => [
                    4        => [
                        'id'   => 4,
                        'name' => 'Brisbane',
                    ],
                    'dsfdsf' => [
                        'id'   => 'dsfdsf',
                        'name' => 'Sydney',
                    ],
                    8        => [
                        'id'   => 8,
                        'name' => 'Melbourne',
                    ],
                ],
                'settlements2' => [
                    5              => [
                        'id'   => 5,
                        'name' => 'Brisbane2',
                    ],
                    'erttredsfdsf' => [
                        'id'   => 'erttredsfdsf',
                        'name' => 'Sydney2',
                    ],
                    99             => [
                        'id'   => 99,
                        'name' => 'Melbourne2',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $data);
    }
}