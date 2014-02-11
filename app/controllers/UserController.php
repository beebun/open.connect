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
	 
	        $account = new Account;
	        $account->name = $name ;
	        $account->email = $email;
	        $account->photo = 'https://graph.facebook.com/'.$username.'/picture?type=large';
	        $account->save();
	 
	        $profile = new Profile();
	        $profile->uid = $uid;
	        $profile->username = $username;
	        $profile = $account->profiles()->save($profile);
	    }
	 
	    $profile->access_token = $access_token;
	    $profile->save();
	 
	    Auth::login(Account::where("id",$profile->account_id)->first());
 	}

}

