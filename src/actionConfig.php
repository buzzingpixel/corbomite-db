<?php

declare(strict_types=1);

use corbomite\db\cli\GenerateSkeletonAction;

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
