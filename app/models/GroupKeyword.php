<?php
 
class GroupKeyword extends Eloquent {

	protected $table = 'group_keyword';
 	protected $appends = array("keyword");

 	public static function find_by_group($group_id)
 	{
 		return GroupKeyword::where("group_id",$group_id)->get();
 	}

 	public function getKeywordAttribute(){
 		$keyword = Keyword::find($this->keyword_id);
 		if($keyword->remove == 1)
 			return false ;
 		else
 			return Keyword::find($this->keyword_id);
 	}
}