<?php

declare(strict_types=1);

use Atlas\Cli\Config;
use Atlas\Cli\Fsio;
use Atlas\Cli\Logger;
use Atlas\Pdo\Connection;
use corbomite\db\cli\GenerateSkeletonAction;
use corbomite\db\cli\SkeletonCliGenerator;
use corbomite\db\Factory;
use corbomite\db\Orm;
use corbomite\db\PDO;
use corbomite\db\services\BuildQueryService;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

return [
    PDO::class => static function () {
        $dsnPrefix = getenv('DB_DSN_PREFIX') ?: 'mysql';
        $host      = getenv('DB_HOST') ?: 'localhost';
        $port      = getenv('DB_PORT') ?: '';
        $db        = getenv('DB_DATABASE');
        $cset      = getenv('DB_CHARSET') ?: 'utf8mb4';
        $user      = getenv('DB_USER');
        $pass      = getenv('DB_PASSWORD');

        $dsnArray = ['host=' . $host];

        if ($port && $port !== 'false') {
            $dsnArray[] = 'port=' . $port;
        }

        if ($db && $db !== 'false') {
            $dsnArray[] = 'dbname=' . $db;
        }

        if ($cset && $cset !== 'false') {
            $dsnArray[] = 'charset=' . $cset;
        }

        $dsn = $dsnPrefix . ':' . implode(';', $dsnArray);

        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    },
    Connection::class => static function (ContainerInterface $di) {
        return new Connection($di->get(PDO::class));
    },
    Orm::class => static function (ContainerInterface $di) {
        return Orm::new($di->get(Connection::class));
    },
    SkeletonCliGenerator::class => static function (ContainerInterface $di) {
        return new SkeletonCliGenerator(
            new Config([
                'pdo' => [$di->get(PDO::class)],
                'namespace' => getenv('CORBOMITE_DB_DATA_NAMESPACE'),
                'directory' => getenv('CORBOMITE_DB_DATA_DIRECTORY'),
            ]),
            new Fsio(),
            new Logger()
        );
    },
    GenerateSkeletonAction::class => static function (ContainerInterface $di) {
        return new GenerateSkeletonAction($di->get(SkeletonCliGenerator::class));
    },
    BuildQueryService::class => static function () {
        return new BuildQueryService(new Factory());
    },
    'UuidFactoryWithOrderedTimeCodec' => static function () {
        $uuidFactory = new UuidFactory();
        $uuidFactory->setCodec(
            new OrderedTimeCodec($uuidFactory->getUuidBuilder())
        );

        return $uuidFactory;
    },
];
