<?php

namespace app\controller;

use support\Request;
use support\Response;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class UserController {
//    public function index(Request $request)
//    {
//        static $readme;
//        if (!$readme) {
//            $readme = file_get_contents(base_path('README.md'));
//        }
//        return $readme;
//    }

    public function reg(Request $request) {
        return view('default/user/reg');
    }

    public function doReg(Request $request): Response {
        try {
            $data = v::input($request->post(), [
                'username' => v::length(1, 12)->setName('用户名'),
                'password' => v::alnum()->length(5, 20)->setName('密码'),
                'email' => v::email()->length(5, 64)->setName('邮箱')
            ]);
        }catch (ValidationException  $exception) {
            return view('default/user/reg',[
                'exception' => $exception->getMessage(),
                'field' => $exception->getTraceAsString(),
                'data' => $request->post()
            ]);
        }
        $username  = $request->post('username', 'tom');
        return view('default/user/reg');
    }

    public function login(Request $request) {
        return view('default/user/login');
    }

//    public function json(Request $request)
//    {
//        return json(['code' => 0, 'msg' => 'ok']);
//    }

}
