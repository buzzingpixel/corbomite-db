<?php

declare(strict_types=1);

namespace corbomite\db\traits;

use corbomite\db\interfaces\UuidModelInterface;
use corbomite\db\models\UuidModel;

trait UuidTrait
{
    /** @var ?UuidModel */
    private $uuidModel;

    public function guid(?string $guid = null) : string
    {
        if ($guid !== null) {
            $this->uuidModel = new UuidModel($guid);
        }

        if (! $this->uuidModel) {
            $this->uuidModel = new UuidModel();
        }

        return $this->uuidModel->toString();
    }

    public function guidAsModel() : UuidModelInterface
    {
        if (! $this->uuidModel) {
            $this->uuidModel = new UuidModel();
        }

        return $this->uuidModel;
    }

    public function getGuidAsBytes() : string
    {
        if (! $this->uuidModel) {
            $this->uuidModel = new UuidModel();
        }

        return $this->uuidModel->toBytes();
    }

    public function setGuidAsBytes(string $bytes) : void
    {
        $this->uuidModel = UuidModel::fromBytes($bytes);
    }
}
