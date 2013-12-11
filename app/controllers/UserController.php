<?php

class UserController extends BaseController {

	public $layout = 'layouts.default';

	public function home(){
		if(Auth::check()){
			return Redirect::to("/");
		}else{
			$data = array();
			$this->layout->content = View::make('user.sign_in',$data);
		}
	}
 	
 	public function sign_in(){
		$facebook = new Facebook(Config::get('facebook'));
	    $params = array(
	        'redirect_uri' => url('/fb_callback'),
	        'scope' => 'email'
	    );
	    return Redirect::to($facebook->getLoginUrl($params));
 	}

 	public function sign_out(){
 		Auth::logout();
		return Redirect::to("/");
 	}

 	public function fb_callback(){
		$uid 		= Input::get('uid', false);
		$name 		= Input::get('name', false);
		$username 	= Input::get('username', false);
		$email 		= Input::get('email', false);
		$access_token = Input::get('access_token', false);

	    $profile = Profile::whereUid($uid)->first();
	    if (empty($profile)) {
	 
	        $user = new Users;
	        $user->name = $name ;
	        $user->email = $email;
	        $user->photo = 'https://graph.facebook.com/'.$username.'/picture?type=large';
	 
	        $user->save();
	 
	        $profile = new Profile();
	        $profile->uid = $uid;
	        $profile->username = $username;
	        $profile = $user->profiles()->save($profile);
	    }
	 
	    $profile->access_token = $access_token;
	    $profile->save();
	 
	    Auth::login(Users::where("id",$profile->users_id)->first());
 	}

}

