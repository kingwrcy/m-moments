<?php

namespace app\middleware;

use ReflectionClass;
use support\Log;
use support\View;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class Auth implements MiddlewareInterface {
	/**
	 * @throws \ReflectionException
	 */
	public function process($request, $handler): Response {
		View::assign('path', $request->path());
		if (session('user')) {
			View::assign('currentUser', session('user'));
		}

		$controller = new ReflectionClass($request->controller);
		$noNeedLogin = $controller->getDefaultProperties()['noNeedLogin'] ?? [];

		if (!in_array($request->action, $noNeedLogin) && !session('user')) {
			Log::info("redirect");
			return redirect('/user/login');
		}

		return $handler($request);
	}
}