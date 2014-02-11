<?php

use Illuminate\Auth\UserInterface;

class Account extends Eloquent implements UserInterface {
 
    protected $table = 'account';

    public function profile()
    {
        return $this->hasMany('Profile');
    }

    public static function get($user_id){
    	return Account::find($user_id);
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