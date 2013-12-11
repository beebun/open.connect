<?php

class MeController extends BaseController {

	public $layout = 'layouts.default';

	public function __construct(){
		$this->beforeFilter('auth');
	}

	public function index(){
		$data = array();
		$this->layout->content = View::make('me.index',$data);
	}

}


?>