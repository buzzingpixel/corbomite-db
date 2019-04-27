<?php

declare(strict_types=1);

namespace corbomite\db\interfaces;

interface DateFormats
{
    /**
     * Strangely, while Postgres can handle PHP's ISO 8601 representation (DateTime::ATOM) on input,
     * it spits out a modified version (without the T) on output. The format below can be used with
     * DateTime::createFromFormat() to convert to proper ISO 8601
     *
     * @see https://www.postgresql.org/docs/current/datatype-datetime.html#DATATYPE-DATETIME-OUTPUT
     */
    public const POSTGRES = 'Y-m-d H:i:sP';

    /**
     * MySQL's DateTime storage format is not compliant on input or output with ISO 8601
     * This string represents the format MySQL uses for input/output of DateTime
     */
    public const MYSQL = 'Y-m-d H:i:s';
}
