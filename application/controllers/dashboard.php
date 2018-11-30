<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Dashboard extends CI_Controller {
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
				
				if($this->user->is_logged_in() )
				{
					$this->load->model('core_db');
					
					$response = $this->core_db->get_Rezervari("");
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
						'title'     => 'Rezervari',
						'content'   => $this->load->view('dashboard/list','', true)
					);
					
					$this->load->view('layout-admin', $this->data);
				}
				else $this->user->force_to_login();
			}
		}
		
		
		
		//Edit Function
		public function change($id_rezervare = 0)
		{
			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{
				$this->load->model('core_db');
				$rezervare = $this->core_db->rezervare_data(intval($id_rezervare));
				$this->data['rezervare'] = $rezervare;
				$this->data['user_rezervare'] = $this->core_db->user_data($rezervare->id_user);
				$this->load->view('dashboard/edit', $this->data);
			}
		}


		//Edit Function
		public function remove($id_rezervare = 0)
		{
			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{	
				$this->load->model('core_db');
				$rezervare = $this->core_db->rezervare_data(intval($id_rezervare));
				$this->data['rezervare'] = $rezervare;
				$this->data['user_rezervare'] = $this->core_db->user_data($rezervare->id_user);
				$this->load->view('dashboard/remove', $this->data);

				// $this->load->model('core_db');
				// $remove = $this->core_db->remove_rezervare(intval($id_rezervare));
				// echo json_encode($remove);
			}else{
				die('Not Allowed');
			}
		}

		//remove_rezervare
		public function remove_rezervare($id_rezervare = 0)
		{
			if(!$this->user->is_admin()){
				redirect(base_url());
			}
			
			if(is_ajax_request())
			{	
				$response  = array('status' =>'success' ,'message' => 'Rezervarea a fost stearsa cu success');
				$this->load->model('core_db');
				$remove = $this->core_db->remove_rezervare(intval($id_rezervare));
				echo json_encode($response);
			}else{
				die('Not Allowed');
			}
		}

		
	}
