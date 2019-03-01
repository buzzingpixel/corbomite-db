<?php
declare(strict_types=1);

namespace corbomite\tests;

use Atlas\Mapper\Mapper;
use Atlas\Mapper\Record;
use Atlas\Orm\Transaction\Transaction;

class TransactionSubClass extends Transaction
{
    public function read(Mapper $mapper, string $method, array $params)
    {
    }

    public function write(Mapper $mapper, string $method, Record $record): void
    {
    }
}
