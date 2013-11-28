<?php

class HomeController extends BaseController {

	public $layout = 'layouts.default';

	public function index()
	{
		$minimum_support = self::config_value("minimum_support");

		$data['tag_list'] = DB::table('tag')
                     ->select(DB::raw('count(name) as total , name'))
                     ->groupBy('name')
                     ->orderBy('total','desc')
					 ->having('total', '>', $minimum_support)
					 ->limit('15')
                     ->get();
		// $this->layout->content = View::make('keyword.view_all_keyword',$data);

		$user = User::limit("10")->get();
		$data['user_list'] = $user ;
		// $this->layout->content = View::make('user.view_all_user',$data);


		$this->layout->content = View::make('home.index',$data);
	}

	public function user()
	{	
		$user = User::limit("80")->get();
		$data['user_list'] = $user ;
		$this->layout->content = View::make('user.view_all_user',$data);
	}

	public function view($fid)
	{
		$post_id = UserPost::where("user_post.user_id",$fid)->get();

		$wheres = array();
		foreach($post_id as $each)
		{
			array_push($wheres, $each->post_id);
		}

		if(count($wheres) == 0)
		{
			$keyword_list = array();
		}
		else
		{
			$keyword_list = Tag::select(DB::raw('distinct(name)'))->whereIn("tag.post_id",$wheres)->get();
		}

		$frequency = array();
		$remove = array();
		$keyword_temp = array();
		for($i=0;$i<count($keyword_list);$i++){
			$count = $this->get_frequency($keyword_list[$i]->name);

			$keyword_list[$i]->frequency = $count ;
			if($count >= $this->minimum_support) 
				array_push($keyword_temp,$keyword_list[$i]);
		}
	
		$data['tag_list'] = $keyword_temp ;
		$data['fid'] = $fid ;
		$data['user_data'] = User::where("user.fid",$fid)->get() ;

		$this->layout->content = View::make('user.view_user_data',$data);
	}

	public function get_user_data($fid)
	{
		$user_data = User::where("user.fid",$fid)->get();
 		$username = $user_data[0]->username ;
 		$fid = $user_data[0]->fid ;

		echo '<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/'.$fid.'/picture?type=square" ></div>
		<div class="block-name">'.$username.'</div>';

		// $this->layout->content = View::make('user.get_user_data_ajax',$data);
	}

	public function get_frequency($keyword)
	{
		$count = DB::table('tag')->select(DB::raw('count(name) as total'))->where("name",$keyword)->get();
		return $count[0]->total ;
	}

	public function get_keyword_from_user($fid){
		$post_id = UserPost::where("user_post.user_id",$fid)->get();

		$wheres = array();
		foreach($post_id as $each)
		{
			array_push($wheres, $each->post_id);
		}

		if(count($wheres) == 0)
		{
			$keyword_list = array();
		}
		else
		{
			$keyword_list = Tag::select(DB::raw('distinct(name)'))->whereIn("tag.post_id",$wheres)->get();
		}

		$frequency = array();
		$remove = array();
		$keyword_temp = array();
		for($i=0;$i<count($keyword_list);$i++){
			$count = $this->get_frequency($keyword_list[$i]->name);

			$keyword_list[$i]->frequency = $count ;
			if($count >= $this->minimum_support) 
				array_push($keyword_temp,$keyword_list[$i]);
		}

		return $keyword_temp ;
	}

	public function mutual_interests(){
		$data = array();

		$fid1 = "1575824108" ;
		$fid2 = "100001122286399" ;

		$list1 = $this->get_keyword_from_user($fid1);
		$list2 = $this->get_keyword_from_user($fid2);
		
		$data['list1'] = $list1 ;
		$data['list2'] = $list2 ;
		// dd($list1);

		// dd($list2);
		$this->layout->content = View::make('user.view_mutual_interests',$data);
	}

}