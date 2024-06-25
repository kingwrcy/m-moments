<?php
use support\view\Twig;

return [
    'handler' => Twig::class,
    'options' => [
        'debug' => true,
        'charset' => 'utf-8',
        'view_suffix' => 'Twig'
    ]
];