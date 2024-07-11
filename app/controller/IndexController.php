<?php

namespace app\controller;

use app\model\Memo;
use app\model\SysConfig;
use support\Request;
use support\Response;

class IndexController {


	protected $noNeedLogin = ['index', 'hot', 'square'];

	public function settings(Request $request): Response {
		return view('default/sysSettings', [
			'data' => SysConfig::find(1)
		]);
	}

	public function saveSettings(Request $request): Response {
		$data = $request->post();
		$config = [
			'theme' => $data['theme'],
			'website_title' => $data['website_title'],
			'favicon' => $data['favicon'],
			'config' => [
				'ak' => $data['ak'],
				'sk' => $data['sk'],
				'domain' => $data['domain'],
				'endpoint' => $data['endpoint'],
				'bucket' => $data['bucket'],
				'suffix' => $data['suffix'],
				'disable_register' => $data['disable_register'] ?? "off",
				'anonymous_comment' => $data['anonymous_comment'] ?? "off",
			],
		];
		$exist = SysConfig::find(1);
		if ($exist) {
			$exist->update($config);
		} else {
			SysConfig::create($config);
		}
		return redirect("/settings");
	}


	public function square(Request $request): Response {
		$per_page = 50;
		$current_page = $request->input('page', 1);

		$memos = Memo::with(['likes' => function ($query) {
			$query->take(5);
		}])->orderBy("created_at", "desc")
			->paginate($per_page, ['*'], 'page', $current_page);

		return view('default/index', [
			'memos' => $memos,
			'sysConfig' => SysConfig::find(1)
		]);
	}

	public function index(Request $request): Response {
		$per_page = 50;
		$current_page = $request->input('page', 1);

		$user = session('user');
		if ($user && isset($user->config['selfHomePage']) && $user->config['selfHomePage'] == "on") {
			$memos = Memo::where("user_id", $user->id)->with(['likes' => function ($query) {
				$query->take(5);
			}])->orderBy("created_at", "desc")
				->paginate($per_page, ['*'], 'page', $current_page);

			return view('default/user/mine', [
				'memos' => $memos,
				'user' => $user,
				'sysConfig' => SysConfig::find(1),
			]);
		}

		$memos = Memo::with(['likes' => function ($query) {
			$query->take(5);
		}])->orderBy("created_at", "desc")
			->paginate($per_page, ['*'], 'page', $current_page);

		return view('default/index', [
			'memos' => $memos,
			'sysConfig' => SysConfig::find(1)
		]);
	}

	public function hot(Request $request): Response {
		$per_page = 50;
		$current_page = $request->input('page', 1);
		$memos = Memo::where("comment_count", ">", "0")->orWhere("fav_count", ">", "0")->with(['likes' => function ($query) {
			$query->take(5);
		}])->orderBy("comment_count", "desc")->orderBy("fav_count", "desc")
			->paginate($per_page, ['*'], 'page', $current_page);

		return view('default/index', [
			'memos' => $memos,
			'sysConfig' => SysConfig::find(1)
		]);
	}

//    public function json(Request $request)
//    {
//        return json(['code' => 0, 'msg' => 'ok']);
//    }

}
