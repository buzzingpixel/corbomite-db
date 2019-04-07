<?php

declare(strict_types=1);

namespace corbomite\db\models;

use corbomite\db\Factory;
use corbomite\db\interfaces\UuidModelInterface;
use Ramsey\Uuid\UuidFactoryInterface;

class UuidModel implements UuidModelInterface
{
    /** @var string */
    private $uuid;

    /** @var UuidFactoryInterface */
    private $uuidFactory;

    public function __construct(?string $uuid = null)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->uuidFactory = (new Factory())->uuidFactoryWithOrderedTimeCodec();

        if ($uuid === null) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $this->uuid = $this->uuidFactory->uuid1()->toString();

            return;
        }

        // Ensure we've got a valid UUID according to RFC 4122 and strip
        // Any technically valid but undesired prefixes like urn:uuid:
        $this->uuid = $this->uuidFactory->fromString($uuid)->toString();
    }

    public function equals(UuidModelInterface $identity) : bool
    {
        return $this->toString() === $identity->toString();
    }

    public function toString() : string
    {
        return $this->uuid;
    }

    public function toBytes() : string
    {
        return $this->uuidFactory->fromString($this->toString())->getBytes();
    }

    public static function fromBytes(string $bytes) : UuidModelInterface
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var UuidFactoryInterface $uuidFactory */
        $uuidFactory = (new Factory())->uuidFactoryWithOrderedTimeCodec();

        return new static($uuidFactory->fromBytes($bytes)->toString());
    }
}
