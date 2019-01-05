<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\db;

class GenerateSkeletonAction
{
    private $skeleton;

    public function __construct(SkeletonCliGenerator $skeleton)
    {
        $this->skeleton = $skeleton;
    }

    public function __invoke(): ?int
    {
        $skeleton = $this->skeleton;
        return $skeleton();
    }
}
