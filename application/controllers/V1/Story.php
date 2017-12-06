<?php
header("Access-Control-Allow-Origin:*");
/**
* 							
*/	
class Story extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('story_model','story');
		$this->load->model('map_model','map');
		$this->load->helper('myfunction');
	}
	public function index(){
		$this->load->view('story.html');
	}
	public  function getStory(){
		$field = '*';
		$order = 'story_id';
		$result = $this->story->getData('story','',$field,$order);
		if($result){
			foreach ($result as $key => $value) {
				$where['story_id'] = $value['story_id'];
				$order = 'map_id';
				$result1 = $this->map->getData('map',$where,$field,$order);
				if($result1)
					$result[$key]['map'] = $result1;
			}
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}
}