<?php
/**
* score management
*/
class Score extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('score_model','score');
		$this->load->model('test_score_model','test_score');
		$this->load->helper('myfunction');
	}
	public function getScore($id = -1){
		$field = '*';
		$order = 'score_id';
		if($id!=-1){
			$where['score_id'] = $id;
			$result = $this->score->getData('score',$where,$field,$order);
		}else{
			$result = $this->score->getData('score','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}
	public function addScore(){
		$data = $this->input->get();
		$config['upload_path'] = './uploads/';
		$config['allowed_type'] = 'jpg|png';
		$config['max_width'] = 0;
		$this->load->library('upload',$config);
		$upload = $this->upload->do_upload('file');
		if($upload){
			$data['score_url'] = $this->upload->data('full_path');
		}
		$result = $this->score->addData('score',$data);
		if($result){
			ajaxReturn();
		}else{
			ajaxReturn('','0','Failed');
		}
	}
	public function editScore($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$data = $this->input->get();
		$config['upload_path'] = './uploads/';
		$config['allowed_type'] = '*';
		$config['max_width'] = 0;
		$this->load->library('upload',$config);
		$upload = $this->upload->do_upload('file');
		if($upload){
			$data['score_url'] = $this->upload->data('full_path');
		}
		$result = $this->score->editdata('score',$data);
		if($result){
			ajaxReturn();
		}else{
			ajaxReturn('','0','the data hasn\'t be edit');
		}
	}
	public function deleteScore($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['score_id'] = $id;
		$result = $this->score->delData('score',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}




	//test test_score 
	public function getTestScore($id = -1){
		$field = '*';
		$order = 'test_score_id';
		if($id!=-1){
			$where['test_score_id'] = $id;
			$result = $this->test_score->getData('test_score',$where,$field,$order);
		}else{
			$result = $this->test_score->getData('test_score','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}
	public function addTestScore(){
		$data = $this->input->get();
		$config['upload_path'] = './uploads/';
		$config['allowed_type'] = 'jpg|png';
		$config['max_width'] = 0;
		$this->load->library('upload',$config);
		$upload = $this->upload->do_upload('file');
		if($upload){
			$data['test_score_url'] = $this->upload->data('full_path');
		}
		$result = $this->test_score->addData('test_score',$data);
		if($result){
			ajaxReturn();
		}else{
			ajaxReturn('','0','Failed');
		}
	}
	public function editTestScore($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$data = $this->input->get();
		$config['upload_path'] = './uploads/';
		$config['allowed_type'] = '*';
		$config['max_width'] = 0;
		$this->load->library('upload',$config);
		$upload = $this->upload->do_upload('file');
		if($upload){
			$data['test_score_url'] = $this->upload->data('full_path');
		}
		$result = $this->test_score->editdata('test_score',$data);
		if($result){
			ajaxReturn();
		}else{
			ajaxReturn('','0','the data hasn\'t be edit');
		}
	}
	public function deleteTestScore($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['test_score_id'] = $id;
		$result = $this->test_score->delData('test_score',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}
}