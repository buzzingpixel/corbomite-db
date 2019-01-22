<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use Atlas\Cli\Fsio;
use corbomite\di\Di;
use corbomite\db\PDO;
use corbomite\db\Orm;
use Atlas\Cli\Config;
use Atlas\Cli\Logger;
use corbomite\db\Factory;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use corbomite\db\cli\SkeletonCliGenerator;
use corbomite\db\services\BuildQueryService;
use corbomite\db\cli\GenerateSkeletonAction;

return [
    PDO::class => function () {
        $host = getenv('DB_HOST');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASSWORD');
        $cset = 'utf8mb4';

        $dsn = 'mysql:host=' . $host . ';dbname=' . $db . ';charset=' . $cset;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $user, $pass, $options);
    },
    Orm::class => function () {
        return Orm::new(Di::get(PDO::class));
    },
    SkeletonCliGenerator::class => function () {
        return new SkeletonCliGenerator(
            new Config([
                'pdo' => [Di::get(PDO::class)],
                'namespace' => getenv('CORBOMITE_DB_DATA_NAMESPACE'),
                'directory' => getenv('CORBOMITE_DB_DATA_DIRECTORY'),
            ]),
            new Fsio(),
            new Logger()
        );
    },
    GenerateSkeletonAction::class => function () {
        return new GenerateSkeletonAction(Di::get(SkeletonCliGenerator::class));
    },
    BuildQueryService::class => function () {
        return new BuildQueryService(new Factory());
    },
    'UuidFactoryWithOrderedTimeCodec' => function () {
        $uuidFactory = new UuidFactory();
        $uuidFactory->setCodec(
            new OrderedTimeCodec($uuidFactory->getUuidBuilder())
        );

        return $uuidFactory;
    },
];
