<?php

declare(strict_types=1);

namespace corbomite\db\cli;

class GenerateSkeletonAction
{
    /** @var SkeletonCliGenerator */
    private $skeleton;

    public function __construct(SkeletonCliGenerator $skeleton)
    {
        $this->skeleton = $skeleton;
    }

    public function __invoke() : ?int
    {
        $skeleton = $this->skeleton;

        return $skeleton();
    }
}
