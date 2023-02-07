<?php

class Appointment extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = 'Appointment';
        $data['active_class'] = 'appointment';

        $event_data = "SELECT  `events`.*,
                                `users`.`id`,                                
                                `users`.`firstname`,
                                `users`.`lastname`,
                                `provider_user`.`firstname` as `provider_first_name`,
                                `provider_user`.`lastname` as `provider_last_name`,
                                `appointment_type`.`id`,
					            `appointment_type`.`appointment_name`,
					            `appointment_type`.`color_code`
                        FROM (`events`)
                        LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
                        LEFT JOIN `users` as `provider_user` ON `provider_user`.`id` = `events`.`created_by`
                        LEFT JOIN `appointment_type` ON `appointment_type`.`id` = `events`.`appointment_type`
                        ORDER BY `events`.`schedule_date` DESC";
        $data['event_data'] = $this->db->query($event_data)->result();
        $total_count = count($data['event_data']);
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/appointment/index", $total_count, $numlinks, $per_page, 4);

        $listProvider = new User();
        $listProvider->where('roles_id', 2);
        $listProvider->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listProvider->group_start();
            $listProvider->or_like('firstname', $fullname);
            $listProvider->or_like('lastname', $fullname);
            $listProvider->group_end();
        }
        if (!empty($email)) {
            $listProvider->group_start();
            $listProvider->or_like('email', $email);
            $listProvider->group_end();
        }

        // $listProvider->where('company_id', $data['global']['companyid']);
        $listProvider->order_by('firstname', 'ASC');
        $listProvider->order_by('lastname', 'ASC');
        $listProvider->get();

        //echo $this->db->last_query();

        foreach ($listProvider as $lip) {
            $userdetail = $lip->show_result();
            $userlisted[] = $userdetail['id'];
            $providerlist[] = $userdetail;
        }
        $data['providerlist'] = $providerlist;

        $this->load->view('admin/panel/appointment', $data);
    }

    public function filterByProvider($provider_id = '')
    {
        if ($provider_id) {
            $event_data = "SELECT  `events`.*,
                                `users`.`id`,                                
                                `users`.`firstname`,
                                `users`.`lastname`,
                                `provider_user`.`firstname` as `provider_first_name`,
                                `provider_user`.`lastname` as `provider_last_name`
                        FROM (`events`)
                        LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
                        LEFT JOIN `users` as `provider_user` ON `provider_user`.`id` = `events`.`created_by`
                        WHERE `events`.`created_by` = $provider_id 
                        ORDER BY `events`.`schedule_date` DESC";
        } else {
            $event_data = "SELECT  `events`.*,
                                `users`.`id`,                                
                                `users`.`firstname`,
                                `users`.`lastname`,
                                `provider_user`.`firstname` as `provider_first_name`,
                                `provider_user`.`lastname` as `provider_last_name`
                        FROM (`events`)
                        LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
                        LEFT JOIN `users` as `provider_user` ON `provider_user`.`id` = `events`.`created_by`";
        }

        $data['event_data'] = $this->db->query($event_data)->result();

        return $this->load->view('admin/panel/filter_appointment_details', $data);
    }

    public function getAppointmentType(){

        $data['page_title'] = 'Appointment Type';
        $data['active_class'] = 'appointment_type';

        $appoitment_type = "SELECT * FROM `appointment_type`";
        $data['appoitment_type'] = $this->db->query($appoitment_type)->result();

        return $this->load->view('admin/panel/appointment_list_details', $data);
    }

    public function addNewAppointmentType() {
        $sql = "INSERT INTO appointment_type (appointment_name,color_code) VALUES (?,?)";
		$this->db->query($sql, array($_POST['appointment_name'], $_POST['color']));

        if($this->db->affected_rows() != 1){
            $result['success'] = false;                                
            $result['message'] = "Appointment Type not Added";
            echo json_encode($result);
        }else{
            $result['success'] = true;                                
            $result['message'] = "Appointment Type Added successfully";
            echo json_encode($result);
        }
    }

    public function deleteAppointmentType($typeid = '')
	{
		$sql = "DELETE FROM appointment_type WHERE id = ?";
		$this->db->query($sql, array($typeid));
		
        if($this->db->affected_rows() != 1){
            $result['success'] = false;                                
            $result['message'] = "Appointment Type not deleted";
            echo json_encode($result);
        }else{
            $result['success'] = true;                                
            $result['message'] = "Appointment Type delete successfully";
            echo json_encode($result);
        }
	}

    public function editAppointmentType($typeid = ''){    
        $sql = "SELECT * FROM appointment_type WHERE id = '" . $typeid . "' ";        
        $result = $this->db->query($sql)->result();
        echo json_encode(array('status' => true, 'data' => $result));        
    }

    public function  updateAppointmentType(){        
        $sql = "UPDATE appointment_type SET appointment_name = ?, color_code = ? WHERE id = ?";
		$this->db->query($sql, array($_POST['appointment_name'], $_POST['color'], $_POST['id']));
        
        if($this->db->affected_rows() != 1 && $this->db->affected_rows() != 0){
            $result['success'] = false;                                
            $result['message'] = "Appointment Type details not updated";
            echo json_encode($result);
        }else{
            $result['success'] = true;                                
            $result['message'] = "Appointment Type details updated successfully";
            echo json_encode($result);
        }        
    }
}
