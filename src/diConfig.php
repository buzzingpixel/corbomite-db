<?php
declare(strict_types=1);

use corbomite\di\Di;
use corbomite\db\PDO;
use corbomite\db\Orm;

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
];
