<?php

class KeywordController extends BaseController {

	public $layout = 'layouts.default';

	public function __construct(){
		$this->beforeFilter('auth');
	}

	public function index()
	{	
		$minimum_support = self::config_value("minimum_support");
		$data['tag_list'] = Tag::get_list();
        $data['is_view_removed'] = false ;
		$this->layout->content = View::make('keyword.view_all_keyword',$data);
	}

	public function remove_tag(){
		$name = Input::get('name', false);
		Tag::remove_by_name($name);
		return $name ;
	}

	public function add_tag(){
		$name = Input::get('name', false);
		Tag::add_by_name($name);
	}

	public function view_removed_tags(){
		$minimum_support = self::config_value("minimum_support");
		$data['tag_list'] = Tag::get_removed_list();
        $data['is_view_removed'] = true ;
		$this->layout->content = View::make('keyword.view_all_keyword',$data);
	}

	public function view($keyword)
	{

		$data['count']			= Tag::get_count($keyword);
		$data['user_list']		= Tag::get_related_users($keyword) ;
		$data['keyword'] 		= $keyword ;

 		$this->layout->content = View::make('keyword.view_keyword',$data);
	}

	public function view_keyword_graph($keyword)
	{
		$minimum_support = self::config_value("minimum_support");

		$data['tag_list'] = Tag::get_tag_list();
		
		$keyword_list = array();
		$keyword_id = array();

		foreach($data['tag_list'] as $each){
			array_push($keyword_id, $each->post_id);
		}

		$keyword_list = DB::table('tag')->select(DB::raw('distinct(name)'))->where("remove", 0)->whereIn('post_id',$keyword_id)->get();

		$frequency = array();
		$remove = array();

		$keyword_list_temp = $keyword_list ;
		$keyword_temp = array();
		for($i=0;$i<count($keyword_list_temp);$i++){
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

	public function test()
	{	
		Tag::update_keyword();
		echo "complete";
		// echo "<pre>";
		// print_r(Tag::get_likelihood("เอเชีย"));
		// echo "</pre>";
		die();

	}

}