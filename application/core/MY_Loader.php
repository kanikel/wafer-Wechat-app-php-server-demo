<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

    /**
     * 设置前台视图路径
     */
    public function set_home_view_dir() {
        $this -> _ci_view_paths = array(APPPATH . HOME_VIEW_DIR => TRUE);
    }

    /**
     * 设置后台视图路径
     */
    public function set_admin_view_dir() {
        $this -> _ci_view_paths = array(APPPATH . ADMIN_VIEW_DIR => TRUE);
    }

}
