<?php
declare(strict_types=1);

namespace corbomite\tests;

use PHPUnit\Framework\TestCase;
use corbomite\db\models\UuidModel;

class UuidModelTest extends TestCase
{
    public function testEqualsAndToString()
    {
        $uuidModel = new UuidModel();
        $uuidModel2 = new UuidModel($uuidModel->toString());
        $uuidModel3 = new UuidModel();

        self::assertTrue($uuidModel->equals($uuidModel2));

        self::assertTrue($uuidModel2->equals($uuidModel));

        self::assertFalse($uuidModel->equals($uuidModel3));

        self::assertFalse($uuidModel3->equals($uuidModel));

        self::assertNotEmpty($uuidModel->toBytes());

        $fromBytes = UuidModel::fromBytes($uuidModel->toBytes());

        self::assertTrue($uuidModel->equals($fromBytes));
    }
}
