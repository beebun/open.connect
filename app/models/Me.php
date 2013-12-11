<?php
 
class Me extends Eloquent {
 
	public static get_total_post($user_id){
		$data = UserPost::where("owner_id",$user_id)->get();
		return count($data);
	}
}


?>