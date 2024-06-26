<?php

namespace app\middleware;

use support\View;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class Auth implements MiddlewareInterface {
	public function process($request, $handler): Response {
		if (session('user')) {
			View::assign('currentUser', session('user'));
		}
		return $handler($request);
	}
}