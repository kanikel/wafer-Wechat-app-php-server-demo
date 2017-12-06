<?php
header("Access-Control-Allow-Origin:*");

class Map extends CI_Controller
{

  function __construct()
  {
    # code...
    parent::__construct();
    $this->load->model('map_model','map');
    $this->load->model('character_model','character');
    $this->load->helper('myfunction');
  }
  public function test(){
    echo '132';
  }
  public function getMap($sid){
    $where['story_id'] = $sid;
    $field = '*';
    $order = 'map_id';
    $result = $this->map->getData('map',$where,$field,$order);
    if($result){
      foreach ($result as $key => $value) {
        $whe['map_id'] = $value['map_id'];
        $order = 'character_id';
        $result1 = $this->character->getData('character',$whe,$field,$order);
        if($result1)
          $result[$key]['character'] = $result1;
      }
      ajaxReturn($result);
    }else{
      ajaxReturn('','0','no records');
    }
  }
}
