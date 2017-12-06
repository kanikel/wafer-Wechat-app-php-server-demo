<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 前台父控制器
 */
class Home_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this -> load -> set_home_view_dir();
    }

}

/**
 * 后台父类控制器
 */
class Admin_Controller extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this -> load -> set_admin_view_dir();
        
    }

}
