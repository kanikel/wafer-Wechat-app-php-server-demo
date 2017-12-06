<?php
defined('BASEPATH') OR exit('no direct scripts allowed');
/**
 *
 */
class Character_model extends MY_Model
{

  function __construct()
  {
    parent::__construct();
  }
  function getDataJoin($table,$where,$field,$order,$join){
    if($order!='') $this->db->order_by($order);
    if($where!=''){
      $this->db->where($where)->select($field)->from($table)->join($join['table'],$join['condition']);
    }else{
      $this->db->select($field)->from($table)->join($join['table'],$join['condition']);
    }
    $query = $this->db->get();
    return $query->result_array();
  }
}
