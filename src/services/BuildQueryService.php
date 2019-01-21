<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db\services;

use corbomite\db\Factory;
use Atlas\Mapper\MapperSelect;
use corbomite\db\interfaces\QueryModelInterface;
use corbomite\db\interfaces\BuildQueryInterface;

class BuildQueryService implements BuildQueryInterface
{
    private $ormFactory;

    public function __construct(Factory $ormFactory)
    {
        $this->ormFactory = $ormFactory;
    }

    public function __invoke(
        string $select,
        QueryModelInterface $fetchDataParams
    ): MapperSelect {
        return $this->build($select, $fetchDataParams);
    }

    public function build(
        string $select,
        QueryModelInterface $fetchDataParams
    ): MapperSelect {
        $query = $this->ormFactory->makeOrm()->select($select);

        if ($limit = $fetchDataParams->limit()) {
            $query->limit($limit);
        }

        if ($offset = $fetchDataParams->offset()) {
            $query->offset($offset);
        }

        foreach ($fetchDataParams->order() as $col => $dir) {
            $query->orderBy($col . ' ' . $dir);
        }

        $firstWhere = true;

        foreach ($fetchDataParams->where() as $where) {
            if ($firstWhere) {
                $query->where('(');
            }

            if (! $firstWhere) {
                $query->catWhere(' ' . $where['operator'] . ' (');
            }

            $firstInnerWhere = true;

            foreach ($where['wheres'] as $val) {
                if (! $firstInnerWhere) {
                    $query->catWhere(' ' . $val['operator'] . ' ');
                }

                if (\is_array($val['val'])) {
                    $val['comparison'] = $val['comparison'] === '!=' ||
                    $val['comparison'] === 'NOT IN' ?
                        'NOT IN' :
                        'IN';
                }

                $query->catWhere(
                    $val['col'] . ' ' . $val['comparison'] . ' ',
                    $val['val']
                );

                $firstInnerWhere = false;
            }

            $query->catWhere(')');

            $firstWhere = false;
        }

        return $query;
    }
}
