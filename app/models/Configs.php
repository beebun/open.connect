<?php

class Configs extends Eloquent {
	protected $table = 'config';

 	public static function get($name){
 		$data = Configs::where("name",$name)->first();
 		return $data->value ;
 	}

 	public function _save($name,$value){
		$user = Auth::user();
		Configs::table('config')
            ->where('name', $name)->where("owner_id",$user['id'])
            ->update(array('remove' => 1));
 	}
}

?>