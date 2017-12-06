<?php
/**
* admin
*/
class Admin extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('story_model','story');
		$this->load->model('map_model','map');
		$this->load->model('character_model','character');
		$this->load->model('dialog_model','dialog');
		$this->load->model('test_model','test');
		$this->load->model('test_dialog_model','test_dialog');
		$this->load->helper('url');
	}
	public function index()
	{
		if(isset($_SESSION['admin_account'])){
			$this->load->view('index.html');
		}else{
			redirect('https://47281688.qcloud.la/index.php/admin/admin/login');
			exit();
		}
	}
	public function checkLogin(){
		$this->load->model('admin_model','admin');
		$data = $this->input->get();
		$where['admin_account'] = $data['account'];
		$where['admin_password'] = md5($data['password']);
		$result = $this->admin->getData('admin',$where);
		if($result){
			$this->session->set_userdata('admin_account',$data['account']);
			redirect('https://47281688.qcloud.la/index.php/admin/admin/index');
		}else{
			ajaxReturn('','0','account or password is wrong!');
		}
	}
	public function logout(){
		if(isset($_SESSION['admin_account']))
			unset($_SESSION['admin_account']);
		redirect('/index');
	}
	public function welcome(){
		$this->load->view('welcome.html');
	}
	public function userShow(){
		$this->load->view('userShow.html');
	}
	public function userList(){
		$this->load->view('userList.html');
	}
	public function userAdd(){
		$this->load->view('userView.html');
	}
	public function login(){
		$this->load->view('login.html');
	}
	public function paylog(){
		$this->load->view('paylog.html');
	}
	public function fileList(){
		$this->load->view('fileList.html');
	}
	public function story(){
		$this->load->view('story.html');
	}
	public function storyAdd(){
		$this->load->view('storyAdd.html');
	}
	public function storyEdit() {
		$map['story_id'] = $this -> input -> get('story_id');
		$data = $this -> story -> getInfo('story', $map);
    $this-> parser -> parse('storyEdit.html', $data);
	}
	public function map(){
		$this->load->view('map.html');
	}
	public function mapAdd(){
		$this->load->view('mapAdd.html');
	}
	public function mapEdit() {
		$map['map_id'] = $this -> input -> get('map_id');
		$data = $this -> map -> getInfo('map', $map);
    $this-> parser -> parse('mapEdit.html', $data);
	}
	public function dialog(){
		$this->load->view('dialog.html');
	}
	public function dialogAdd(){
		$this->load->view('dialogAdd.html');
	}
	public function dialogEdit() {
		$map['dialog_id'] = $this -> input -> get('dialog_id');
		$data = $this -> dialog -> getInfo('dialog', $map);
    $this-> parser -> parse('dialogEdit.html', $data);
	}
	public function character(){
		$this->load->view('character.html');
	}
	public function characterAdd(){
		$this->load->view('characterAdd.html');
	}
	public function characterEdit() {
		$map['character_id'] = $this -> input -> get('character_id');
		$data = $this -> character -> getInfo('character', $map);
    $this-> parser -> parse('characterEdit.html', $data);
	}
	public function score(){
		$this->load->view('score.html');
	}
	public function picturequery(){
		$this-> load ->view('picturequery.html');
	}
	public function pictureadd(){
		$this-> load ->view('pictureadd.html');
	}
	public function test(){
		$this-> load ->view('test.html');
	}
	public function testAdd(){
		$this-> load ->view('testAdd.html');
	}
	public function testEdit(){
		$map['test_id'] = $this -> input -> get('test_id');
		$data = $this -> test -> getInfo('test', $map);
    $this-> parser -> parse('testEdit.html', $data);
	}
	public function testContent(){
		$this-> load ->view('testContent.html');
	}
	public function testContentAdd(){
		$this-> load ->view('testContentAdd.html');
	}
	public function testContentEdit(){
		$map['test_dialog_id'] = $this -> input -> get('test_dialog_id');
		$data = $this -> test_dialog -> getInfo('test_dialog', $map);
    $this-> parser -> parse('testContentEdit.html', $data);
	}
	public function tgrade(){
		$this-> load ->view('tgrade.html');
	}
}
?>
