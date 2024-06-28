<?php

namespace app\model;

use support\Model;

class SysConfig extends Model {
	protected $casts = [
		'config' => 'array', // 将 JSON 字段转换为 PHP 数组
	];
	protected $guarded = ['id'];
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 't_sys_config';

	/**
	 * The primary key associated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

}