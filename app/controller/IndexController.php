<?php

namespace app\controller;

use app\model\Memo;
use support\Request;
use support\Response;

class IndexController {


	protected $noNeedLogin = ['index'];


	public function index(Request $request): Response {
		$per_page = 10;
		$current_page = $request->input('page', 1);
		$memos = Memo::orderBy("created_at", "desc")->paginate($per_page, ['*'], 'page', $current_page);

		return view('default/index', [
			'memos' => $memos,
		]);
	}

//    public function json(Request $request)
//    {
//        return json(['code' => 0, 'msg' => 'ok']);
//    }

}
