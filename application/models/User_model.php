<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
/**
 * user management
 */
class User_model extends MY_Model
{

  function __construct()
  {
    parent::__construct();
  }
  public function addUser($userdata){
  	$userinfo = $userdata['data']['userInfo'];
  	$query = $this->db->get_where('user',array('openid'=>$userinfo['openId']));
  	$row = '';
  	if($query){
  		$row = $query->result();
  	}else{
  		log_message('error','id err');
  		return -1;
  	}
  	if(sizeof($row) == 0){
  		#添加用户
  		$data = array('nickname' => $userinfo['nickName'],
  			'gender' => $userinfo['gender'],
  			'language' => $userinfo['language'],
  			'city' => $userinfo['city'],
  			'province' => $userinfo['province'],
  			'country' => $userinfo['country'],
  			'avatarUrl' => $userinfo['avatarUrl'],
  			'openid' => $userinfo['openId']);
  		$row = $this->db->insert('user',$data);
  		return $this->db->insert_id();
  	}
  	return $row['0']->user_id;
  }
  public function getuid(){
  	//获取用户openid
        $ui = LoginService::check();
        //检查失败的操作
        if($ui['code']==-1){
          return -1;
        }
        //检查成功的
        $uinfo = $ui['data']['userInfo'];
        //根据openid查询是否已经在用户表注册
        $query = $this->db->get_where('user',array('openid'=>$uinfo['openId']));
        $row = '';
        if($query){
             log_message('error', 'id ok');
            $row = $query->result();
        }else{
             log_message('error', 'id err');
             return -1;
        }
        //如果不存在则插入并返回新id
        if(sizeof($row)==0){
            log_message('error', 'new user insert' . "\n");
            $row = $this->db->insert('user',array('nickname'=>$uinfo['nickName'],
            'gender'=>$uinfo['gender'],
            'language'=>$uinfo['language'],
            'city'=>$uinfo['city'],
            'province'=>$uinfo['province'],
            'country'=>$uinfo['country'],
            'avatarUrl'=>$uinfo['avatarUrl'],
            'openId'=>$uinfo['openId']));
            return $this->db->insert_id();
        }
        return $row[0]->user_id;
  }
}
