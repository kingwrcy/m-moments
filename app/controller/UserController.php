<?php

namespace app\controller;

use app\model\User;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;
use support\Request;
use support\Response;

class UserController {


	public function logout(Request $request): Response {
		$request->session()->forget('user');
		return redirect('/');
	}

	public function reg(Request $request): Response {
		return view('default/user/reg');
	}

	public function doReg(Request $request): Response {
		try {
			v::input($request->post(), [
				'username' => v::alnum()->length(3, 12)->setName('用户名'),
				'password' => v::stringVal()->length(5, 20)->setName('密码'),
				'email' => v::email()->length(5, 64)->setName('邮箱')
			]);
		} catch (ValidationException $exception) {
			return view('default/user/reg', [
				'exception' => $exception->getMessage(),
				'data' => $request->post()
			]);
		}
		$data = $request->post();
		if ($data['password'] !== $data['repeatPassword']) {
			return view('default/user/reg', [
				'exception' => '密码 两次密码不一致',
				'data' => $request->post()
			]);
		}
		$user = User::where('username', $data['username'])->first();
		if ($user) {
			return view('default/user/reg', [
				'exception' => '用户名 已存在',
				'data' => $data
			]);
		}
		User::create([
			'username' => $data['username'],
			'password' => password_hash($data['password'], PASSWORD_BCRYPT),
			'email' => $data['email'],
			'nickname' => $data['username'],
		]);

		return view('default/user/reg', ['message' => '注册成功,快去登录吧！']);
	}

	public function login(Request $request): Response {
		return view('default/user/login');
	}

	public function doLogin(Request $request): Response {
		try {
			v::input($request->post(), [
				'username' => v::alnum()->length(3, 12)->setName('用户名'),
				'password' => v::stringVal()->length(5, 20)->setName('密码'),
			]);
		} catch (ValidationException $exception) {
			return view('default/user/login', [
				'exception' => $exception->getMessage(),
				'data' => $request->post()
			]);
		}
		$data = $request->post();
		$user = User::where('username', $data['username'])->first();
		if (!$user) {
			return view('default/user/login', [
				'exception' => '用户名 / 密码 不正确',
				'data' => $data
			]);
		}

		if (password_verify($data['password'], $user->password)) {
			$request->session()->set('user', $user);
			return redirect('/');
		}
		return view('default/user/login', [
			'exception' => '用户名 / 密码 不正确',
			'data' => $data
		]);
	}
}
