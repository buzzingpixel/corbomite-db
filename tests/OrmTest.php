<?php
declare(strict_types=1);

namespace corbomite\tests;

use corbomite\db\Orm;
use Atlas\Pdo\Connection;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    public function testAttribute()
    {
        $connection = $this->createMock(Connection::class);

        self::assertInstanceOf(
            Orm::class,
            Orm::new($connection, TransactionSubClass::class)
        );
    }
}
