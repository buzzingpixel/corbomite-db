<?php

declare(strict_types=1);

namespace corbomite\db\interfaces;

interface UuidModelInterface
{
    /**
     * UuidModelInterface constructor takes a uuid string or creates one
     */
    public function __construct(?string $uuid = null);

    /**
     * Checks for equality
     */
    public function equals(UuidModelInterface $identity) : bool;

    /**
     * Returns the raw string UUID
     */
    public function toString() : string;

    /**
     * Converts the UUID string to a database optimized version of that string
     *
     * @see https://github.com/ramsey/uuid/wiki/Ramsey%5CUuid-Codecs#store-uuid-in-an-optimized-way-for-innodb-orderedtimecodec
     * @see https://www.percona.com/blog/2014/12/19/store-uuid-optimized-way/
     */
    public function toBytes() : string;

    /**
     * Creates a new instance from a db optimized UUID string
     *
     * @see https://github.com/ramsey/uuid/wiki/Ramsey%5CUuid-Codecs#store-uuid-in-an-optimized-way-for-innodb-orderedtimecodec
     * @see https://www.percona.com/blog/2014/12/19/store-uuid-optimized-way/
     */
    public static function fromBytes(string $bytes) : UuidModelInterface;
}
