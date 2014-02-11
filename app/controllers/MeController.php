<?php

class MeController extends BaseController {

	public $layout = 'layouts.default';

	public function __construct(){
		$this->beforeFilter('auth');
	}

	public function index(){
		$data                         = array();
		$user                         = Auth::user();
		$data['total_tag']            = Me::get_total_tag();
		$data['total_post']           = Me::get_total_post();
		$data['total_connected_user'] = Me::get_total_connected_user();
		$data['total_keyword']		  = Me::get_total_keyword();
		$data['not_processing_keyword'] = Me::get_not_processing_keyword();

		$data['not_processing_post']  = Me::get_not_processing_post();
		$data['minimum_support']      = Configs::get("minimum_support");
		$this->layout->content        = View::make('me.index',$data);
	}

	public function edit_minimum_frequency(){
		$value = Input::get('minimum_frequency', false);
		$config = new Configs ;
		$config->_save('minimum_support', $value);
		return $value ;
	}

	public function generate_keyword(){
		Me::generate_keyword();
		return Response::json('complete');
	}

	public function generate_keyword_rank()
	{
		Keyword::generate_keyword();
		return Response::json('complete');
	}

}


?>