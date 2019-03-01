<?php
declare(strict_types=1);

namespace corbomite\tests\cli;

use PHPUnit\Framework\TestCase;
use corbomite\db\cli\SkeletonCliGenerator;
use corbomite\db\cli\GenerateSkeletonAction;

class GenerateSkeletonActionTest extends TestCase
{
    public function testAttribute()
    {
        $generator = $this->createMock(SkeletonCliGenerator::class);

        $generator->expects(self::once())
            ->method('__invoke')
            ->willReturn(null);

        $generateSkeletonAction = new GenerateSkeletonAction($generator);

        self::assertNull($generateSkeletonAction());
    }
}
