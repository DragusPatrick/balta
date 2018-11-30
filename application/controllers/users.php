<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Users extends CI_Controller {
		private $data = array();
		
		public function __construct(){
			parent::__construct();
		}
		
		public function index()
		{

			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{
				$response = array();
				
				if($this->user->is_logged_in())
				{
					$this->load->model('core_db');
					
					$response = $this->core_db->get_Users();
				}
				else $response['error'] = 'Trebuie sa fii logat pentru a vedea aceasta lista.';
				
				echo json_encode($response);
			}
			else
			{
				if($this->user->is_logged_in())
				{
					$this->load->model('core_db');
					
					
					$this->data['page'] = array(
						'title'     => 'Useri',
						'content'   => $this->load->view('users/list','', true)
					);
					
					$this->load->view('layout-admin', $this->data);
				}
				else $this->user->force_to_login();
			}
		}
		
		//Edit Function
		public function change($id_user = 0)
		{
			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{
				$this->load->model('core_db');
				$user_val = $this->core_db->user_data($id_user);
				$this->data['user_val'] = $user_val;
				$this->load->view('users/edit', $this->data);
			}
		}

		//Edit Function
		public function view($id_user = 0)
		{
			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{
				$response = array();
				
				if($this->user->is_logged_in())
				{
					$this->load->model('core_db');	
					$response = $this->core_db->get_Facturi($id_user);
				}
				else $response['error'] = 'Trebuie sa fii logat pentru a vedea aceasta lista.';
				echo json_encode($response);
			}
			else
			{
				if($this->user->is_logged_in())
				{
					$this->load->model('core_db');
					$this->data['page'] = array(
						'title'     => 'Facturi Useri',
						'content'   => $this->load->view('users/list-rezervari',array('user'=>$this->core_db->user_data($id_user) ), true)
						
					);
					
					$this->load->view('layout-admin', $this->data);
				}
				else $this->user->force_to_login();
			}
		}


		//Proform FUnction
		public function factura($hashcod = 0)
		{

			$this->load->model('core_db');	
			$date_factura =  $this->core_db->getfactura($hashcod);
			
			if($date_factura){
				//var_dump($date_factura);
				$date_firma =  $this->core_db->getConfig();
				$date_loc = $this->core_db->getLoc($date_factura->id_loc);

				$this->load->view('users/factura', array('detalii' => $date_factura,
														 'firma' =>$date_firma,
														 'date_loc' => $date_loc)
				);				
			}else{
				die('Error 404');
			}

			
		}
		
		
		//Remove User Function
		public function remove($id_user = 0)
		{
			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{
				$this->load->model('core_db');
				$user = $this->core_db->user_data($id_user);
				$this->load->view('users/remove', $user);
			}else{
				die('Not Allowed');
			}
		}
		
		//Remove Ajax Function_ for user
		public function remove_user($id_user = 0)
		{
			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{
				$response  = array('status' =>'success' ,'message' => 'Userul a fost sters cu success');
				$this->load->model('core_db');
				$remove = $this->core_db->remove_users(intval($id_user));
				echo json_encode($response);
			}else{
				die('Not Allowed');
			}
		}
		
	}
