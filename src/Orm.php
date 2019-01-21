<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db;

use Atlas\Orm\Atlas;
use Atlas\Table\TableLocator;
use Atlas\Pdo\ConnectionLocator;
use \Atlas\Mapper\MapperLocator;
use Atlas\Mapper\MapperQueryFactory;
use Atlas\Orm\Transaction\AutoCommit;
use Atlas\Orm\Transaction\Transaction;

class Orm extends Atlas
{
    public static function new(...$args): Atlas
    {
        $transactionClass = AutoCommit::CLASS;

        $end = end($args);
        if (is_string($end) && is_subclass_of($end, Transaction::CLASS)) {
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
