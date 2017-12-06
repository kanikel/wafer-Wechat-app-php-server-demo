<?php
header("Access-Control-Allow-Origin:*");
class character extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('character_model','character');
    $this->load->model('dialog_model','dialog');
    $this->load->helper('myfunction');
  }
  function getCharacter($mid){
    $where['map_id'] = $mid;
    $field = 'character_id,character_name,character_url,map_id';
    $order = 'character_id';
    $result = $this->character->getData('character',$where,$field,$order);
    if($result){
      foreach ($result as $key => $value) {
        $whe['character_id'] = $value['character_id'];
        $field1 = '*';
        $order1 = 'dialog_id';
        $result1 = $this->dialog->getData('dialog',$whe,$field1,$order1);
        if($result1){
          $result[$key]['dialog'] = $result1;
        }
      }
      ajaxReturn($result);
    }else{
      ajaxReturn('','0','no records');
    }
  }
}
