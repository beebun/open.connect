<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserPost extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_post';
	
	protected $guarded = array();

	public function _save()
	{
		$user  = Auth::user();

		$data = Input::get('feeds');

		foreach($data as $each)
		{
			if( isset($each['message']) 
					&& UserPost::where('post_id',$each['id'])->count() == 0 ){
				$user_post               = new UserPost;

				$user_post->user_id      = $each['from']['id'];
				$user_post->post_id      = $each['id'];
				$user_post->message      = $each['message'];
				$user_post->created_time = $each['created_time'];
				
				$user_post->status       = 0 ;
				$user_post->is_frequent  = 0 ;
				$user_post->owner_id     = $user['id'];

				$user_post->save();

				if(User::where("fid",$each['from']['id'])->count() == 0)
				{
					$user           = new User ;
					$user->fid      = $each['from']['id'];
					$user->username = $each['from']['name'];
					$user->owner_id = $user['id'];
					$user->save();
				}
				
				Me::generate_keyword($user_post->post_id);
			}
		}

	}

	public function user()
	{
        return $this->belongsTo('User',"user_id");
    }

 	public function tags()
    {
        return $this->hasMany('Tag',"post_id");
    }
}