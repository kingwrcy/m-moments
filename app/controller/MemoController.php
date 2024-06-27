<?php

namespace app\controller;

use app\model\Comment;
use app\model\Memo;
use support\Log;
use support\Request;
use support\Response;

class MemoController {

	protected $noNeedLogin = ['like', 'comment'];


	public function comment(Request $request, $id): Response {
		$currentUser = session('user');
		$memo = Memo::find($id);
		if (!$memo) {
			return response("not found");
		}
		$data = $request->post();
		$content = $data['content'];
		$uid = ($currentUser) ? $currentUser->id : null;
		if (strlen(trim($content)) == 0) {
			return response("评论不能为空");
		}
		Comment::create([
			'user_id' => $uid,
			'memo_id' => $id,
			'content' => $content,
			'username' => $request->post('username', ''),
			'email' => $request->post('email', ''),
			'website' => $request->post('website', ''),
			'reply_user_id' => $request->post('reply_user_id'),
			'reply_username' => $request->post('reply_username', ''),
		]);
		$memo->increment('comment_count');
		$memo->save();
		return redirect("/");
	}

	public function like(Request $request, $id): Response {
		$currentUser = session('user');
		$memo = Memo::find($id);
		if (!$memo) {
			return response("not found");
		}
		if ($currentUser->id === 1 || $memo->author->id === $currentUser->id) {
			$memo->delete();
		}
		return redirect("/");
	}

	public function remove(Request $request, $id): Response {
		$currentUser = session('user');
		$memo = Memo::find($id);
		if (!$memo) {
			return response("not found");
		}
		if ($currentUser->id === 1 || $memo->author->id === $currentUser->id) {
			$memo->delete();
		}
		return redirect("/");
	}

	public function add(Request $request): Response {
		return view('default/memo/save');
	}

	public function toEdit(Request $request, $id): Response {
		$memo = Memo::find($id);
		if (!$memo) {
			return response("not found");
		}
		return view('default/memo/save', ['data' => $memo]);
	}

	public function save(Request $request): Response {
		$session = $request->session();
		$content = $request->post('content');
		if (strlen(trim($content)) == 0) {
			return view('default/memo/save', [
				'exception' => '内容不能为空',
				'data' => $request->post()
			]);
		}

		$id = $request->post('id');
		if (trim($id) === '') {
			$id = 0;
		}
		Memo::upsert([
			'fav_count' => 0,
			'comment_count' => 0,
			'user_id' => $session->get('user')->id,
			'pinned' => false,
			'permission' => 0,
			'id' => $id,
			'content' => $content,
		], ['id']);
		return redirect('/');
	}
}
