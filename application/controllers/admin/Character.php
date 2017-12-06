<?php
/**
* character management
*/
class Character extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('character_model','character');
		$this->load->helper('myfunction');
		$this->load->helper('url');
	}

	public function getCharacter($id = -1){
		$field = '*';
		$order = 'character_id';
		if($id!=-1){
			$where['character_id'] = $id;
			$result = $this->character->getData('character',$where,$field,$order);
		}else{
			$result = $this->character->getData('character','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}

	public function addCharacter(){
		$data = $this-> input ->get();
		$result = $this-> character ->addData('character',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/character');
		}else{
			echo 'Failed';
		}
	}

	public function editCharacter(){
		$data = $this->input->get();
		$result = $this->character->editdata('character',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/character');
		}else{
			echo 'Failed';
		}
	}

	public function deleteCharacter($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['character_id'] = $id;
		$result = $this->character->delData('character',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}
}
