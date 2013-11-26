<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Tag extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tag';

	public function user_post()
	{
        return $this->belongsTo('UserPost',"post_id");
    }
}