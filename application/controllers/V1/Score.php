<?php
header("Access-Control-Allow-Origin:*");
/**
 *  q
 */
class Score extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('user_model','user');
    $this->load->model('test_score_model','test_score');
    $this->load->model('score_model','score');
    $this->load->helper('myfunction');
    $this->load->library('app');
  }
  /**
   * upload the record file and get record_id, the score will save in the database
   */
  /**
   * 上传录音并获取评分
   * @return [type] [description]
   */
  function score(){
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = '*';
    $config['max_width'] = '2048';
    $config['file_name'] = time();
    $this->load->library('upload',$config);
    $this->upload->do_upload('file');
    $path = $this->upload->data();
    $voice_file = new \CURLFile(realpath($path['full_path']),'application/octet-stream','audio');
    $api = $this->input->post('api');
    switch ($api){
      case '1':
      $data = $this->input->post(array('character_id','dialog_id','user_id','dialog_text'));
        $url = 'http://123.207.0.241:8088/api/scoring/text/json';
         $file = array(
          'key' => '3hMZPYdjFds9Age7ZcjezqK6rk7eiYFnUVI19%2F9lt3ObCUaWvkr5HD7FTWC6j6vwC7ZO0Fx8McQ5rlV5oPSspCke3V24m%2FrqWFzypF6%2F0nU%3D',
          'dialect' => 'general_american',
          'user_id' => $data['user_id'],
          'text' => $data['dialog_text'],
          'audio' => $voice_file,
          );
        break;
      
      default:
        $data = $this->input->post(array('user_id','test_id','test_dialog_id','filter','phone_list'));
        $url = 'http://123.207.0.241:8088/api/scoring/phone_list/json';
         $file = array(
          'key' => '3hMZPYdjFds9Age7ZcjezqK6rk7eiYFnUVI19%2F9lt3ObCUaWvkr5HD7FTWC6j6vwC7ZO0Fx8McQ5rlV5oPSspCke3V24m%2FrqWFzypF6%2F0nU%3D',
          'dialect' => 'general_american',
          'user_id' => $data['user_id'],
          'phone_list' => $data['phone_list'],
          'audio' => $voice_file,
          );
        break;
    }
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_PORT => "8088",
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
     "cache-control: no-cache",
     "content-type: multipart/form-data;"
     ),
    CURLOPT_POSTFIELDS => $file,
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    unlink($path['full_path']);
    $respon = json_decode($response,1);
    if(!isset($respon['text_score'])&&!isset($respon['word_score'])){
      ajaxReturn(json_decode($response,1),'0','something wrong happen,please try again.');
      log_message('error',isset($respon['detail_message'])?$respon['detail_message']:'something wrong with the score api');
      exit();
    }
    if ($err) {
       ajaxReturn('','0',$err);
    } else {
       switch ($api) {
         case '1':
           $score = self::parsetext(json_decode($response,1));
           $data['score'] = $score;
           unset($data['dialog_text']);
           $add = $this->score->addData('score',$data);
           break;
         
         default:
           $score = self::parsetest(json_decode($response,1),$data['filter']);
           $data['test_score'] = $score;
           unset($data['filter']);
           unset($data['phone_list']);
           $add = $this->test_score->addData('test_score',$data);
           break;
       }
       if($add!=-1){
         $out['score_id'] = $add;
         ajaxReturn($out);
       }else{
        ajaxReturn('','0','the score cannot be saved');
       }
    }
  }
  public function test()
  {
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = '*';
    $config['max_width'] = '2048';
    $config['file_name'] = time();
    $this->load->library('upload',$config);
    $this->upload->do_upload('file');
    $path = $this->upload->data();
    $voice_file = new \CURLFile(realpath($path['full_path']),'application/octet-stream','audio');
    $api = $this->input->post('api');
    switch ($api){
      case '1':
      $data = $this->input->post(array('character_id','dialog_id','user_id','dialog_text'));
        $url = 'http://123.207.0.241:8088/api/scoring/text/json';
         $file = array(
          'key' => '3hMZPYdjFds9Age7ZcjezqK6rk7eiYFnUVI19%2F9lt3ObCUaWvkr5HD7FTWC6j6vwC7ZO0Fx8McQ5rlV5oPSspCke3V24m%2FrqWFzypF6%2F0nU%3D',
          'dialect' => 'general_american',
          'user_id' => $data['user_id'],
          'text' => $data['dialog_text'],
          'audio' => $voice_file,
          );
        break;
      
      default:
        $data = $this->input->post(array('user_id','test_id','test_dialog_id','filter','phone_list'));
        $url = 'http://123.207.0.241:8088/api/scoring/phone_list/json';
         $file = array(
          'key' => '3hMZPYdjFds9Age7ZcjezqK6rk7eiYFnUVI19%2F9lt3ObCUaWvkr5HD7FTWC6j6vwC7ZO0Fx8McQ5rlV5oPSspCke3V24m%2FrqWFzypF6%2F0nU%3D',
          'dialect' => 'general_american',
          'user_id' => $data['user_id'],
          'phone_list' => $data['phone_list'],
          'audio' => $voice_file,
          );
        break;
    }
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_PORT => "8088",
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
     "cache-control: no-cache",
     "content-type: multipart/form-data;"
     ),
    CURLOPT_POSTFIELDS => $file,
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $respon = json_decode($response,1);
    if(!isset($respon['text_score'])&&!isset($respon['word_score'])){
      ajaxReturn(json_decode($response,1),'0','something wrong happen,please try again.');
      log_message('error',isset($respon['detail_message'])?$respon['detail_message']:'something wrong with the score api');
      exit();
    }
    if ($err) {
       ajaxReturn('','0',$err);
    } else {
       switch ($api) {
         case '1':
           $score = self::parsetext(json_decode($response,1));
           $data['score'] = $score;
           unset($data['dialog_text']);
           $add = $this->score->addData('score',$data);
           break;
         
         default:
           $score = self::parsetest(json_decode($response,1),$data['filter']);
           $data['test_score'] = $score;
           unset($data['filter']);
           unset($data['phone_list']);
           $add = $this->test_score->addData('test_score',$data);
           break;
       }
       if($add!=-1){
         $out['score_id'] = $add;
         ajaxReturn($out);
       }else{
        ajaxReturn('','0','the score cannot be saved');
       }
    }
  }
  function getScore(){
    //$data = $this->input->post(array('score_id','character_id','dialog_id','user_id'));
    $where = $this->input->get();
    /*foreach ($data as $key => $value) {
      if($value!=null)
        $where[$key] = $value;
    }
    var_dump($_POST);*/
    /*$where['character_id'] = $data['character_id'];
    $where['dialog_id'] = $data['dialog_id'];
    $where['user_id'] = $data['user_id'];*/
    $field = '*';
    $result = $this->score->getData('score',$where,$field);
    if($result){
      foreach ($result as $key => $value) {
        $result[$key]['score'] = json_decode($result[$key]['score']);
      }
      ajaxReturn($result);
    }
    else{
      ajaxReturn('','0','no records');
    }
  }
  public function getTestScorett(){
    //$data = $this->input->post(array('test_score_id','test_id','test_dialog_id','user_id'));
    $where = $this->input->get();
    $where=$where==null?$_POST:$where;
    /*foreach ($data as $key => $value) {
      if($value!=null)
        $where[$key] = $value;
    }*/
    /*$where['character_id'] = $data['character_id'];
    $where['dialog_id'] = $data['dialog_id'];
    $where['user_id'] = $data['user_id'];*/
    $field = '*';
    $result = $this->score->getData('test_score',$where,$field);
    if($result){
      foreach ($result as $key => $value) {
        $result[$key]['test_score'] = json_decode($result[$key]['test_score']);
        //$test_score_result = json_decode($result[$key]['test_score']) ;
       /* $result[$key]['quality_score'] = $test_score_result['quality_score'];
        $result[$key]['result_phone'] = $test_score_result['phone_score_list']['phone'];
        $result[$key]['result_quality_score'] = $test_score_result['phone_score_list']['quality_score'];*/
      }
      ajaxReturn($result);
    }
    else{
      ajaxReturn('','0','no records');
    }
  }
  public function getTestScore(){
    //$data = $this->input->post(array('test_score_id','test_id','test_dialog_id','user_id'));
    $where = $this->input->get();
    /*foreach ($data as $key => $value) {
      if($value!=null)
        $where[$key] = $value;
    }*/
    /*$where['character_id'] = $data['character_id'];
    $where['dialog_id'] = $data['dialog_id'];
    $where['user_id'] = $data['user_id'];*/
    $field = '*';
    $result = $this->score->getData('test_score',$where,$field);
    if($result){
      foreach ($result as $key => $value) {
        //$result[$key]['test_score'] = json_decode($result[$key]['test_score'],1);
        $test_score_result = json_decode($result[$key]['test_score'],1) ;
        //var_dump($test_score_result);
        //$phone_score_list = json_decode($test_score_result['phone_score_list'][0],1);
        $result[$key]['quality_score'] = $test_score_result['quality_score'];
        $result[$key]['result_phone'] = $test_score_result['phone_score_list'][0]['phone'];
        $result[$key]['result_quality_score'] = $test_score_result['phone_score_list'][0]['quality_score'];
        unset($result[$key]['test_score']);
      }
      ajaxReturn($result);
    }
    else{
      ajaxReturn('','0','no records');
    }
  }
  public function getPhoneScore(){
    $where = $_POST;
    $field = 'test_score';
    $result = $this->score->getData('test_score',$where,$field);
    if($result){
      $array = array();
      foreach ($result as $key => $value) {
        $test_score_result = json_decode($value['test_score'],1);
        foreach ($test_score_result['phone_score_list'] as $k => $v) {
          $phone = $v['phone'];
          $phone_score = $v['quality_score'];
          if(!array_key_exists("$phone", $array)){
            $array = array_merge($array, array("$phone" => $phone_score));
          }else{
            $array["$phone"] = ($phone_score+$array[$phone])/2;
          }
        }
      }
      ajaxReturn($array);
    }else{
      ajaxReturn('','0','no records');
    }
  }
  public function getTestScoreByDialog($did){
    $where['test_dialog_id'] = $did;
    $field = '*';
    $result = $this->test_dialog->getData('test_score',$where,$field);
    if($result){
      ajaxReturn($result);
    }else{
      ajaxReturn('','0','no records');
    }
  }
  public function test1(){
    $this->load->library('app');
    echo $this->app->getIPA('ER');

  }
  private function walkarray(&$array){
    foreach ($array as $key => $value) {
      if($value)
      $array[$key] = strtoupper($value);
    }
  }
  private function parsetext($response){
    $data['quality_score'] = $response['text_score']['quality_score'];
    $data['word_score_list'] = array();
    foreach ($response['text_score']['word_score_list'] as $key => $value) {
      array_push($data['word_score_list'], array("word" => $value['word'], "quality_score" => $value['quality_score']));
    }
    return json_encode($data);
  }
  private function parsetest($response,$filter='|'){
    if($filter=='|'){
      $data['quality_score'] = $response['word_score']['quality_score'];
      $data['phone_score_list'] = array();
      foreach ($response['word_score']['phone_score_list'] as $key => $value) { 
        array_push($data['phone_score_list'], array('phone' => $this->app->getIPA(strtoupper($value['phone'])),
                                          'quality_score' => $value['quality_score'],
                                          ));
    }
    return json_encode($data);
    }
    $filterarray = explode('|', $filter);
    self::walkarray($filterarray);
    $data['quality_score'] = $response['word_score']['quality_score'];
    $data['phone_score_list'] = array();
    foreach ($response['word_score']['phone_score_list'] as $key => $value) {
      if(in_array(strtoupper($value['phone']), $filterarray)){
        array_push($data['phone_score_list'], array('phone' => $this->app->getIPA(strtoupper($value['phone'])),
                                          'quality_score' => $value['quality_score'],
                                          ));
      }
    }
    return json_encode($data);
  }
  private function parsetesttest($response,$filter='|'){
    if($filter=='|'){
      $data['quality_score'] = $response['word_score']['quality_score'];
      $data['phone_score_list'] = array();
      foreach ($response['word_score']['phone_score_list'] as $key => $value) { 
        array_push($data['phone_score_list'], array('phone' => $value['phone'],
                                          'quality_score' => $value['quality_score'],
                                          ));
    }
    return json_encode($data);
    }
    $filterarray = explode('|', $filter);
    var_dump($filterarray);
    $data['quality_score'] = $response['word_score']['quality_score'];
    $data['phone_score_list'] = array();
    foreach ($response['word_score']['phone_score_list'] as $key => $value) {
      if(in_array($value['phone'], $filterarray)){
        array_push($data['phone_score_list'], array('phone' => $value['phone'],
                                          'quality_score' => $value['quality_score'],
                                          ));
      }
    }
    return json_encode($data);
  }
}
