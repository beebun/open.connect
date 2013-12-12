<?php

class Configs extends Eloquent {
	protected $table = 'config';

 	public static function get($name){
 		$data = Configs::where("name",$name)->first();
 		return $data->value ;
 	}

 	public function _save($name,$value){
		$user = Auth::user();
		Configs::where('name', $name)->where("owner_id",$user['id'])
            ->update(array('value' => $value));
 	}
}

?>