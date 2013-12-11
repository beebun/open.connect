<?php

use Illuminate\Auth\UserInterface;

class Users extends Eloquent implements UserInterface {
 
    public function profile()
    {
        return $this->hasMany('Profile');
    }

    public static function get($user_id){
    	return Users::find($user_id);
    }

    public function getAuthIdentifier(){
    	return $this->getKey();
	}

	public function getAuthPassword()
	{
	    return $this->password;
	}

}    

?>