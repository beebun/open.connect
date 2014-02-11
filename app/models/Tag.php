<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Tag extends Eloquent  {

	protected $table = 'tag';

	protected $guarded = array();

	protected $appends = array();

	public function user_post()
	{
        return $this->belongsTo('UserPost',"post_id");
    }

    /* ==== Set ==== */

	public static function remove_by_name($name){
		Tag::where('name', $name)
            ->update(array('remove' => 1));
        Keyword::where('name', $name)
           	->update(array('remove' => 1));
        echo '';
	}

	public static function add_by_name($name){
		Tag::where('name', $name)
            ->update(array('remove' => 0));
        Keyword::where('name', $name)
           	->update(array('remove' => 0));
	}

	/* ==== Get ==== */
	
	public static function get_frequency_by_user($keyword, $fid)
	{

		$tag = Tag::select(DB::raw("count(name) as total"))
					// ->whereIn("post_id",$post_id)
					->where("user_id", $fid)
					->where("name",$keyword)->get();
		return $tag[0]->total ;
	}

	public static function get_frequency($keyword)
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$count = Tag::select(DB::raw('count(name) as total'))
					->where("name",$keyword)
					->where("owner_id", $user_id)
					->get();
		return $count[0]->total ;
	}

	public static function update_keyword()
	{	
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$data = Tag::get_list();
		foreach($data as $each)
		{
			// $keyword = Keyword::where("name",$each->name)->get();
			
			// if ($keyword == null) {
			   $keyword = new Keyword;
			// }
			$keyword->total      = $each->total; 
			$keyword->name       = $each->name;
			$keyword->likelihood = Tag::get_likelihood($each->name);
			$keyword->owner_id   = $user_id ;
			$keyword->save();
		}
	}

	public static function get_list()
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$minimum_support = Configs::get("minimum_support");
		$data = Tag::select(DB::raw('distinct(post_id), count(name) as total , name'))
								->groupBy('name')
								->where("remove",0)
								->where("owner_id",$user_id)
								->orderBy('total','desc')
								->having('total', '>', $minimum_support)
								->get();

		return $data ;
	}

	public static function get_tag_list($name)
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$data = Tag::where('name',$name)
					->where("owner_id", $user_id)
					->get();
		return $data ;
	}

	public static function get_removed_list()
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$data = Tag::select(DB::raw('count(name) as total , name'))
		                     ->groupBy('name')
		                     ->where("remove",1)
		                     ->where("owner_id", $user_id)
		                     ->orderBy('total','desc')
		                     ->get();
		return $data ;
	}

	public static function get_count($name)
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$count = Tag::select(DB::raw("count(name) as total"))
					->where("name",$name)
					->where("owner_id", $user_id)
					->count();
		return $count ;
	}

	public static function get_related_users($name)
	{
		$keyword_id = array();
		$user = array();

		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$data['tag_list'] = Tag::where('name',$name)
								->where("owner_id", $user_id)
								->get();

		foreach($data['tag_list'] as $each)
			array_push($keyword_id, $each->post_id);

		$user_list = DB::table('user_post')
						->select(DB::raw('distinct(user_id)'))
						->whereIn('post_id',$keyword_id)
						->get();

		foreach($user_list as $each)
		{
			$temp = User::where("fid",$each->user_id)->first();
			array_push($user, $temp);
		}

		return $user ;
	}

	public static function filter_removed()
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$data = Tag::where("remove",0)
					->where("owner_id", $user_id)
					->get();

		foreach($data as $each)
		{
			$temp = Tag::where("name", $each->name)
						->where("owner_id", $user_id)
						->where("remove", 1)
						->count();
			if($count > 0)
			{
				$each->remove = 1 ;
				$each->save();
			}

		}
	}

	public static function get_likelihood($name)
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$data = Tag::select(DB::raw('distinct(post_id) , post_id , name '))
				->where("name",$name)
				->where("status",0)
				->where("owner_id", $user_id)
				->get();

		$result = array() ;
		$i=0;
		$total = 0 ;
		foreach($data as $each)
		{
			$temp = Tag::get_each_likelihood($each->post_id, $name);
			$i++;
			$total = $total + $temp ;
		}

		$avg = $total / $i ;
		
		return $avg ;
	}

	public static function get_each_likelihood($post_id,$name)
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$tf_a = Tag::where("name", $name)
					->where("post_id", $post_id)
					->where("owner_id", $user_id)
					->count();

		$tf_b = Tag::where("post_id", $post_id)
					->where("owner_id", $user_id)
					->count();

		$tf = $tf_a / $tf_b ;

		$idf_a = UserPost::where("owner_id", $user_id)->count() ;
		$idf_b = Tag::select(DB::raw('distinct(post_id)'))
						->where("name",$name)
						->where("owner_id", $user_id)
						->count();

		$idf = log( $idf_a / $idf_b );

		return $tf * $idf ; 
	}

}