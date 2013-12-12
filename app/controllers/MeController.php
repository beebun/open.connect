<?php

class MeController extends BaseController {

	public $layout = 'layouts.default';

	public function __construct(){
		$this->beforeFilter('auth');
	}

	public function index(){
		$data = array();
		$user = Auth::user();
		$data['total_tag'] = Me::get_total_tag($user['id']);
		$data['total_post'] = Me::get_total_post($user['id']);
		$data['total_connected_user'] = Me::get_total_connected_user($user['id']);
		$data['minimum_support'] = Configs::get("minimum_support");
		$this->layout->content = View::make('me.index',$data);
	}

	public function edit_minimum_frequency(){
		$value = Input::get('minimum_frequency', false);
		$config = new Configs ;
		$config->_save('minimum_support', $value);
		return $value ;
	}

}


?>