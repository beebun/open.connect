<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

 	public function user_post()
    {
        return $this->hasMany('UserPost',"fid");
    }

    public function get_username($fid){
    	$data = User::where("fid",$fid)->first();
    	return $data->username ;
    }

    public function get($fid){
    	$data = User::where("fid",$fid)->first();
    	return $data ;
    }

}