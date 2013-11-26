<?php

class KeywordController extends BaseController {

	public $layout = 'layouts.default';

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
			$temp = self::get_frequency_by_user($keyword, $each->user_id);
			// array_push($user_frequency_data, $temp);
			$user_frequency_data[$each->user_id] = $temp ;
		}
		
		// array_multisort($user_id, SORT_DESC, $user_frequency_data, SORT_ASC, $user_frequency_data);
		// sort($user_frequency_data);
		// self::pr($user_id);
		// die();

		$count = DB::table('tag')->select(DB::raw("count(name) as total"))->where("name",$keyword)->get();

		$data['count']			= $count;
		$data['user_list']		= $user_data ;
		$data['keyword'] 		= $keyword ;
		$data['user_frequency'] = $user_frequency_data ;

 		$this->layout->content = View::make('keyword.view_keyword',$data);
	}

	public function get_frequency($keyword)
	{
		$count = DB::table('tag')->select(DB::raw('count(name) as total'))->where("name",$keyword)->get();
		return $count[0]->total ;
	}

	public function get_frequency_by_user($keyword, $fid)
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
		for($i=0;$i<count($keyword_list);$i++){
			$count = $this->get_frequency($keyword_list[$i]->name);
			if($count >= $minimum_support) 
				array_push($remove, false);
			else
				array_push($remove, true);

			array_push($frequency, $count);
		}
		$data['remove']		= $remove ;
		$data['frequency']	= $frequency ;
		$data['keyword']	= $keyword ;
		$data['keyword_list'] = $keyword_list ;
		$this->layout->content = View::make('keyword.view_keyword_graph',$data);
	}



}