<?php

namespace app\model;

use support\Model;

class Like extends Model {
	protected $guarded = ['id'];
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 't_likes';

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
	public function memo() {
		return $this->belongsTo('app\model\Memo','memo_id','id');
	}
}