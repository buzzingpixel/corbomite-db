<?php
declare(strict_types=1);

namespace corbomite\db;

use corbomite\di\Di;

class Factory
{
    public function makeOrm(): Orm
    {
        return Di::make(Orm::class);
    }

    public function getPDO(): PDO
    {
        return Di::get(PDO::class);
    }
}
