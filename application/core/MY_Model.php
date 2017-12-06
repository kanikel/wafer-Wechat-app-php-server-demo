<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

  function __construct(){
        parent::__construct();
        $this->load->database();
  }

  /**
	 * [getData description]
	 * @param  [array] $map   [查询字段]
	 * @param  [string] $field [返回字段]
	 * @return [array]        []
	 */
	public function getData($table='',$map='',$field='',$order=''){
    if($order!='') $this->db->order_by($order);
		if ($field=='') {
			//当返回字段为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> where($map)
							-> get($table);
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get($table);
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get($table);
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get($table);
			}
		}
		return $data->result_array();
	}

  /**
	 * [getData description]
	 * @param  [array] $map   [查询字段]
	 * @param  [string] $field [返回字段]
	 * @return [array]        []
	 */
	public function getDataObject($table='',$map='',$field='',$order=''){
    if($order!='') $this->db->order_by($order);
		if ($field=='') {
			//当返回字段为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> where($map)
							-> get($table);
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get($table);
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get($table);
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get($table);
			}
		}
		return $data->result();
	}

	public function getInfo($table='', $map){
		$data=$this -> db -> where($map) -> get($table);
		return $data -> row_array();
	}


	/**
	 * 添加数据
	 */
	public function addData($table='', $data){
		if (empty(self::getData($table, $data))) {
			return $result=$this -> db -> insert($table,$data);
		}
	}

	/**
	 * 编辑数据
	 */
	public function editData($table='', $data){
	    return $result=$this -> db ->replace($table,$data);
	}

  public function editMultiData($table='', $map, $data){
		return $result=$this -> db -> update($table, $data,$map);
	}

	/**
	 * 删除数据
	 */
	public function delData($table='', $map){
	    return $result=$this -> db ->delete($table,$map);
	}

  //获取符合条件的数据行数
  public function count($table='', $map){
		$this->db->where($map);
		$this->db->from($table);
		return $this->db->count_all_results();
	}

  //获取表总行数
	public function countAll($table=''){
		return $this -> db -> count_all($table);
	}



}
