<?php
/**
 * Here is your custom functions.
 */

function timeAgo($dateTime): string {

	if (!$dateTime) {
		return "未知";
	}
	// 当前时间
	$now = new DateTime();

	// 输入时间
	$inputTime = new DateTime($dateTime);

	// 时间差
	$interval = $now->diff($inputTime);

	// 获取差值的总秒数
	$seconds = $interval->s;
	$minutes = $interval->i;
	$hours = $interval->h;
	$days = $interval->d;
	$months = $interval->m;
	$years = $interval->y;

	// 返回相对时间字符串
	if ($interval->y > 0) {
		return $years . '年前';
	} elseif ($interval->m > 0) {
		return $months . '月前';
	} elseif ($interval->d > 0) {
		return $days . '天前';
	} elseif ($interval->h > 0) {
		return $hours . '小时前';
	} elseif ($interval->i > 0) {
		return $minutes . '分钟前';
	} elseif ($interval->s > 10) {
		return $seconds . '秒前';
	} else {
		return '刚刚';
	}
}
