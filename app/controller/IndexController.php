<?php

namespace app\controller;

use app\model\Memo;
use Illuminate\Pagination\Paginator;
use support\Db;
use support\Request;
use support\Response;

class IndexController {
//    public function index(Request $request)
//    {
//        static $readme;
//        if (!$readme) {
//            $readme = file_get_contents(base_path('README.md'));
//        }
//        return $readme;
//    }

	public function index(Request $request): Response {
		$per_page = 10;
		$current_page = $request->input('page', 1);
		$memos = Memo::paginate($per_page, ['*'], 'page', $current_page);

		return view('default/index',[
			'memos' => $memos,
		]);
	}

//    public function json(Request $request)
//    {
//        return json(['code' => 0, 'msg' => 'ok']);
//    }

}
