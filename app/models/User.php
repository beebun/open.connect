<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'friend';

    public static function get_rank($fid)
    {
        $tags = array();
        $data = Tag::select(DB::raw("distinct(tag.name)"))->where("user_id", $fid)->get();
        foreach($data as $each){
            array_push($tags, $each->name);
        }

        if(count($tags) == 0)
            return 0;
        else
            return Keyword::whereIn("name", $tags)->count();
    }

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

    public function get_fid($id){
        $data = User::where("id",$id)->first();
        return $data->fid;
    }
}