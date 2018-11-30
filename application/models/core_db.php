<?php
class Core_db extends CI_Model{

    // Adaugata de mine (petru)
    public function __construct()
    {
        $this->load->database();
    }

    function register(){
    	$result = array(
            'type' => 'danger'
        );
        $post = $this->input->post();
        $user = $this->db->query("SELECT nume FROM useri WHERE mail = '{$post['mail']}'");
    	
        if($user->num_rows() < 1)
            {
                $new_user = array(
                    'mail'     => $post['mail'],
                    'nume'      => $post['nume'],
                    'parola'    => md5(md5($post['parola'])),
                    'telefon'   => $post['telefon']
                );
                if($this->db->insert('useri', $new_user)){
                    $result['type']     = 'success';
                    $result['message']  = 'Utilizatorul ' . $new_user['nume'] . ' a fost adaugat cu succes! Va redirectionam catre pagina de login';
                }else{
                    $result['message'] =' A intervenit o problem la procesarea datelor. Va rugam reincarcati pagina.';
                }
        }else{
             $result['message'] ='Email existent deja in baza de date';
        }

        return $result;
    }

    function login(){
        $response = array(
            'type' => 'danger'
        );
        $post = $this->input->post();
        $user = $this->db->get_where('useri', array('mail' => $post['mail'], 'parola' => md5(md5($post['parola']))));

        if($user->num_rows() == 1)
        {
            $user = $user->row();
            $this->set_session($user);
            $response['type']    = 'success';
            $response['message'] = 'Hello ' . $user->nume . ', welcome to Balta S.!';

        }
        else $response['message'] = 'Datele introduse sunt invalide';

        return $response;
    }

    function set_session($user){
        $session_data = array(
            'user_id'     => $user->id,
            'user_mail'  => $user->mail,
            'user_nume'   => $user->nume,
            'user_telefon'   => $user->telefon,
        );
        $this->session->set_userdata($session_data);
    }

    function getAvailableSpots(){
        $get = $this->input->get();
	    
    //Preluam toate locurile
        if($get['cazare']==0){
            //Preluam toate locatiile dupa tipul de cazare
            $locuri = $this->db->query("SELECT * FROM locatii WHERE tip_casa = 0 ");
        }else{
	
	        $locuri = $this->db->query("SELECT * FROM locatii WHERE tip_casa > 0 ");
        }
    
    //Luam Detaliile pentru fiecare loc
	    $locuri =  $locuri->result();
	    
	    //Unde stocam informatia
	    $spots= array();
	    
	    foreach ($locuri as $loc){
		    $spots[$loc->id_loc]=array(
		    	'zile' =>$this->detaliiLoc($loc->id_loc,$get['checkin'],$get['checkout'],$get['cazare']),
			    'tip_casa' => $loc->tip_casa,
			    'id' => $loc->id_loc,
			    'descriere' =>  $loc->descriere
		    );
	    }
	    return $spots;
    }
	
	function detaliiLoc($id_loc,$start_date,$end_date,$cazare){
		
		$begin = new DateTime( $start_date);
		$end = new DateTime($end_date);
		
		$dayList=array();
		
		if($cazare == 1)
		{
			// Daca doreste si cazare
			if($begin == $end)
			{
				//One Day
				$oneDay = $begin->format('Y-m-d');
				if(!in_array($oneDay, array('2017-09-22','2017-09-23','2017-09-24','2017-10-04','2017-10-05','2017-10-06','2017-10-07','2017-10-08'))){
					$sql = "SELECT * FROM rezervare r WHERE r.id_loc = {$id_loc} AND  '{$oneDay}' >= r.data_s  AND r.data_e >= '{$oneDay}' AND r.partial = 0";
					$checkDay= $this->db->query($sql);
					$dayList[$oneDay] = ($checkDay ->num_rows() == 0) ? 0 : 1;
				}
				
			}
			else
			{
				//More Days
				//$end->modify('+1 day');
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);
				
				//Parse each day
				foreach ( $period as $dt )
				{
					$zi = $dt->format('Y-m-d');
					//Temporary
					if(!in_array($zi, array('2017-09-22','2017-09-23','2017-09-24','2017-10-04','2017-10-05','2017-10-06','2017-10-07','2017-10-08'))){
						$sql = "SELECT * FROM rezervare r WHERE r.id_loc = {$id_loc} AND  '{$zi}' >= r.data_s  AND r.data_e >= '{$zi}' AND r.partial = 0";
						$checkDay= $this->db->query($sql);
						$dayList[$zi] = ($checkDay ->num_rows() == 0) ? 0 : 1;
					}
				}
			}
		}
		else
		{
			// Fara Cazare
			if($begin == $end)
			{
				//One Day
				$oneDay = $begin->format('Y-m-d');
				
				if(!in_array($oneDay, array('2017-09-22','2017-09-23','2017-09-24','2017-10-04','2017-10-05','2017-10-06','2017-10-07','2017-10-08'))){
					$sql = "SELECT * FROM rezervare r WHERE r.id_loc = {$id_loc} AND  '{$oneDay}' >= r.data_s  AND r.data_e >= '{$oneDay}' AND r.partial > 0";
					$checkDay= $this->db->query($sql);
					if($checkDay->num_rows() == 0 )
					{
						$dayList[$oneDay] = 0;
					}
					else
					{
						$sum = 0;
						foreach ($checkDay->result() as $d)
						{
							$sum = $sum + $d->partial;
						}
						$dayList[$oneDay] = $this->getDaySum($sum);
					}
				}
				
			}
			else
			{
				//More Days
				$end->modify('+1 day');
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);
				
				//Parse each day
				foreach ( $period as $dt )
				{
					$zi = $dt->format('Y-m-d');
					if(!in_array($zi, array('2017-09-22','2017-09-23','2017-09-24','2017-10-04','2017-10-05','2017-10-06','2017-10-07','2017-10-08'))){

							$sql = "SELECT * FROM rezervare r WHERE r.id_loc = {$id_loc} AND  '{$zi}' >= r.data_s  AND r.data_e >= '{$zi}' AND r.partial > 0";
							$checkDay= $this->db->query($sql);
							$sum = 0;
							foreach ($checkDay->result() as $d)
							{
								$sum = $sum + $d->partial;
							}
							$dayList[$zi] = $this->getDaySum($sum);
					}

				}
			}
		}
		
		
		return $dayList;
	}
	
    function getSpotDetails(){
        $get = $this->input->get();
        $begin = new DateTime( $get['date_s']);
        $end = new DateTime($get['date_e']);
        $dayList=array();
	    
        if($begin == $end){
                //One Day
                $oneDay = $begin->format('Y-m-d');
                $sql = "SELECT * FROM rezervare WHERE id_loc = {$get['id_loc']} AND  '{$oneDay}' >= data_s AND data_e >= '{$oneDay}'";
                $checkDay= $this->db->query($sql);
                if($checkDay->num_rows() == 0 ){
                    $dayList[$oneDay] = 0;
                }else{
                        $day=$checkDay->result();
                        $sum = 0;
                         foreach ($day as $d) {
                            $sum = $sum + $d->partial;
                        }
                        
                        $dayList[$oneDay] = $this->getDaySum($sum);
                        
                }

        }else{
            $end->modify('+1 day');
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);
            
	        foreach ( $period as $dt ){
                $zi = $dt->format('Y-m-d');
                $sql = "SELECT * FROM rezervare WHERE id_loc = {$get['id_loc']} AND  '{$zi}' >= data_s   AND data_e >= '{$zi}'";
                $checkDay= $this->db->query($sql);
                if($checkDay->num_rows() == 0 ){
                    $dayList[$zi] = 0;
                }else{
                    $day=$checkDay->result();
                    $sum = 0;
                     foreach ($day as $d) {
                        $sum = $sum + $d->partial;
                    }
                    
	                $dayList[$zi] =$this->getDaySum($sum);
                }
            }
            
        }
        return $dayList;
    }

    function user_data($id){
        $user = $this->db->query("SELECT * FROM useri WHERE id = {$id} ");
        if($user->num_rows() == 1){
            return $user->row();
        }else{
            return false;
        }
    }

    function reserve(){
        $result = array(
            'type' => 'danger'
        );
        
        $post = $this->input->post();
        
	    if($this->user->is_logged_in()){
		    //Get user data for insert
		    $user=$this->user->data();
			
		    //Parse each day for insert
		    foreach ($post['zile'] as $zi => $partial ) {
			    // Prepare Data
		    	if($post['cazare'] == 0 && $partial == 3)
		    	{
				    $new_reserve = array(
					    'id_loc'     => $post['loc'],
					    'id_user'    => $user->id,
					    'data_s'     => $zi,
					    'data_e'     => $zi,
					    'tip_pachet' => $post['pachet'],
					    'partial'    => 1,
					    'cost'       => $post['cost'],
					    'comment'       => $post['comment'],
				    );
				
				    $new_reserve2 = array(
					    'id_loc'     => $post['loc'],
					    'id_user'    => $user->id,
					    'data_s'     => $zi,
					    'data_e'     => $zi,
					    'tip_pachet' => $post['pachet'],
					    'partial'    => 2,
					    'cost'       => $post['cost'],
					    'comment'    => $post['comment'],
				    );
				    
				    if($this->db->insert('rezervare', $new_reserve) && $this->db->insert('rezervare', $new_reserve2))
				    {
					    $result['type']     = 'success';
					    $result['message'] = 'success';
				    }
				    else
			        {
					    $result['message'] =' A intervenit o problem la procesarea datelor. Va rugam reincarcati pagina.';
				    }
				    
			    }
			    else
		        {
				    $new_reserve = array(
					    'id_loc'     => $post['loc'],
					    'id_user'    => $user->id,
					    'data_s'     => $zi,
					    'data_e'     => $zi,
					    'tip_pachet' => $post['pachet'],
					    'partial'    => $partial,
					    'cost'       => $post['cost'],
					    'comment'       => $post['comment'],
				    );
				    if($this->db->insert('rezervare', $new_reserve))
				    {
					    $result['type']     = 'success';
					    $result['message'] = 'success';
				    }
				    else
			        {
					    $result['message'] =' A intervenit o problem la procesarea datelor. Va rugam reincarcati pagina.';
				    }
			    }
	        }
	        // End Parse each day for insert
       		

       		$sent = $this->sendProform($post,$user);
       		if(!$sent){
       			die('Exista o eroare la procesarea datelor! Va rugam contactati administratorul site-ului! ');
       		}
        }
        
        

        return $result;
    }
	
    // Function for inserting in database the proform and send email to user and administrator 

    function sendProform($data,$user){
    	
    	$configs = $this->getConfig();
    	
    	$date = date_create();
		$timestamp = date_timestamp_get($date);
		$link = md5(substr(base64_encode($timestamp), 0, 20));
		
		$time = time();
		$data15Zile = date("d/m/Y", mktime(0,0,0,date("n", $time),date("j",$time)+ 15 ,date("Y", $time)));
		$dataAstazi = date("d/m/Y");
		
    	$dataAstazi = date("d/m/Y");
		    $new_proform = array(
		       'nume' => $user->nume,
		       'email' => $user->mail,
		       'telefon' => $user->telefon,
		       'nrcr' => $data['nrcr'],
		       'costcr' => $configs->costcr,
		       'nrrc' => $data['nrrc'],
		       'costrc' => $configs->costrc,
		       'id_loc' => $data['loc'],
		       'costcazare' => $data['costcazare'],
		       'perioada'  => $data['perioada'],
		       'total'  => $data['cost'],
		       'id_user' => $user->id,
		       'hashcod' => $link,
		       'dataemitere' => $dataAstazi
		  	);

    		if($this->db->insert('program',$new_proform)){

    			// Send mail 
    			$last_id = $this->db->insert_id();

				$headers = 'From: Baltasolacolu.ro' . "\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
				$content_mail  = '<div class="email-wrapped">
								    <div style="overflow-x:auto;max-width:600px;width:100%;margin:0 auto;border-right:1px solid #ddd;border-left:1px solid #ddd;border-bottom:1px solid #ddd;border-top:3px solid #333;padding:15px 30px;color:#525252;background-color:#fff;font-size:16px;font-family:Arial, Helvetica, sans-serif;line-height:25px;">
								         <p style="font-size:14px;line-height:20px;">';
				$content_mail .='Stimate ' . $user->nume . ', ' ;
				$content_mail .='<br><br>
				            	 Prin acest mail va aducem la cunostinta ca vi s-a emis proforma nr.' . $last_id . ' din data ' . $dataAstazi . ', ';
				$content_mail .='<br><br>
				            	 Data scadenta a acestei facturi este: ' . $data15Zile .", " ;
				$content_mail .='<br><br>Pentru vizualizarea facturii va rugam sa accesati link-ul de mai jos.
				            	 <br><br>
				            	 <a rel="nofollow" target="_blank" href="http://new.baltasolacolu.ro/program/users/factura/' .$link . '"title="Vizualizare document" title-off="">Vezi Factura</a><br><br>Va multumim pentru colaborare!<br><br>S.C. DYNAMIC INVESTMENT SRL</p>';
				$content_mail .='<a rel="nofollow" target="_blank" href="http://new.baltasolacolu.ro/program/users/factura/' . $link . ' 				         	" style="color:rgb(255, 255, 255);cursor:pointer;min-height:30px;vertical-align:middle;white-space:nowrap;background:rgb(51, 123, 237);border:0px solid rgb(28, 108, 236);border-radius:2px 2px 2px 2px;font-family:Arial, Helvetica, sans-serif;font-size:13px;margin:40px 0px 0px;outline:none 0px;padding:6px 20px;text-decoration:none;">
				         Vezi Factura
				         </a>
				    </div>
				</div>';      

				mail('toma.g131@yahoo.com',"Factura proforma baltasolacolu.ro" ,$content_mail , $headers);
				
				mail('info@baltasolacolu.ro',"Factura proforma baltasolacolu.ro" ,$content_mail , $headers);
				
				mail($user->mail,"Factura proforma baltasolacolu.ro" ,$content_mail , $headers);
				

			return true;
		}else{
			return false;
		}
    }





    // Function for checking sumarry for days if are available : 0 - liber , 1 - ocupat pescuit zi , 2 - ocupat pescuit noapte, 3 - ocupat total
	function getDaySum($sum){
	    switch ($sum) {
		    case 0:
		    	return 0;
		        break;
		    case 1:
			    return 1;
			    break;
		    case 2:
			    return 2;
			    break;
		    case 3:
			    return 3;
			    break;
		    default :
			    return 3;
			    break;
	    }
	}
	
	
	//Admin
	//Get Rezerveri
	function get_Rezervari($id_loc = ''){
		
		$this->load->library('data_tables');
		
		$columns = array(
			array(
				'db' => 'id_rez',
				'dt' => 0
			),
			array(
				'db' => 'id_loc',
				'dt' => 1
			),
			array(
				'db' => 'id_user',
				'dt' => 2,
				'formatter' => function($d, $row)
				{
					$us = $this->user_data($row['id_user']);
					return $us->nume;
				}
			),
			array(
				'db' => 'id_user',
				'dt' => 3,
				'formatter' => function($d, $row)
				{
					$us = $this->user_data($row['id_user']);
					return $us->telefon;
				}
			),
			array(
				'db' => 'id_user',
				'dt' => 4,
				'formatter' => function($d, $row)
				{
					$us = $this->user_data($row['id_user']);
					return $us->mail;
				}
			),
			array(
				'db' => 'data_s',
				'dt' => 5
			),
			array(
				'db' => 'data_e',
				'dt' => 6
			),
			array(
				'db' => 'cost',
				'dt' => 7
			),
			array(
				'db' => 'partial',
				'dt' => 8,
				'formatter' => function($d, $row)
				{
					
					if($row['partial'] == 1){
					    return 'Pachet Zi';
					}elseif($row['partial'] == 2){
					    return 'Pachet Noapte';
					}elseif($row['partial'] == 3){
					    return 'Full';
					}else{
					    return 'None';
					}
					
				}
			),
			array(
				'db' => 'comment',
				'dt' => 9
			),
			array(
				'db' => 'id_rez',
				'dt' => 10,
				'formatter' => function($d, $row)
				{
					
					$actions = '<a href="dashboard/remove/' . $row['id_rez'] .'" class="remove btn"><i class="material-icons">delete</i></a>';
					return $actions;
				}
			)
		);
		return $this->data_tables->simple($this->input->post(), 'rezervare', 'id_rez', $columns);
	}
	
	
	//Get Rezerveri
	function get_Users(){
		
		$this->load->library('data_tables');
		
		$columns = array(
			array(
				'db' => 'id',
				'dt' => 0
			),
			array(
				'db' => 'nume',
				'dt' => 1
			),
			array(
				'db' => 'mail',
				'dt' => 2
			),
			array(
				'db' => 'telefon',
				'dt' => 3
			),
			array(
				'db' => 'owner',
				'dt' => 4
			),
			array(
				'db' => 'id',
				'dt' => 5,
				'formatter' => function($d, $row)
				{	
					$actions= '<a href="/program/users/view/' . $row['id'] .'" class="btn"><i class="material-icons">voicemail</i></a>';
					$actions.= '<a href="users/change/' . $row['id'] .'" class="change btn"><i class="material-icons">mode_edit</i></a>';
					$actions .= '<a href="users/remove/' . $row['id'] .'" class="remove btn"><i class="material-icons">delete</i></a>';
					return $actions;
				}
			)
		);
		return $this->data_tables->simple($this->input->post(), 'useri', 'id', $columns);
	}
	
	
	function rezervare_data($id_rez = 0){
		$rez = $this->db->query("SELECT * FROM rezervare WHERE id_rez = {$id_rez} ");
		if($rez->num_rows() == 1){
			return $rez->row();
		}else{
			return false;
		}
	}

	function remove_rezervare($id_rez = 0){
		$rez = $this->db->query("DELETE FROM rezervare WHERE id_rez = {$id_rez} ");
		return true;
	}
	
	function remove_users($id_user = 0){
		$rez = $this->db->query("DELETE FROM useri WHERE id = {$id_user} ");
		return true;
	}

	function getConfig(){
		$rez = $this->db->query("SELECT * FROM config WHERE id = 1");
		if($rez->num_rows() == 1){
			return $rez->row();
		}else{
			return false;
		}
	}

	function getfactura($hashcod){
		$rez = $this->db->query("SELECT * FROM program WHERE hashcod = '{$hashcod}'");
		if($rez->num_rows() == 1){
			return $rez->row();
		}else{
			return false;
		}	
	}

	//Get Rezerveri
	function get_Facturi($id_users = 0){
		
		$this->load->library('data_tables');
		
		$columns = array(
			array(
				'db' => 'id',
				'dt' => 0
			),
			array(
				'db' => 'nrcr',
				'dt' => 1
			),
			array(
				'db' => 'nrrc',
				'dt' => 2
			),
			array(
				'db' => 'id_loc',
				'dt' => 3
			),
			array(
				'db' => 'total',
				'dt' => 4
			),
			array(
				'db' => 'hashcod',
				'dt' => 5
			),
			array(
				'db' => 'dataemitere',
				'dt' => 6
			),
			array(
				'db' => 'id',
				'dt' => 7,
				'formatter' => function($d, $row)
				{
					$actions= '<a href="/program/users/factura/' . $row['hashcod'] .'" class="btn"><i class="material-icons">mode_edit</i></a>';
					return $actions;
				}
			)
		);
	
		
		$res = $this->data_tables->complex($this->input->post(), 'program', 'id', $columns,"id_user = ".$id_users);
		return $res;
	}
	

	function updateConfigs(){
		$post = $this->input->post();
		$response = array(
			'status' => 'error'
		);
		$update_config = array(
			'costcr' => $post['costcr'],
			'costrc' => $post['costrc'],
			'micadj' => $post['micadj'],
			'micavs' => $post['micavs'],
			'mediedj' => $post['mediedj'],
			'medievs' => $post['medievs'],
			'maredj' => $post['maredj'],
			'marevs' => $post['marevs'],
			'viladj' => $post['viladj'],
			'vilavs' => $post['vilavs'],
			'datefirma' => $post['datefirma']
		);
		$this->db->where('id', 1);
		if($this->db->update('config',$update_config)){
			$response['status'] = 'success';
			$response['message'] = 'Modificarile au fost salvate cu succes!';
		}else{
			$response['message'] = 'A intervenit o eroare la baza de date!';
		}
		return $response;
	}

	function getLoc($id_loc){
		$rez = $this->db->query("SELECT * FROM locatii WHERE id_loc = {$id_loc}");
		if($rez->num_rows() == 1){
			return $rez->row();
		}else{
			return false;
		}
	}

    function get_reservations_by_day($selectedDate) {
        $todayReservations = $this->db->query("SELECT *
                                    FROM rezervare
                                    INNER JOIN useri ON rezervare.id_user = useri.id
                                    INNER JOIN locatii ON rezervare.id_loc = locatii.id_loc 
                                    WHERE data_s <= {$selectedDate} <= data_e
                                    ORDER BY locatii.id_loc ASC
                                    ");

        if($todayReservations->num_rows()>0){
            return $todayReservations->result_array();
        } else {
            echo "<h1>Nimic de afisat</h1>";
        }
    }

    function get_by_date($selectedDate) {
        $todayReservations = $this->db->query("SELECT *
                                    FROM rezervare
                                    INNER JOIN useri ON rezervare.id_user = useri.id
                                    INNER JOIN locatii ON rezervare.id_loc = locatii.id_loc
                                    WHERE data_s = {$selectedDate} OR data_e = {$selectedDate}
                                    ORDER BY locatii.id_loc ASC
                                    ");

        if($todayReservations->num_rows()>0){
            return $todayReservations->result_array();
        } else {
            echo "<h1>Nimic de afisat</h1>";
        }


        $previousDayReservations = $this->db->query("SELECT *
                                    FROM rezervare
                                    INNER JOIN useri ON rezervare.id_user = useri.id
                                    INNER JOIN locatii ON rezervare.id_loc = locatii.id_loc
                                    WHERE data_s = {$selectedDate} -1 OR data_e = {$selectedDate} -1
                                    ORDER BY locatii.id_loc ASC
                                    ");

        if($previousDayReservations->num_rows()>0){
            return $previousDayReservations->result_array();
        } else {
            echo "<h1>Nimic de afisat</h1>";
        }

        $nextDayReservations = $this->db->query("SELECT *
                                    FROM rezervare
                                    INNER JOIN useri ON rezervare.id_user = useri.id
                                    INNER JOIN locatii ON rezervare.id_loc = locatii.id_loc
                                    WHERE data_s = {$selectedDate} +1 OR data_e = {$selectedDate} +1
                                    ORDER BY locatii.id_loc ASC
                                    ");

        if($nextDayReservations->num_rows()>0){
            return $nextDayReservations->result_array();
        } else {
            echo "<h1>Nimic de afisat</h1>";
        }

    }



}
