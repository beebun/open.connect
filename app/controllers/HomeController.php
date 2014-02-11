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

	public function view_cluster()
	{
		$data = array();

		$cluster_number = UserPost::select(DB::raw("max(cluster_id) as count"))->where("is_frequent", 1)->first();
		$cluster_number = $cluster_number->count ;

		for($i=1;$i<=$cluster_number;$i++)
		{
			$count = UserPost::where("cluster_id", $i)->count();
			if($count > 200)
				$cluster[$i] = array();
			else
				$cluster[$i] = UserPost::where("cluster_id", $i)->get();
		}

		$data['cluster'] = $cluster ;

		$this->layout->content = View::make('home.cluster',$data);
	}

	public function index()
	{
		$minimum_support = self::config_value("minimum_support");
		$data['keyword_list'] = Keyword::where('remove',0)
								->where('total', '>', $minimum_support)
								->orderBy("likelihood",'desc')
								->limit("10")->get();
		$user = User::limit("10")->get();
		$data['user_list'] = $user ;

		// $rank     = array();
		// $all_user = User::all();
		// foreach($all_user as $each){
		// 	$temp[0] = User::get_rank($each->fid);
		// 	$temp[1] = User::find($each->id) ;
		// 	User::where("id", $each->id)->update(array("rank"=>$temp[0]));
		// 	array_push($rank, $temp);
		// }

		$data['rank'] = User::orderBy("rank","desc")->limit(10)->get();

		$this->layout->content = View::make('home.index',$data);
	}

	public static function cmp_rank($a, $b)
	{
    	return $a[0] <= $b[0] ;
	}

	public function user()
	{	
		$user = User::orderBy("rank","desc")->limit("1000")->get();
		$data['user_list'] = $user ;
		$this->layout->content = View::make('user.view_all_user',$data);
	}

	public function view($fid)
	{

		$keyword_list = Tag::select(DB::raw('distinct(name)'))
								->where("user_id",$fid)
								->where("remove", 0)
								->get();

		$frequency    = array();
		$remove       = array();
		$keyword_temp = array();

		for($i=0;$i<count($keyword_list);$i++){
			
			$count = $this->get_frequency($keyword_list[$i]->name);

			$freq = Tag::get_frequency_by_user($keyword_list[$i]->name,$fid);
			
			$keyword_list[$i]->user_frequency = $freq ;
			$keyword_list[$i]->frequency = $count ;
			$keyword_list[$i]->ratio = ( $freq / $count ) * 100 ;
			
			// if($count >= $this->minimum_support) 
				array_push($keyword_temp,$keyword_list[$i]);

		}
		
		usort($keyword_temp, "self::cmp");
		$data['tag_list'] = $keyword_temp ;
		$data['fid'] = $fid ;
		$data['user_data'] = User::where("fid",$fid)->get() ;

		$this->layout->content = View::make('user.view_user_data',$data);
	}

	static function cmp($a, $b)
	{
    	return $a->user_frequency <= $b->user_frequency ;
	}

	public function get_user_data($fid)
	{
		$user_data = User::where("fid",$fid)->get();
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
			$keyword_list = Tag::select(DB::raw('distinct(name)'))
								->whereIn("tag.post_id",$wheres)
								->where("remove", 0)
								->get();
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

		for($i=0;$i<count($list1);$i++){
			$list1[$i]->name = strtolower($list1[$i]->name);
		}

		for($i=0;$i<count($list2);$i++){
			$list2[$i]->name = strtolower($list2[$i]->name);
		}

		// dd($list2);

		$intersect = array_intersect($list1,$list2);
		$intersect = array_values($intersect);
		
		for($i=0;$i<count($intersect);$i++){
			$intersect[$i]->name = ucfirst($intersect[$i]->name);
		}

		for($i=0;$i<count($intersect);$i++){
			$intersect[$i]->f1 = Tag::get_frequency_by_user($intersect[$i]->name,$fid1);
			$intersect[$i]->f2 = Tag::get_frequency_by_user($intersect[$i]->name,$fid2);

			if($intersect[$i]->f1 < $intersect[$i]->f2){
				$intersect[$i]->ratio = $intersect[$i]->f1 / $intersect[$i]->f2 ;
				$intersect[$i]->max = $intersect[$i]->f2;
			}else{
				$intersect[$i]->ratio = $intersect[$i]->f2 / $intersect[$i]->f1 ;
				$intersect[$i]->max = $intersect[$i]->f1;
			}
			$intersect[$i]->max = $intersect[$i]->f1 + $intersect[$i]->f2 ;			
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