<?php

namespace app\controller;

use app\model\Memo;
use app\model\User;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;
use support\Request;
use support\Response;

class MemoController {


	public function add(Request $request): Response {
		return view('default/memo/add');
	}

	public function save(Request $request): Response {
		$session = $request->session();
		$content = $request->post('content');
		if (strlen(trim($content)) == 0) {
			return view('default/memo/add', [
				'exception' => '内容不能为空',
				'data' => $request->post()
			]);
		}

		Memo::create([
			'content' => $content,
			'fav_count' => 0,
			'comment_count' => 0,
			'user_id' => $session->get('user')->id,
			'pinned' => false,
			'permission' => 0,
		]);
		return redirect('/');
	}
}
