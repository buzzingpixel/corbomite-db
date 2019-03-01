<?php
declare(strict_types=1);

namespace corbomite\tests\traits;

use PHPUnit\Framework\TestCase;

class UuidTraitTest extends TestCase
{
    public function testOne(): void
    {
        $trait = new UsesUuidTrait();

        self::assertEquals($trait->guid(), $trait->guidAsModel()->toString());
    }

    public function testTwo(): void
    {
        $trait = new UsesUuidTrait();

        self::assertEquals($trait->guidAsModel()->toString(), $trait->guid());
    }

    public function testThree(): void
    {
        $trait = new UsesUuidTrait();

        $testGuid = $trait->guid();

        self::assertEquals($trait->guidAsModel()->toString(), $trait->guid());

        $trait = new UsesUuidTrait();

        self::assertEquals($trait->guid($testGuid), $trait->guidAsModel()->toString());
    }

    public function testFour(): void
    {
        $trait1 = new UsesUuidTrait();

        $trait2 = new UsesUuidTrait();

        $trait2->setGuidAsBytes($trait1->getGuidAsBytes());

        self::assertEquals($trait1->guid(), $trait2->guid());
    }
}
