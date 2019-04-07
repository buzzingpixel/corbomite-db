<?php

declare(strict_types=1);

namespace corbomite\db\services;

use Atlas\Mapper\MapperSelect;
use corbomite\db\Factory;
use corbomite\db\interfaces\BuildQueryInterface;
use corbomite\db\interfaces\QueryModelInterface;
use function is_array;

class BuildQueryService implements BuildQueryInterface
{
    /** @var Factory */
    private $ormFactory;

    public function __construct(Factory $ormFactory)
    {
        $this->ormFactory = $ormFactory;
    }

    public function __invoke(
        string $select,
        QueryModelInterface $fetchDataParams
    ) : MapperSelect {
        return $this->build($select, $fetchDataParams);
    }

    public function build(
        string $select,
        QueryModelInterface $fetchDataParams
    ) : MapperSelect {
        $query = $this->ormFactory->makeOrm()->select($select);

        $limit = $fetchDataParams->limit();

        if ($limit) {
            $query->limit($limit);
        }

        $offset = $fetchDataParams->offset();

        if ($offset) {
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

                if (is_array($val['val'])) {
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
