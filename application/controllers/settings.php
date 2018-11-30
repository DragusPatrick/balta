<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Settings extends CI_Controller {
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
				$response = array(
					'status' => 'error',
				);
				
				if($this->user->is_logged_in() )
				{
					$this->load->model('core_db');	
					$this->load->library('form_validation');
					
					if($this->form_validation->run('settings') != FALSE){
						$response = $this->core_db->updateConfigs();
						
					}else{
						$response['message'] = $this->form_validation->error_message();
					}

				}
				else $response['message'] = 'Trebuie sa fii logat pentru a vedea aceasta lista.';
				
				echo json_encode($response);
			}
			else
			{
				if($this->user->is_logged_in())
				{
					$this->load->model('core_db');
					
					$content = $this->core_db->getConfig();
					//var_dump($content);

					$content_vars  = array(
						'costcr' => $content->costcr,
						'costrc' => $content->costrc,
						'micadj' => $content->micadj,
						'micavs' => $content->micavs,
						'mediedj' => $content->mediedj,
						'medievs' => $content->medievs,
						'maredj' => $content->maredj,
						'marevs' => $content->marevs,
						'viladj' => $content->viladj,
						'vilavs' => $content->vilavs,
						'datefirma' => $content->datefirma
					);
					$this->data['page'] = array(
						'title'     => 'Setari',
						'content'   => $this->load->view('dashboard/settings',$content_vars, true)
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
		
	}
