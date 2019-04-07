<?php

declare(strict_types=1);

namespace corbomite\db;

use Atlas\Orm\Atlas;
use Atlas\Pdo\Connection;
use corbomite\db\interfaces\QueryModelInterface;
use corbomite\db\models\QueryModel;
use corbomite\db\services\BuildQueryService;
use corbomite\di\Di;
use Ramsey\Uuid\UuidFactory;

class Factory
{
    public function makeOrm() : Atlas
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Orm::new(Di::diContainer()->get(Connection::class));
    }

    public function getPDO() : PDO
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Di::diContainer()->get(PDO::class);
    }

    public function connection() : Connection
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Di::diContainer()->get(Connection::class);
    }

    public function makeQueryModel() : QueryModelInterface
    {
        return new QueryModel();
    }

    public function buildQueryService() : BuildQueryService
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Di::diContainer()->get(BuildQueryService::class);
    }

    public function uuidFactoryWithOrderedTimeCodec() : UuidFactory
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Di::diContainer()->get('UuidFactoryWithOrderedTimeCodec');
    }
}
