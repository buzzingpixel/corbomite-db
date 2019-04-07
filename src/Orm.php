<?php

declare(strict_types=1);

namespace corbomite\db;

use Atlas\Mapper\MapperLocator;
use Atlas\Mapper\MapperQueryFactory;
use Atlas\Orm\Atlas;
use Atlas\Orm\Transaction\AutoCommit;
use Atlas\Orm\Transaction\Transaction;
use Atlas\Pdo\ConnectionLocator;
use Atlas\Table\TableLocator;
use function array_pop;
use function end;
use function is_string;
use function is_subclass_of;

class Orm extends Atlas
{
    /**
     * @param mixed $args
     */
    public static function new(...$args) : Atlas
    {
        $transactionClass = AutoCommit::class;

        $end = end($args);
        if (is_string($end) && is_subclass_of($end, Transaction::class)) {
            $transactionClass = array_pop($args);
        }

        $connectionLocator = ConnectionLocator::new(...$args);

        $tableLocator = new TableLocator(
            $connectionLocator,
            new MapperQueryFactory()
        );

        return new self(
            new MapperLocator($tableLocator),
            new $transactionClass($connectionLocator)
        );
    }
}
