<?php
header("Access-Control-Allow-Origin:*");
/**
* home控制器，主要管理用户的信息
*/
class Home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','user');
		$this->load->helper('myfunction');
	}
	public function getuid(){
		$uid = $this->user->getuid();
		if($uid!=-1) ajaxReturn(array('user_id' => $uid));
		else
			ajaxReturn('','0','用户尚未授权登录');
	}
}