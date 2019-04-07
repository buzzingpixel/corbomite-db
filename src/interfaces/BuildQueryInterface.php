<?php

declare(strict_types=1);

namespace corbomite\db\interfaces;

use Atlas\Mapper\MapperSelect;

interface BuildQueryInterface
{
    /**
     * @see build()
     */
    public function __invoke(
        string $select,
        QueryModelInterface $fetchDataParams
    ) : MapperSelect;

    /**
     * Builds the Atlas query
     *
     * @param string $select Should be a \Atlas\Mapper\Mapper extending class name string
     */
    public function build(
        string $select,
        QueryModelInterface $fetchDataParams
    ) : MapperSelect;
}
