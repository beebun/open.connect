<?php

class HomeController extends BaseController {

	public $layout = 'layouts.default';

	public function index()
	{
		$this->layout->content = View::make('home.index');
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
		for($i=0;$i<count($keyword_list);$i++){
			$count = $this->get_frequency($keyword_list[$i]->name);
			if($count >= $this->minimum_support) 
				array_push($remove, false);
			else
				array_push($remove, true);

			array_push($frequency, $count);
		}

		$data['remove']	= $remove ;
		$data['frequency'] = $frequency ;		
		$data['tag_list'] = $keyword_list ;
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

}