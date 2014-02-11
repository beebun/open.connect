<?php
 
class Profile extends Eloquent {

	protected $table = 'profile';
 
    public function users()
    {
        return $this->belongsTo('Users');
    }
}