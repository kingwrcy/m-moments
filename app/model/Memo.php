<?php

namespace app\model;

use support\Model;

class Memo extends Model {
	protected $guarded = ['id'];
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 't_memos';

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

	public function author() {
		return $this->belongsTo('app\model\User','user_id','id');
	}


	public function comments() {
		return $this->hasMany('app\model\Comment','memo_id','id');
	}

	public function likes() {
		return $this->hasMany('app\model\Like','memo_id','id');
	}
}