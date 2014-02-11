<?php
 
class Keyword extends Eloquent {
	protected $table = 'keyword';

	protected $appends = array("has_group");

	public function getHasGroupAttribute()
	{
		return GroupKeyword::where("keyword_id", $this->id)->count() > 0 ;
	}


	public static function get_not_generated()
	{
		$user_data = Auth::user();
		$user_id  = $user_data['id'];

		$data = Tag::select(DB::raw('distinct(post_id), count(name) as total , name'))
								->where("status",0)
								->groupBy('name')
								->where("remove",0)
								->where("owner_id",$user_id)
								->orderBy('total','desc')
								->get();
		return $data ;
	}

	public static function generate_keyword()
	{
		$data = Keyword::get_not_generated();
		$minimum_support = Configs::get("minimum_support");

		foreach($data as $each)
		{
			$keyword = Keyword::where("name", $each->name)->first();

			if( $keyword ){
				$keyword->likelihood = Tag::get_likelihood($each->name);
				$keyword->total      = $keyword->total + $each->total;
				$keyword->save();
			}
			else if($each->total >= $minimum_support){
				$keyword             = new Keyword ;
				$keyword->name       = $each->keyword;
				$keyword->total      = $each->total ;
				$keyword->likelihood = Tag::get_likelihood($each->name);
			}

			Tag::where("name", $each->name)->update(array("status" => 1));
		}
	}

}

?>