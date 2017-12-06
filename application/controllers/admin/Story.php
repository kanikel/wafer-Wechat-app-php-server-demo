<?php
/**
* story management
*/
class Story extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('story_model','story');
		$this->load->helper('myfunction');
		$this->load->helper('url');
	}

	public function getStory($id = -1){
		$field = '*';
		$order = 'story_id';
		if($id!=-1){
			$where['story_id'] = $id;
			$result = $this->story->getData('story',$where,$field,$order);
		}else{
			$result = $this->story->getData('story','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}

	public function addStory(){
		$data = $this->input->get();
		$result = $this-> story -> addData('story', $data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/story');
		}else{
			echo 'Failed';
		}
	}

	public function editStory(){
		$data = $this->input->get();
		$result = $this->story->editdata('story',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/story');
		}else{
			echo 'Failed';
		}
	}
	
	public function deleteStory($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['story_id'] = $id;
		$result = $this->story->delData('story',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}
}
