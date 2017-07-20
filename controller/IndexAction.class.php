<?php
class IndexAction extends Action {
	 
	
	public function __construct() {
		parent::__construct();
		 
	}
	
	//initial page
	public function index() {
		$this->_tpl->assign('index','index');
		$this->_tpl->display(FRONT.'public/index.tpl');
	}
}
?>