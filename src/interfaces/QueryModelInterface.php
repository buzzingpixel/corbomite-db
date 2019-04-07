<?php

declare(strict_types=1);

namespace corbomite\db\interfaces;

interface QueryModelInterface
{
    /**
     * Returns the value of limit. Sets value if incoming argument is set
     */
    public function limit(?int $limit = null) : int;

    /**
     * Returns the value of offset. Sets value if incoming argument is set
     */
    public function offset(?int $offset = null) : int;

    /**
     * Gets an array of order params.  Sets value if incoming argument is set.
     *
     * @param mixed[]|null $order
     *
     * @return mixed[]
     * The return array should be formatted as:
     * [
     *     'col_name' => 'sort_dir',
     *     'another_col_name' => 'sort_dir',
     * ]
     */
    public function order(?array $order = null) : array;

    /**
     * Adds order param
     *
     * @param string $dir Should be only 'desc' or 'asc'
     */
    public function addOrder(string $col, string $dir = 'desc') : void;

    /**
     * Returns where params.
     *
     * @return mixed[]
     * The array should be formatted as:
     * [
     *     [
     *         'wheres' => [
     *             [
     *                 'col' => 'guid',
     *                 'val' => '',
     *                 'comparison' => '!=',
     *                 'operator' => 'AND',
     *             ],
     *         ],
     *     ],
     *     [
     *         'operator' => 'AND',
     *         'wheres' => [
     *             [
     *                 'col' => 'title',
     *                 'val' => 'This is a test',
     *                 'comparison' => '=',
     *                 'operator' => 'AND',
     *             ],
     *             [
     *                 'col' => 'slug',
     *                 'val' => 'this-is-a-test',
     *                 'comparison' => '=',
     *                 'operator' => 'OR',
     *             ],
     *         ],
     *     ],
     * ]
     */
    public function where() : array;

    /**
     * Adds a where param
     *
     * @param string|int|float|mixed[]|null $val
     * Array should produce WHERE col IN query
     * @param string                        $comparison
     * Any MySQL comparison operator. If val is array, builder should convert
     * != into NOT IN, otherwise do IN
     *
     * @return mixed
     */
    public function addWhere(string $col, $val, string $comparison = '=', bool $or = false) : void;

    /**
     * Starts a new where group
     *
     * @return mixed
     */
    public function addWhereGroup(bool $or = true) : void;
}
