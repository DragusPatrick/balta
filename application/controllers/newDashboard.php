<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class newDashboard extends CI_Controller {
    private $data = array();

    public function __construct(){
        parent::__construct();

        $this->load->model('core_db');
        $this->load->library('form_validation');
    }

    public function index() {

        $selectedDate = $this->input->get('date');
        $dateObject = new DateTime($selectedDate);
        $selectedDate = $dateObject->format('Y-m-d');

        $previousDay = date_sub($dateObject, date_interval_create_from_date_string('1 days'));
        $nextDay = date_add($dateObject, date_interval_create_from_date_string('1 days'));


        $todayReservations = $this->core_db->get_by_day($selectedDate);
        $previousDayReservations = $this->core_db->get_by_date($previousDay);
        $nextDayReservations = $this->core_db->get_by_date($nextDay);
        die('doi');

        $this->load->view('new-layout-admin', $this->data);
        $arrData['rezervare'] = $this->core_db->get_by_day(); // call the core_db getall function to get all data
        $this->load->view('newDashboard/list',$arrData); // pass all data to view

        foreach ($arrData as $day) {
            if($todayReservations == $day['data_s']) {
                return print "ceva";
            } else {
                return print "nimic";
            }
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
            $this->load->view('newDashboard/remove', $this->data);

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
