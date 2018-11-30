<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User
{
    public function __construct(){
       
    }

    public function __get($var){
        return get_instance()->$var;
    }

    public function is_logged_in(){
        return (bool)$this->session->userdata('user_id');
    }

    public function data(){
        $this->load->model('core_db');
        return $this->core_db->user_data(intval($this->id()));
    }
	
	public function is_admin(){
		$this->load->model('core_db');
		$usr= $this->core_db->user_data(intval($this->id()));
		
		return ($usr->owner == "owner") ? true : false;
	}

    public function info($key = false){
        return ($key && $this->session->userdata($key)) ? $this->session->userdata($key) : null;
    }

    public function id(){
        return intval($this->info('user_id'));
    }

    public function force_to_login($uri = false){
        $this->session->set_userdata('redirect_to', (!$uri ? $this->uri->uri_string() : $uri));
        redirect(base_url('core/login'));
    }

}