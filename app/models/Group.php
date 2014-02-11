<?php
 
class Group extends Eloquent {

	protected $table = 'group';
 	
 	protected $appends = array("total_keyword","connected_users","total_connected_users");

 	public function getTotalKeywordAttribute()
 	{
 		return GroupKeyword::where("group_id",$this->id)->count();
 	}

 	public function getTotalConnectedUsersAttribute()
 	{
 		return 1;
 	}

 	public static function get_connected_users($group_id)
 	{
		$name = array();
 		$data = GroupKeyword::find_by_group($group_id);
 		foreach( $data as $each ){
 			array_push($name, $each->keyword->name);
 		}

 		$user = array();
 		$data = Tag::whereIn("name", $name)->get();
 		foreach($data as $each)
 		{
 			array_push($user, $each->user_id);
 		}


 		// foreach($user as $each)
 		// {
			// $tags          = array();
			// $user_keywords = array();
			// $data          = Tag::select(DB::raw("distinct(tag.name)"))->where("user_id", $each)->get();
        	
   //      	foreach($data as $tag)
   //      		array_push($tags,$tag->name);

   //      	$keywords = Keyword::whereIn("name", $tags)->count();

   //      	foreach($keywords as $keyword)
   //      		array_push($user_keywords, $keyword->name);

   //      	$result = array_intersect($user_keywords, $name);
   //      	$rank = count($result);
 		// }

		$user = array_unique($user);
		
 		$user = User::whereIn("fid", $user)->orderBy("rank","desc")->get();

 		return $user ;
 	}

 	public static function _save($name)
 	{
 		$user = Auth::user();
		$group = new Group;
		$group->name = $name ;
		$group->owner_id = $user['id'];
		$group->save();
 	}
}