<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db\interfaces;

use Atlas\Mapper\MapperSelect;

interface BuildQueryInterface
{
    /**
     * @param string $select
     * @param QueryModelInterface $fetchDataParams
     * @return MapperSelect
     * @see build()
     */
    public function __invoke(
        string $select,
        QueryModelInterface $fetchDataParams
    ): MapperSelect;

    /**
     * Builds the Atlas query
     *
     * @param string $select Should be a \Atlas\Mapper\Mapper extending class name string
     * @param QueryModelInterface $fetchDataParams
     * @return MapperSelect
     */
    public function build(
        string $select, QueryModelInterface $fetchDataParams
    ): MapperSelect;
}
