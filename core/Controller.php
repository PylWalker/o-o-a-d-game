<?php
class Controller{
	protected $view;
	protected $layout;
	public $currentAction;
	public $currentController;
	function __construct (){
		$this->view = new stdClass();
		$this->layout = new stdClass();
	}
	public function loadLayout(){
		if(substr($this->currentController, 0,5) =='admin' ){
			// load layout của admin
			$file_layout = layout_path.'/admin.phtml';
			if(file_exists($file_layout))
				require_once $file_layout;
			else
				die("File layout <b>$file_layout</b>  not found!");
		}else{
			//load layout của phần public
			$file_layout = layout_path.'/public.phtml';
			
			if(file_exists($file_layout))
				require_once $file_layout;
			else
				die("File layout <b>$file_layout</b>  not found!");
 
		}
	}
	public function ShowContent(){
		$file_view_path = app_path.'/views/'.$this->currentController.'/'.$this->currentAction.'.phtml';
			if(file_exists($file_view_path))
				require_once $file_view_path;
			else
				die("File view  <b>$file_view_path</b>  not found!");
	}
}