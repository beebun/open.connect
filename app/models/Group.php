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
 		$rank = array();
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
		
		$user = array_unique($user);

 		foreach($user as $each)
 		{
			$tags          = array();
			$user_keywords = array();
			$data          = Tag::select(DB::raw("distinct(tag.name)"))->where("user_id", $each)->get();
        	
        	foreach($data as $tag)
        		array_push($tags,$tag->name);

			$tags = array_unique($tags);
        	$keywords = Keyword::whereIn("name", $tags)->get();

        	foreach($keywords as $keyword)
        		array_push($user_keywords, $keyword->name);

			$result       = array_intersect($user_keywords, $name);
			$each_rank[0] = count($result);
			$each_rank[1] = $each ;

        	array_push($rank, $each_rank);
 		}

		usort($rank, "self::cmp");

		if(count($rank) > 20)
			$user = array_splice($rank, 0, 20);
		else
			$user = $rank ;
		// $user = array_unique($user);
		
		$result = array();
		foreach($user as $each)
		{
			array_push($result, User::where("fid",$each[1])->first());
		}
 		// $user = User::whereIn("fid", $user)->orderBy("rank","desc")->get();

 		return $result ;
 	}

 	static function cmp($a, $b)
	{
    	return $a[0] <= $b[0] ;
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