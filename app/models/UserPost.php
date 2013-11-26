<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserPost extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_post';
	
	public function user()
	{
        return $this->belongsTo('User',"user_id");
    }

 	public function tags()
    {
        return $this->hasMany('Tag',"post_id");
    }
}