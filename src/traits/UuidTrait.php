<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db\services;

use corbomite\db\models\UuidModel;
use corbomite\db\interfaces\UuidModelInterface;

trait UuidTrait
{
    private $uuidModel;

    public function guid(?string $guid = null): string
    {
        if ($guid !== null) {
            $this->uuidModel = new UuidModel($guid);
        }

        if (! $this->uuidModel) {
            $this->uuidModel = new UuidModel();
        }

        return $this->uuidModel->toString();
    }

    public function guidAsModel(): UuidModelInterface
    {
        if (! $this->uuidModel) {
            $this->uuidModel = new UuidModel();
        }

        return $this->uuidModel;
    }

    public function getGuidAsBytes(): string
    {
        if (! $this->uuidModel) {
            $this->uuidModel = new UuidModel();
        }

        return $this->uuidModel->toBytes();
    }

    public function setGuidAsBytes(string $bytes): void
    {
        $this->uuidModel = UuidModel::fromBytes($bytes);
    }
}
