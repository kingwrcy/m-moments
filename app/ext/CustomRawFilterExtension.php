<?php

namespace app\ext;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CustomRawFilterExtension extends AbstractExtension {
	public function getFilters() {
		return [
			new TwigFilter('custom_raw', [$this, 'customRawFilter'], ['is_safe' => ['html']]),
		];
	}

	public function customRawFilter($content) {
		// 需要保留的标签
		$allowed_tags = '<div><p><code><img><h2><h3><h4><h5><h6><ul><ol><li><a><strong><em><span><br><hr><table><thead><tbody><tr><th><td>';

		return strip_tags($content, $allowed_tags);
	}
}