<?php
declare(strict_types=1);

namespace corbomite\tests\services;

use corbomite\db\Orm;
use corbomite\db\Factory;
use Atlas\Mapper\MapperSelect;
use PHPUnit\Framework\TestCase;
use corbomite\db\models\QueryModel;
use corbomite\db\services\BuildQueryService;

class BuildQueryServiceTest extends TestCase
{
    public function testBuild(): void
    {
        $mapperSelect = $this->createMock(MapperSelect::class);

        $mapperSelect->expects(self::once())
            ->method('limit')
            ->with(self::equalTo(2));

        $mapperSelect->expects(self::once())
            ->method('offset')
            ->with(self::equalTo(34));

        $mapperSelect->expects(self::exactly(2))
            ->method('orderBy')
            ->with(self::logicalOr(
                self::equalTo('testOrderCol1 desc'),
                self::equalTo('testOrderCol2 asc')
            ));

        $orm = $this->createMock(Orm::class);

        $orm->expects(self::once())
            ->method('select')
            ->willReturn($mapperSelect);

        $ormFactory = $this->createMock(Factory::class);

        $ormFactory->expects(self::once())
            ->method('makeOrm')
            ->willReturn($orm);

        $service = new BuildQueryService($ormFactory);

        $fetchParams = new QueryModel();
        $fetchParams->limit(2);
        $fetchParams->offset(34);
        $fetchParams->addOrder('testOrderCol1');
        $fetchParams->addOrder('testOrderCol2', 'asc');
        $fetchParams->addWhere('testCol1', 'testVal1');
        $fetchParams->addWhere('testCol2', 'testVal2', '<');
        $fetchParams->addWhere('testCol3', 'testVal3', '!=', true);
        $fetchParams->addWhereGroup();
        $fetchParams->addWhere('testCol3', 'testVal3');
        $fetchParams->addWhereGroup(false);
        $fetchParams->addWhere('testCol4', 'testVal4');
        $fetchParams->addWhere('testCol5', [
            'asdf',
            'thing'
        ]);
        $fetchParams->addWhere(
            'testCol6',
            [
                'asdf',
                'thing'
            ],
            '!='
        );

        $service('testSelect', $fetchParams);
    }
}
