<?php
/**
* map management
*/
class Map extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('map_model','map');
		$this->load->helper('myfunction');
		$this->load->helper('url');
	}

	public function getMap($id = -1){
		$field = '*';
		$order = 'map_id';
		if($id!=-1){
			$where['map_id'] = $id;
			$result = $this->map->getData('map',$where,$field,$order);
		}else{
			$result = $this->map->getData('map','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}

	public function addMap(){
		$data = $this-> input -> get();
		$result = $this-> map -> addData('map',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/map');
		}else{
			echo 'Failed';
		}
	}

	public function editMap(){
		$data = $this->input->get();
		$result = $this->map->editdata('map',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/map');
		}else{
			echo 'Failed';
		}
	}

	public function deleteMap($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['map_id'] = $id;
		$result = $this->map->delData('map',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}
}
