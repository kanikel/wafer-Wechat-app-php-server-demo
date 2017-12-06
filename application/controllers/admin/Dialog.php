<?php
/**
* dialog management
*/
class Dialog extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('dialog_model','dialog');
		$this->load->helper('myfunction');
		$this->load->helper('url');
	}

	public function getDialog($id = -1){
		$field = '*';
		$order = 'dialog_id';
		if($id!=-1){
			$where['dialog_id'] = $id;
			$result = $this->dialog->getData('dialog',$where,$field,$order);
		}else{
			$result = $this->dialog->getData('dialog','',$field,$order);
		}
		if($result){
			ajaxReturn($result);
		}else{
			ajaxReturn('','0','no records');
		}
	}

	public function addDialog(){
		$data = $this->input->get();
		// $config['upload_path'] = './uploads/';
		// $config['allowed_type'] = 'jpg|png';
		// $config['max_width'] = 0;
		// $this->load->library('upload',$config);
		// foreach ($_FILE as $key => $value) {
		// 	if(!empty($key['name'])){
		// 		if($this->upload->do_upload($key)){
		// 			$type = $this->upload->data('file_ext');
		// 			if($type == '.silk')
		// 				$data['dialog_record_url'] = $this->upload->data('full_path');
		// 			else
		// 				$data['dialog_img_url'] = $this->upload->data('full_path');
		// 		}
		// 	}
		// }
		$result = $this->dialog->addData('dialog',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/dialog');
		}else{
			echo 'Failed';
		}
	}

	public function editDialog($id=-1){
		$data = $this->input->get();
		// $config['upload_path'] = './uploads/';
		// $config['allowed_type'] = '*';
		// $config['max_width'] = 0;
		// $this->load->library('upload',$config);
		// foreach ($_FILE as $key => $value) {
		// 	if(!empty($key['name'])){
		// 		if($this->upload->do_upload($key)){
		// 			$type = $this->upload->data('file_ext');
		// 			if($type == '.silk')
		// 				$data['dialog_record_url'] = $this->upload->data('full_path');
		// 			else
		// 				$data['dialog_img_url'] = $this->upload->data('full_path');
		// 		}
		// 	}
		// }
		$result = $this->dialog->editdata('dialog',$data);
		if($result){
			redirect('https://47281688.qcloud.la/admin/admin/dialog');
		}else{
			echo 'Failed';
		}
	}

	public function deleteDialog($id=-1){
		if($id == -1)
			ajaxReturn('','0','please ensure the parameter of the url');
		$where['dialog_id'] = $id;
		$result = $this->dialog->delData('dialog',$where);
		if($result)
			ajaxReturn();
		else
			ajaxReturn('','0','Failed! please try again');
	}
}
