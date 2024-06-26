<?php

use app\ext\CustomRawFilterExtension;
use support\view\Twig;
use Twig\Environment;


return [
	'handler' => Twig::class,
	'extension' => function (Environment $twig) {
		$twig->addExtension(new CustomRawFilterExtension());
	},
	'options' => [
		'debug' => true,
		'charset' => 'utf-8',
		'view_suffix' => 'Twig'
	]
];