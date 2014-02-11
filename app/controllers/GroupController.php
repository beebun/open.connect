<?php

class GroupController extends BaseController {

	public $layout = 'layouts.default';

	public $user ;
	
	public function __construct(){
		$this->user = new User ;
		$this->beforeFilter('auth');
	}

	public function index()
	{
		$data = array();
		$user = Auth::user();

		$data['groups'] = Group::where("owner_id",$user['id'])->get();
		$this->layout->content = View::make('group.index', $data);
	}

	public function create()
	{
		$this->layout->content = View::make('group.create');	
	}

	public function post_create()
	{
		$name = Input::get('name', false);
		Group::_save($name);
	    return Redirect::to('group');
	}

	public function view($group_id)
	{
		$data['users']		   = Group::get_connected_users($group_id);
		$data['group']         = Group::find($group_id);
		$data['keywords']      = GroupKeyword::find_by_group($group_id);
		$this->layout->content = View::make('group.view', $data);	
	}

	public function delete($group_id)
	{
		Group::find($group_id)->delete();
		return Redirect::to('group');
	}

	public function add_to_group(){
		$user                  = Auth::user();
		$data['groups']        = Group::where("owner_id",$user['id'])->get();
		$this->layout          = View::make("layouts.ajax");
		$this->layout->content = View::make('group.add_to_group', $data);	
	}

	public function post_add_to_group()
	{
		$user = Auth::user();
		$keyword_id = Input::get("keyword_id", false);
		$group_id   = Input::get("group_id", false);

		$group_keyword             = new GroupKeyword ;
		$group_keyword->keyword_id = $keyword_id ;
		$group_keyword->group_id   = $group_id ;
		$group_keyword->owner_id   = $user['id'];
		$group_keyword->save();
	}

}