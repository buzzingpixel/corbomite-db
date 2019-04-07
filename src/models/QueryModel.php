<?php

declare(strict_types=1);

namespace corbomite\db\models;

use corbomite\db\interfaces\QueryModelInterface;

class QueryModel implements QueryModelInterface
{
    /** @var int */
    private $limit = 0;

    public function limit(?int $limit = null) : int
    {
        return $this->limit = $limit ?? $this->limit;
    }

    /** @var int */
    private $offset = 0;

    public function offset(?int $offset = null) : int
    {
        return $this->offset = $offset ?? $this->offset;
    }

    /** @var mixed[] */
    private $order = [];

    /**
     * @param mixed[] $order
     *
     * @return mixed[]|null
     */
    public function order(?array $order = null) : array
    {
        return $this->order = $order ?? $this->order;
    }

    public function addOrder(string $col, string $dir = 'desc') : void
    {
        $dir               = $dir === 'desc' ? 'desc' : 'asc';
        $this->order[$col] = $dir;
    }

    /** @var int */
    private $whereKey = 0;

    /** @var mixed[] */
    private $where = [];

    /**
     * @return mixed[]
     */
    public function where() : array
    {
        return $this->where;
    }

    /**
     * @param string|int|float|mixed[]|null $val
     */
    public function addWhere(string $col, $val, string $comparison = '=', bool $or = false) : void
    {
        $this->where[$this->whereKey]['wheres'][] = [
            'col' => $col,
            'val' => $val,
            'comparison' => $comparison,
            'operator' => $or ? 'OR' : 'AND',
        ];
    }

    public function addWhereGroup(bool $or = true) : void
    {
        $this->whereKey++;
        $this->where[$this->whereKey]['operator'] = $or ? 'OR' : 'AND';
        $this->where[$this->whereKey]['wheres']   = [];
    }
}
