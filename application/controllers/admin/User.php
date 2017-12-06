<?php
/**
* user management
*/
class User extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','user');
		$this->load->helper('myfunction');
	}

	public function getUsers($id = -1){
		$field = '*';
		$order = 'user_id';
		if($id!=-1){
			$where['user_id'] = $id;
			$result = $this->user->getData('user',$where,$field,$order);
		}else{
			$result = $this->user->getData('user','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}

	public function editUser($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$data = $this->input->get();
		$result = $this->user->editdata('user',$data);
		if($result){
			ajaxReturn();
		}else{
			ajaxReturn('','0','the data hasn\'t be edit');
		}
	}

	public function deleteUser($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['user_id'] = $id;
		$result = $this->user->delData('user',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}

	public function user_list(){
			$data=$this-> user -> getData('user');
			echo json_encode($data);
	}
	
}
