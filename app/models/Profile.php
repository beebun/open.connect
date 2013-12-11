<?php
 
class Profile extends Eloquent {
 
    public function users()
    {
        return $this->belongsTo('Users');
    }
}