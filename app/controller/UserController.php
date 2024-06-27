<?php

namespace app\controller;

use app\model\User;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;
use support\Log;
use support\Request;
use support\Response;

class UserController {

	protected $noNeedLogin = ['login', 'doLogin', 'reg', 'doReg'];

	public function logout(Request $request): Response {
		$request->session()->forget('user');
		return redirect('/');
	}

	public function saveSettings(Request $request): Response {
		$data = $request->post();
		$uid = $request->session()->get('user')->id;
		Log::info("data is saveSettings", $data);

		if (User::where("username", $data['username'])->where("id", "<>", $uid)->first()) {
			Log::info("username is exists");

			return view('default/user/settings', [
				'message' => '用户名 已存在,保存失败',
				'data' => $data
			]);
		}
		if (User::where("nickname", $data['nickname'])->where("id", "<>", $uid)->first()) {
			Log::info("nickname is exists");

			return view('default/user/settings', [
				'message' => '昵称 已存在,保存失败',
				'data' => $data
			]);
		}
		$avatar_url = $data['avatar_url'];
		$avatar_url_file = $request->file('avatar_url');
		if ($avatar_url_file && $avatar_url_file->isValid()) {
			$destination = date("Ymd") .DIRECTORY_SEPARATOR. uniqid() .".". $avatar_url_file->getUploadExtension();
			$avatar_url_file->move(getenv('UPLOAD_DIR') .DIRECTORY_SEPARATOR. $destination);
			$avatar_url = '/upload/' . $destination;
		}

		$cover_url = $data['cover_url'];
		$cover_url_file = $request->file('cover_url');
		if ($cover_url_file && $cover_url_file->isValid()) {
			$destination = date("Ymd") .DIRECTORY_SEPARATOR. uniqid() .".". $cover_url_file->getUploadExtension();
			$cover_url_file->move(getenv('UPLOAD_DIR') .DIRECTORY_SEPARATOR. $destination);
			$cover_url = '/upload/' . $destination;
		}

		User::find($uid)->update([
			'username' => $data['username'],
			'nickname' => $data['nickname'],
			'email' => $data['email'],
			'avatar_url' => $avatar_url,
			'cover_url' => $cover_url,
			'slogan' => $data['slogan'],
			'config' => [
				'css' => $data['css'],
				'js' => $data['js'],
				'ak' => $data['ak'],
				'sk' => $data['sk'],
				'domain' => $data['domain'],
				'endpoint' => $data['endpoint'],
				'bucket' => $data['bucket'],
				'suffix' => $data['suffix'],
			],
		]);

		if ($data['password']) {
			User::find($uid)->update([
				'password' => password_hash($data['password'], PASSWORD_BCRYPT),
			]);
			$request->session()->forget('user');
			return redirect('/user/login');
		}
		session(['user' => User::find($uid)]);
		return redirect('/user/settings');
	}

	public function settings(Request $request): Response {
		return view('default/user/settings', ['data' => $request->session()->get('user')]);
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
