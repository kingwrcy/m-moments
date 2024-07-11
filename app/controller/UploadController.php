<?php

namespace app\controller;

use support\Request;
use support\Response;

class UploadController {


	protected $noNeedLogin = ['file'];


	public function file(Request $request, $file): Response {
		// 文件的绝对路径
		$filePath = getenv("UPLOAD_DIR") . '/' . $file;

		// 检查文件是否存在
		if (file_exists($filePath)) {
			// 获取文件的 MIME 类型
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimeType = finfo_file($finfo, $filePath);
			finfo_close($finfo);

			// 设置合适的 Content-Type 头部
			header('Content-Type: ' . $mimeType);

			return response()->file($filePath);
		} else {
			return response('not found');
		}
	}


}
