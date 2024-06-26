<?php

namespace app\model;

use support\Model;

class User extends Model {
	protected $guarded = ['id'];

	protected $hidden = ['password'];
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 't_users';

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

	public function memos() {
		return $this->hasMany('app\model\Memo','id','user_id');
	}
}