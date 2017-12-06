<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * user management
 */
class Score_model extends MY_Model
{

  function __construct()
  {
    parent::__construct();
  }
  public function addData($table='', $data){
  	$map['user_id'] = $data['user_id'];
  	$map['character_id'] = $data['character_id'];
  	$map['dialog_id'] = $data['dialog_id'];
  	$result = self::getData($table,$map);
		if (empty($result)){
			 if($this -> db -> insert($table,$data)){
				 return $this->db->insert_id();
			 }
			else
				return -1;
		}else{
			 self::editMultiData($table,$map,$data);
			 return $result[0]['score_id'];
		}
	}
}
