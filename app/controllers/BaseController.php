<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public $minimum_support ; 
	public $layout = 'layouts.default';
	
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
		$this->minimum_support = self::config_value("minimum_support");
	}

	static function config_value($name){
		$value = DB::table('config')->select("value")->where("name",$name)->get();
		return $value[0]->value ;
	}

	static function pr($data){
		echo"<pre>";
		print_r($data);
		echo"</pre>";
	}

}