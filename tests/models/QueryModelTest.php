<?php
declare(strict_types=1);

namespace corbomite\tests\models;

use PHPUnit\Framework\TestCase;
use corbomite\db\models\QueryModel;

class QueryModelTest extends TestCase
{
    public function testLimit(): void
    {
        $model = new QueryModel();

        self::assertEquals(0, $model->limit());

        self::assertEquals(45, $model->limit(45));

        self::assertEquals(45, $model->limit());

        self::assertEquals(1234, $model->limit(1234));
    }

    public function testOffset(): void
    {
        $model = new QueryModel();

        self::assertEquals(0, $model->offset());

        self::assertEquals(48, $model->limit(48));

        self::assertEquals(48, $model->limit());

        self::assertEquals(678, $model->limit(678));
    }

    public function testOrder(): void
    {
        $model = new QueryModel();

        self::assertEquals([], $model->order());

        self::assertEquals(['test'], $model->order(['test']));

        self::assertEquals(['test'], $model->order());
    }

    public function testAddOrder(): void
    {
        $model = new QueryModel();

        $model->addOrder('colTest1');

        self::assertEquals(
            [
                'colTest1' => 'desc',
            ],
            $model->order()
        );

        $model->addOrder('colTest2', 'asc');

        self::assertEquals(
            [
                'colTest1' => 'desc',
                'colTest2' => 'asc',
            ],
            $model->order()
        );

        $model->addOrder('colTest3', 'asdf');

        self::assertEquals(
            [
                'colTest1' => 'desc',
                'colTest2' => 'asc',
                'colTest3' => 'asc',
            ],
            $model->order()
        );
    }

    public function testWhere(): void
    {
        $model = new QueryModel();

        self::assertEquals([], $model->where());

        $model->addWhere('testCol1', 'testVal1');

        self::assertEquals(
            [
                [
                    'wheres' => [
                        [
                            'col' => 'testCol1',
                            'val' => 'testVal1',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ],
                    ],
                ],
            ],
            $model->where()
        );

        $model->addWhere('testCol2', 'testVal2', '<');

        self::assertEquals(
            [
                [
                    'wheres' => [
                        [
                            'col' => 'testCol1',
                            'val' => 'testVal1',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ],
                        [
                            'col' => 'testCol2',
                            'val' => 'testVal2',
                            'comparison' => '<',
                            'operator' => 'AND',
                        ],
                    ],
                ],
            ],
            $model->where()
        );

        $model->addWhere('testCol3', 'testVal3', '!=', true);

        self::assertEquals(
            [
                [
                    'wheres' => [
                        [
                            'col' => 'testCol1',
                            'val' => 'testVal1',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ],
                        [
                            'col' => 'testCol2',
                            'val' => 'testVal2',
                            'comparison' => '<',
                            'operator' => 'AND',
                        ],
                        [
                            'col' => 'testCol3',
                            'val' => 'testVal3',
                            'comparison' => '!=',
                            'operator' => 'OR',
                        ],
                    ],
                ],
            ],
            $model->where()
        );


        $model->addWhereGroup();

        $model->addWhere('testCol3', 'testVal3');

        self::assertEquals(
            [
                [
                    'wheres' => [
                        [
                            'col' => 'testCol1',
                            'val' => 'testVal1',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ],
                        [
                            'col' => 'testCol2',
                            'val' => 'testVal2',
                            'comparison' => '<',
                            'operator' => 'AND',
                        ],
                        [
                            'col' => 'testCol3',
                            'val' => 'testVal3',
                            'comparison' => '!=',
                            'operator' => 'OR',
                        ],
                    ],
                ],
                [
                    'operator' => 'OR',
                    'wheres' => [
                        [
                            'col' => 'testCol3',
                            'val' => 'testVal3',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ]
                    ],
                ],
            ],
            $model->where()
        );

        $model->addWhereGroup(false);

        $model->addWhere('testCol4', 'testVal4');

        self::assertEquals(
            [
                [
                    'wheres' => [
                        [
                            'col' => 'testCol1',
                            'val' => 'testVal1',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ],
                        [
                            'col' => 'testCol2',
                            'val' => 'testVal2',
                            'comparison' => '<',
                            'operator' => 'AND',
                        ],
                        [
                            'col' => 'testCol3',
                            'val' => 'testVal3',
                            'comparison' => '!=',
                            'operator' => 'OR',
                        ],
                    ],
                ],
                [
                    'operator' => 'OR',
                    'wheres' => [
                        [
                            'col' => 'testCol3',
                            'val' => 'testVal3',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ]
                    ],
                ],
                [
                    'operator' => 'AND',
                    'wheres' => [
                        [
                            'col' => 'testCol4',
                            'val' => 'testVal4',
                            'comparison' => '=',
                            'operator' => 'AND',
                        ]
                    ],
                ],
            ],
            $model->where()
        );
    }
}
