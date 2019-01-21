<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db;

use corbomite\di\Di;
use corbomite\db\models\QueryModel;
use corbomite\db\interfaces\QueryModelInterface;

class Factory
{
    public function makeOrm(): Orm
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Di::make(Orm::class);
    }

    public function getPDO(): PDO
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Di::get(PDO::class);
    }

    public function makeQueryModel(): QueryModelInterface
    {
        return new QueryModel();
    }
}
