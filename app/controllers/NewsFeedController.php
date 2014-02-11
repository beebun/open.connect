<?php

class NewsFeedController extends BaseController {

	public $layout = 'layouts.default';

	public $user_post ; 

	public function __construct(UserPost $user_post){
		$this->beforeFilter('auth');
		$this->user_post = $user_post ;
	}

	public function save_news_feed(){
		$this->user_post->_save();
		return Response::json('complete');
	}

}


?>