<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db\models;

use corbomite\di\Di;
use Ramsey\Uuid\UuidFactoryInterface;
use corbomite\db\interfaces\UuidModelInterface;

class UuidModel implements UuidModelInterface
{
    private $uuid;

    /** @var UuidFactoryInterface $uuidFactory */
    private $uuidFactory;

    public function __construct(?string $uuid = null)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->uuidFactory = Di::get('UuidFactoryWithOrderedTimeCodec');

        if ($uuid === null) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $this->uuid = $this->uuidFactory->uuid1()->toString();
            return;
        }

        // Ensure we've got a valid UUID according to RFC 4122 and strip
        // Any technically valid but undesired prefixes like urn:uuid:
        $this->uuid = $this->uuidFactory->fromString($uuid)->toString();
    }

    public function equals(UuidModelInterface $identity): bool
    {
        return $this->toString() === $identity->toString();
    }

    public function toString(): string
    {
        return $this->uuid;
    }

    public function toBytes(): string
    {
        return $this->uuidFactory->fromString($this->toString())->getBytes();
    }

    public static function fromBytes(string $bytes): UuidModelInterface
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var UuidFactoryInterface $uuidFactory */
        $uuidFactory = Di::get('UuidFactoryWithOrderedTimeCodec');
        return new static($uuidFactory->fromBytes($bytes)->toString());
    }
}
