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

	public static function get_frequency_by_user($keyword, $fid)
	{
		// $keyword = "ลูกค้า";
		// $fid = "180784812046652";
		$post = DB::table('user_post')->where("user_id",$fid)->get();
		$post_id = array();
		foreach($post as $each){
			array_push($post_id,$each->post_id);
		}
		$tag = DB::table("tag")->select(DB::raw("count(name) as total"))->whereIn("post_id",$post_id)->where("name",$keyword)->get();
		return $tag[0]->total ;
	}

	public static function get_frequency($keyword)
	{
		$count = DB::table('tag')->select(DB::raw('count(name) as total'))->where("name",$keyword)->get();
		return $count[0]->total ;
	}

	public static function remove_by_name($name){
		DB::table('tag')
            ->where('name', $name)
            ->update(array('remove' => 1));
	}

	public static function add_by_name($name){
		DB::table('tag')
            ->where('name', $name)
            ->update(array('remove' => 0));
	}
}