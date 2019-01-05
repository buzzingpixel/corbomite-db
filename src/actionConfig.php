<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\db\GenerateSkeletonAction;

return [
    'db' => [
        'description' => 'Corbomite DB commands',
        'commands' => [
            'generate-skeleton' => [
                'description' => 'Generates the data skeleton',
                'class' => GenerateSkeletonAction::class,
            ],
        ],
    ],
];
