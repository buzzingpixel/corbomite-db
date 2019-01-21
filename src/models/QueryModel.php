<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db\models;

use corbomite\db\interfaces\QueryModelInterface;

class QueryModel implements QueryModelInterface
{
    private $limit = 0;

    public function limit(?int $limit = null): int
    {
        return $this->limit = $limit ?? $this->limit;
    }

    private $offset = 0;

    public function offset(?int $offset = null): int
    {
        return $this->offset = $offset ?? $this->offset;
    }

    private $order = [];

    public function order(?array $order = null): array
    {
        return $this->order = $order ?? $this->order;
    }

    public function addOrder(string $col, string $dir = 'desc'): void
    {
        $dir = $dir === 'desc' ? 'desc' : 'asc';
        $this->order[$col] = $dir;
    }

    private $whereKey = 0;
    private $where = [];

    public function where(): array
    {
        return $this->where;
    }

    public function addWhere(string $col, $val, string $comparison = '=', bool $or = false): void
    {
        $this->where[$this->whereKey]['wheres'][] = [
            'col' => $col,
            'val' => $val,
            'comparison' => $comparison,
            'operator' => $or ? 'OR' : 'AND',
        ];
    }

    public function addWhereGroup(bool $or = true): void
    {
        $this->whereKey++;
        $this->where[$this->whereKey]['operator'] = $or ? 'OR' : 'AND';
        $this->where[$this->whereKey]['wheres'] = [];
    }
}
