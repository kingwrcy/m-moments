<?php

use app\ext\CustomRawFilterExtension;
use support\view\Twig;
use Twig\Environment;
use Twig\TwigFilter;


return [
	'handler' => Twig::class,
	'extension' => function (Environment $twig) {
		$twig->addFilter(new TwigFilter('timeAgo', 'timeAgo'));
		$twig->addFunction(new \Twig\TwigFunction('getStaticPath', function (string $path) {
			return (getenv("STATIC_ASSET_CDN") ?? '') . $path;
		}));
	},
	'options' => [
		'debug' => true,
		'charset' => 'utf-8',
		'view_suffix' => 'Twig'
	]
];