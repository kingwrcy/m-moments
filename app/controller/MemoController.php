<?php

namespace app\controller;

use app\model\Comment;
use app\model\Like;
use app\model\Memo;
use support\Request;
use support\Response;

class MemoController {

	protected $noNeedLogin = [];


	public function comment(Request $request, $id): Response {
		$currentUser = session('user');
		$memo = Memo::find($id);
		if (!$memo) {
			return response("not found");
		}
		$data = $request->post();
		$content = $data['content'];
		$uid = $currentUser->id;
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
		if ($memo->author->id === $currentUser->id) {
			return json(['fav_count' => $memo->fav_count]);
		}
		if (Like::where('user_id', $currentUser->id)
				->where('memo_id', $id)->count() == 0) {
			Like::create([
				'user_id' => $currentUser->id,
				'memo_id' => $id,
			]);
			$memo->increment('fav_count');
		}
		$memo->refresh();
		return json(['fav_count' => $memo->fav_count, 'like_persons' => $memo->likes->take(5)->map(function ($item) {
			return $item->author->nickname;
		})->join(",")]);
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
		$contentHtml = $request->post('contentHtml');
		$contentMD = $request->post('contentMD');
		if (strlen(trim($contentHtml)) == 0) {
			return view('default/memo/save', [
				'exception' => '内容不能为空',
				'data' => $request->post()
			]);
		}

		$data = [
			'fav_count' => 0,
			'comment_count' => 0,
			'user_id' => $session->get('user')->id,
			'pinned' => false,
			'permission' => 0,
			'content_html' => trim(str_replace("<br/>", "", $contentHtml)),
			'content_md' => trim($contentMD),
		];
		$id = $request->post('id');
		if ($id) {
			$data['id'] = $id;
		}
		Memo::upsert($data, ['id']);
		return redirect('/');
	}
}
