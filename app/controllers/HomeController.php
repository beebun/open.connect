<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

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

	public function keyword()
	{
		$data['tag_list'] = DB::table('tag')
                     ->select(DB::raw('count(name) as total , name'))
                     ->groupBy('name')
                     ->orderBy('total','desc')
					 ->having('total', '>', 17)
                     ->get();
		$this->layout->content = View::make('keyword.view_all_keyword',$data);
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
			$data['tag_list'] = array();
		}
		else
		{
			$data['tag_list'] = Tag::whereIn("tag.post_id",$wheres)->get();
		}

		$this->layout->content = View::make('user.view_user_data',$data);
	}

	public function view_keyword($keyword){
		echo $keyword ;
		$data['tag_list'] = DB::table('tag')
							 ->where('name',$keyword)
		                     ->get();

        $this->layout->content = View::make('keyword.view_keyword',$data);
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

}