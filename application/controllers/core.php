<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {
	private $data = array();
	
	public function __construct(){
        parent::__construct();
	}

	public function index(){
		
		$this->load->model('core_db');
		$configs = $this->core_db->getConfig();
		
		if(!$this->user->is_logged_in()){
			$content_vars = array(
					'loggedIn' => $this->user->is_logged_in(),
					'configs'	=> (array) $configs
			);  
		}else{
			$content_vars = array(
					'loggedIn' => $this->user->is_logged_in(),
					'user' => $this->user->data(),
					'configs'	=> (array) $configs
			);  
		}
        $this->data['page'] = array(
            'content' => $this->load->view('welcome2', $content_vars, true),
            'title' => 'Welcome Page',
            'loggedIn' => $this->user->is_logged_in()
        );
		
        $this->load->view('layout', $this->data);
	}

	public function login(){
		if(!$this->user->is_logged_in()){
			$content_vars = array();
			$this->data['page'] = array(
	            'content' => $this->load->view('login', $content_vars, true),
	            'title' => 'Login Page'
	        );
	        $this->load->view('layout', $this->data);
	    }else{
	    	redirect('/');
	    }
	
	}

	public function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }

	public function register(){
		if(!$this->user->is_logged_in()){
			$content_vars = array();
			$this->data['page'] = array(
            'content' => $this->load->view('register', $content_vars, true),
            'title' => 'Register Page'
	        );
	        $this->load->view('layout', $this->data);
		}else{
	    	redirect('/');
	    }
	}
	
	public function rezervare(){
		if($this->user->is_logged_in()){
			$content_vars = array();
			$this->data['page'] = array(
	            'content' => $this->load->view('reserve', $content_vars, true),
	            'title' => 'Reserve Page'
	        );
	        $this->load->view('layout', $this->data);
		}else{
			die('not logged in');
		}	
	}

	/* Register Ajax functions */
	public function register_ajax(){
		$this->load->library('form_validation');
		
		if ($this->form_validation->run('register') == FALSE) {
                $response = array(
                    'type' => 'danger',
                    'message' => $this->form_validation->error_message()
                );
        }else{
                $this->load->model('core_db');
                $response = $this->core_db->register();
        }

        echo json_encode($response);
	}

	/* Login Ajax functions */
	public function login_ajax(){
		$this->load->library('form_validation');
		
		if ($this->form_validation->run('login') == FALSE) {
                $response = array(
                    'type' => 'danger',
                    'message' => $this->form_validation->error_message()
                );
        }else{
               
                $this->load->model('core_db');
                $response = $this->core_db->login();
        }
        echo json_encode($response);
	}

	/* Check Available Spots Ajax Functions */
	public function check_spots_ajax(){
		$this->load->model('core_db');
        $response =$this->core_db->getAvailableSpots();
        
        echo json_encode($response);
	}

	public function check_spot_ajax(){
		$this->load->model('core_db');
        $response =$this->core_db->getSpotDetails();
        
        echo json_encode($response);
	}

	/* Make Reservation Ajax Functions */
	public function confirmareRezervare_ajax(){
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->load->model('core_db');
			$response = $this->core_db->reserve();
			echo json_encode($response);
		}else{
			die();
		}
	}
	
	
}
