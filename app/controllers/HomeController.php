<?php

class HomeController extends BaseController {

	public $layout = 'layouts.default';
	public $user ;
	public function __construct(){
		$this->user = new User ;
		$this->beforeFilter('auth');
	}

	public function sign_in(){
		$this->layout->content = View::make('home.sign_in',$data);
	}

	public function index()
	{
		$minimum_support = self::config_value("minimum_support");

		$data['tag_list'] = DB::table('tag')
                     ->select(DB::raw('count(name) as total , name'))
                     ->groupBy('name')
                     ->where("remove",0)
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
		$user = User::limit("1000")->get();
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


			$freq = Tag::get_frequency_by_user($keyword_list[$i]->name,$fid);

			$keyword_list[$i]->frequency = $count ;
			$keyword_list[$i]->ratio = ( $freq / $count ) * 100 ;
			// if($count >= $this->minimum_support) 
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
			// $count = $this->get_frequency($keyword_list[$i]->name);
			// $keyword_list[$i]->frequency = $count ;
			// if($count >= $this->minimum_support) 
			array_push($keyword_temp,$keyword_list[$i]);
		}

		return $keyword_temp ;
	}

	public function mutual_interests($fid1, $fid2){
		$data = array();

		$fid1 = $this->user->get_fid($fid1);
		$fid2 = $this->user->get_fid($fid2);
		// $fid1 = "1575824108" ;
		// $fid2 = "100001122286399" ;

		$list1 = $this->get_keyword_from_user($fid1);
		$list2 = $this->get_keyword_from_user($fid2);

		$intersect = array_intersect($list1,$list2);
		$intersect = array_values($intersect);
		
		for($i=0;$i<count($intersect);$i++){
			$intersect[$i]->f1 = Tag::get_frequency_by_user($intersect[$i]->name,$fid1);
			$intersect[$i]->f2 = Tag::get_frequency_by_user($intersect[$i]->name,$fid2);

			if($intersect[$i]->f1 < $intersect[$i]->f2){
				$intersect[$i]->ratio = $intersect[$i]->f1 / $intersect[$i]->f2 ;
			}else{
				$intersect[$i]->ratio = $intersect[$i]->f2 / $intersect[$i]->f1 ;
			}
			
			$intersect[$i]->ratio = $intersect[$i]->ratio*100;
		}

		$data['list1'] = $list1 ;
		$data['list2'] = $list2 ;
		$data['intersect'] = $intersect ;

		$data['user1'] = $this->user->get($fid1);
		$data['user2'] = $this->user->get($fid2);

		$this->layout->content = View::make('user.view_mutual_interests',$data);
	}

}