<?php

use app\ext\CustomRawFilterExtension;
use support\view\Twig;
use Twig\Environment;
use Twig\TwigFilter;


return [
	'handler' => Twig::class,
	'extension' => function (Environment $twig) {
//		$twig->addExtension(new CustomRawFilterExtension());
		$twig->addFilter(new TwigFilter('timeAgo', 'timeAgo'));
	},
	'options' => [
		'debug' => true,
		'charset' => 'utf-8',
		'view_suffix' => 'Twig'
	]
];