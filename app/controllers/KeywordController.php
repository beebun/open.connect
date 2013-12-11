<?php

class KeywordController extends BaseController {

	public $layout = 'layouts.default';

	public function __construct(){
		$this->beforeFilter('auth');
	}

	public function index()
	{	
		$minimum_support = self::config_value("minimum_support");

		$data['tag_list'] = DB::table('tag')
                     ->select(DB::raw('count(name) as total , name'))
                     ->groupBy('name')
                     ->orderBy('total','desc')
					 ->having('total', '>', $minimum_support)
                     ->get();
		$this->layout->content = View::make('keyword.view_all_keyword',$data);
	}

	public function view($keyword)
	{
		$minimum_support = self::config_value("minimum_support");

		$data['tag_list'] = DB::table('tag')->where('name',$keyword)->get();
		$keyword_list = array();
		$keyword_id = array();
		foreach($data['tag_list'] as $each){
			array_push($keyword_id, $each->post_id);
		}

		$user_list = DB::table('user_post')->select(DB::raw('distinct(user_id)'))->whereIn('post_id',$keyword_id)->get();

		$user_data = array();
		$user_id = array();
		$user_frequency_data = array();
		foreach($user_list as $each){
			$temp = DB::table('user')->where("fid",$each->user_id)->get();
			array_push($user_data, $temp[0]);
			array_push($user_id,$each->user_id);

			$tag = new Tag();
			// $temp = $tag->get_frequency_by_user($keyword, $each->user_id);
			// $user_frequency_data[$each->user_id] = $temp ;
		}

		$count = DB::table('tag')->select(DB::raw("count(name) as total"))->where("name",$keyword)->get();

		$data['count']			= $count;
		$data['user_list']		= $user_data ;
		$data['keyword'] 		= $keyword ;
		// $data['user_frequency'] = $user_frequency_data ;

 		$this->layout->content = View::make('keyword.view_keyword',$data);
	}

	public function view_keyword_graph($keyword)
	{
		$minimum_support = self::config_value("minimum_support");

		$data['tag_list'] = DB::table('tag')->where('name',$keyword)->get();
		$keyword_list = array();
		$keyword_id = array();
		foreach($data['tag_list'] as $each){
			array_push($keyword_id, $each->post_id);
		}

		$keyword_list = DB::table('tag')->select(DB::raw('distinct(name)'))->whereIn('post_id',$keyword_id)->get();

		$frequency = array();
		$remove = array();

		$keyword_list_temp = $keyword_list ;
		$keyword_temp = array();
		for($i=0;$i<count($keyword_list_temp);$i++){
			// $tag = new Tag();
			$count = Tag::get_frequency($keyword_list_temp[$i]->name);

			if($count >= $minimum_support && $keyword_list_temp[$i]->name != $keyword){
				$keyword_list_temp[$i]->frequency = (int)$count ;
				array_push($keyword_temp, $keyword_list_temp[$i]);
			}
		}

		usort($keyword_temp, "self::cmp");
		$data['total_keyword'] = count($keyword_temp);

		$keyword_temp = array_slice($keyword_temp,0,10);
		$frequency = array_slice($frequency,0,10);

		$data['keyword']	= $keyword ;
		$data['keyword_list'] = json_encode($keyword_temp) ;

		$this->layout->content = View::make('keyword.view_keyword_graph',$data);
	}

	static function cmp($a, $b)
	{
    	return $a->frequency <= $b->frequency ;
	}




}