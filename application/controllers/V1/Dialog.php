<?php
header("Access-Control-Allow-Origin:*");
class Dialog extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('dialog_model','dialog');
    $this->load->helper('myfunction');
  }
  public function getDialog($cid){
    $where['character_id'] = $cid;
    $field = '*';
    $order = 'dialog_id';
    $result = $this->dialog->getData('dialog',$where,$field);
    if($result){
      ajaxReturn($result);
    }else{
      ajaxReturn('','0','no records');
    }
  }
  public function getTest(){
    $field = '*';
    $result = $this->test->getData('test','',$field);
    if($result){
      ajaxReturn($result);
    }else{
      ajaxReturn('','0','no records');
    }
  }
  /*
  this is retained
   */
 /* public function getDialog($did){
    $where['dialog_id'] = $did;
    $field = 'dialog_id,dialog_url';
    $result = $this->dialog->getData('dialog',$where,$field);
    if($result){
      $result1 = $this->text->getData('text',$where,'*');
      $result['text']=$result1;
      ajaxReturn($result);
    }else {
      ajaxReturn('','0','no records');
    }
  }*/
  /*public function getDialogByStory($sid){
    $where['story_id'] = $sid;
    $field = '*';
    $order = 'dialog_id';
    $result = $this->dialog->getData('dialog',$where,$field,$order);
    if($result){
      ajaxReturn($result);
    }else{
      ajaxReturn('','0','no records');
    }
  }
  public function getDialogById($did){
    $where['dialog_id'] = $did;
    $field = '*';
    $result = $this->dialog->getData('dialog',$where,$field);
    if($result){
      ajaxReturn($result);
    }
    else{
      ajaxReturn('','0','no records');
    }
  }*/
 /* public function getText($did){
    $where['dialog_id']=$did;
    $field = 'text_id,text_content,dialog_id,limit_time';
    $order = 'text_id';
    $result = $this->text->getData('text',$where,$field,$order);
    if($result){
      ajaxReturn($result);
    }else{
      ajaxReturn('','0','no records');
    }
  }*/
}
