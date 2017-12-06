<?php
header("Access-Control-Allow-Origin:*");
/**
* test
*/
class Test extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('test_dialog_model','test_dialog');
		$this->load->model('test_model','test');
		$this->load->helper('myfunction');
	}
	public function getTestDialog($tid){
		$where['test_id'] = $tid;
		$field = '*';
		$order = 'test_dialog_id';
		$result = $this->test_dialog->getData('test_dialog',$where,$field,$order);
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}
	public function getTest(){
		$field = '*';
		$order = 'test_id';
		$result = $this->test->getData('test','',$field,$order);
		if($result){
			foreach ($result as $key => $value) {
			$where['test_id'] = $value['test_id'];
			$order = 'test_dialog_id';
			$result1 = $this->test_dialog->getData('test_dialog',$where,$field,$order);
			if($result1){
				$result[$key]['test_dialog'] = $result1;
			}
		}
		ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}
}