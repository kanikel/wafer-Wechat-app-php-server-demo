<?php
/**
* test management
*/
class Test extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('test_model','test');
		$this->load->model('test_dialog_model','test_dialog');
		$this->load->model('test_score_model','test_score');
		$this->load->helper('myfunction');
		$this->load->helper('url');
	}

	public function getTest($id = -1){
		$field = '*';
		$order = 'test_id';
		if($id!=-1){
			$where['test_id'] = $id;
			$result = $this->test->getData('test',$where,$field,$order);
		}else{
			$result = $this->test->getData('test','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}

	public function addTest(){
		$data = $this->input->get();
		$result = $this->test->addData('test', $data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/test');
		}else{
			echo 'Failed';
		}
	}

	public function editTest($id=-1){
		$data = $this->input->get();
		$result = $this->test->editdata('test',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/test');
		}else{
			echo 'Failed';
		}
	}

	public function deleteTest($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['test_id'] = $id;
		$result = $this->test->delData('test',$where);
		$this->test_score->delData('test_score',$where);
		if($result)
			ajaxReturn($result);
		else
			ajaxReturn('','0','Failed! please try again');
	}


	//test_dialgo

	public function getTestDialog($id = -1){
		$field = '*';
		$order = 'test_dialog_id';
		if($id!=-1){
			$where['test_dialog_id'] = $id;
			$result = $this->test_dialog->getData('test_dialog',$where,$field,$order);
		}else{
			$result = $this->test_dialog->getData('test_dialog','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}

	public function addTestDialog(){
		$data = $this->input->get();
		$result = $this-> test_dialog ->addData('test_dialog', $data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/testContent');
		}else{
			echo 'Failed';
		}
	}

	public function editTestDialog($id=-1){
		$data = $this->input->get();
		$result = $this->test_dialog->editdata('test_dialog',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/testContent');
		}else{
			echo 'Failed';
		}
	}

	public function deleteTestDialog($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['test_dialog_id'] = $id;
		$result = $this->test_dialog->delData('test_dialog',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}
}
