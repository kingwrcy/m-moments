<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use app\controller\IndexController;
use app\controller\MemoController;
use app\controller\UserController;
use Webman\Route;

Route::get('/user/login', [UserController::class, 'login']);
Route::post('/user/doLogin', [UserController::class, 'doLogin']);
Route::post('/user/doReg', [UserController::class, 'doReg']);
Route::get('/user/reg', [UserController::class, 'reg']);
Route::get('/user/logout', [UserController::class, 'logout']);



Route::get('/memo/add', [MemoController::class, 'add']);
Route::post('/memo/save', [MemoController::class, 'save']);







