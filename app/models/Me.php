<?php
 
class Me extends Eloquent {
 
	public static function get_total_post($user_id){
		$data = UserPost::where("owner_id",$user_id)->get();
		return count($data);
	}

	public static function get_total_connected_user($user_id){
		$data = user::where("owner_id",$user_id)->get();
		return count($data);
	}

	public static function get_total_tag($user_id){
		$minimum_support = Configs::get("minimum_support");

		$tag_list = DB::table('tag')
							->select(DB::raw('count(name) as total , name'))
							->groupBy('name')
							->where("owner_id",$user_id)
							->orderBy('total','desc')
							->having('total', '>', $minimum_support)
							->get();
        return count($tag_list);
	}
}


?>