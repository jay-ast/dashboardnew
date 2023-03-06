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
        $id = $_GET['id'];        
        $numlinks = 3;
        $per_page = 10;

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        $query_data = "SELECT * FROM events";
        $query_data = $this->db->query($query_data)->result();
        $total_count = count($query_data);

        $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                        provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                        appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                        event_transaction.event_id,event_transaction.payment_status');
        $this->db->from('events');
        $this->db->join('users', 'users.id = events.client_id', 'left');
        $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
        $this->db->join('appointment_type','appointment_type.id = events.appointment_type', 'left');
        $this->db->join('event_transaction','event_transaction.event_id = events.id', 'left');
        $this->db->order_by('events.schedule_date','DESC');
        $this->db->limit($per_page, (($page - 1) * $per_page));
        $event_data = $this->db->get();        
        $data['event_data'] = $event_data->result();

        $data["links"] = $this->paginationInit("admin/appointment/index", $total_count, $numlinks, $per_page, 4);

        $listProvider = new User();
        $listProvider->where_not_in('roles_id', 3);
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

        $listClients = new User();
        $listClients->where('roles_id', 3);
        $listClients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listClients->group_start();
            $listClients->or_like('firstname', $fullname);
            $listClients->or_like('lastname', $fullname);
            $listClients->group_end();
        }
        if (!empty($email)) {
            $listClients->group_start();
            $listClients->or_like('email', $email);
            $listClients->group_end();
        }

        // $listClients->where('company_id', $data['global']['companyid']);
        $listClients->order_by('firstname', 'ASC');
        $listClients->order_by('lastname', 'ASC');
        $listClients->get();

        //echo $this->db->last_query();

        foreach ($listClients as $lip) {
            $userdetail = $lip->show_result();
            $userlisted[] = $userdetail['id'];
            $clientlist[] = $userdetail;
        }

        $appoitment_type = "SELECT * FROM `appointment_type`";
        $data['appoitment_type'] = $this->db->query($appoitment_type)->result();

        $data['clientlist'] = $clientlist;
        $data['client_id'] = $id;
        $this->load->view('admin/panel/appointment', $data);
    }

    public function filterAppointmentData()
    {
        $client_id = $_POST['client_id'];
        $provider_id = $_POST['provider_id'];
        $numlinks = 3;
        $per_page = 10;

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        if (!empty($client_id) && !empty($provider_id)) {
            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                    provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                    appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                    event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->where('events.client_id', $client_id);
            $this->db->where('events.created_by', $provider_id);
            $this->db->order_by('events.schedule_date', 'DESC');
            $count_data = $this->db->get();
            $total_count = count($count_data->result());

            $data["links"] = $this->paginationInit("admin/appointment/index", $total_count, $numlinks, $per_page, 4);

            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                    provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                    appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                    event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->where('events.client_id', $client_id);
            $this->db->where('events.created_by', $provider_id);
            $this->db->order_by('events.schedule_date', 'DESC');
            $this->db->limit($per_page, (($page - 1) * $per_page));
            $event_data = $this->db->get();
        } else if ($client_id) {
            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                    provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                    appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                    event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->where('events.client_id', $client_id);
            $this->db->order_by('events.schedule_date', 'DESC');
            $count_data = $this->db->get();
            $total_count = count($count_data->result());

            $data["links"] = $this->paginationInit("admin/appointment/index", $total_count, $numlinks, $per_page, 4);

            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                    provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                    appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                    event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->where('events.client_id', $client_id);
            $this->db->order_by('events.schedule_date', 'DESC');
            $this->db->limit($per_page, (($page - 1) * $per_page));
            $event_data = $this->db->get();
        } else if ($provider_id) {
            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                    provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                    appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                    event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->where('events.created_by', $provider_id);
            $this->db->order_by('events.schedule_date', 'DESC');
            $count_data = $this->db->get();
            $total_count = count($count_data->result());

            $data["links"] = $this->paginationInit("admin/appointment/index", $total_count, $numlinks, $per_page, 4);

            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                    provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                    appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                    event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->where('events.created_by', $provider_id);
            $this->db->order_by('events.schedule_date', 'DESC');
            $this->db->limit($per_page, (($page - 1) * $per_page));
            $event_data = $this->db->get();
        } else {

            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                            provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                            appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                            event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->order_by('events.schedule_date', 'DESC');
            $count_data = $this->db->get();
            $total_count = count($count_data->result());

            $data["links"] = $this->paginationInit("admin/appointment/index", $total_count, $numlinks, $per_page, 4);

            $this->db->select('events.*, users.id as user_id, users.firstname, users.lastname,provider_user.firstname as provider_first_name,
                            provider_user.lastname as provider_last_name,appointment_type.id as appointment_id,appointment_type.appointment_name,
                            appointment_type.color_code,appointment_type.appointment_price,event_transaction.id as price_detail_id,
                            event_transaction.event_id,event_transaction.payment_status');
            $this->db->from('events');
            $this->db->join('users', 'users.id = events.client_id', 'left');
            $this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
            $this->db->join('appointment_type', 'appointment_type.id = events.appointment_type', 'left');
            $this->db->join('event_transaction', 'event_transaction.event_id = events.id', 'left');
            $this->db->order_by('events.schedule_date', 'DESC');
            $this->db->limit($per_page, (($page - 1) * $per_page));
            $event_data = $this->db->get();
        }
        //    $data['event_data'] = $this->db->query($event_data)->result();
        $data['event_data'] = $event_data->result();
        return $this->load->view('admin/panel/filter_appointment_details', $data);
    }

    public function getAppointmentType()
    {
        $data['page_title'] = 'Appointment Type';
        $data['active_class'] = 'appointment_type';

        $numlinks = 2;
        $per_page = 5;

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        $this->db->select('*');
        $this->db->from('appointment_type');            
        $count_data = $this->db->get();
        $total_count = count($count_data->result());    
        $data["links"] = $this->paginationInit("admin/appointment/getAppointmentType", $total_count, $numlinks, $per_page, 4);        

        $this->db->select('appointment_type.*,events.appointment_type, count(events.appointment_type) as event_count');
        $this->db->from('appointment_type');
        $this->db->join('events','events.appointment_type = appointment_type.id','left');
        $this->db->group_by('appointment_type.id');
        $this->db->limit($per_page, (($page - 1) * $per_page));
        $appoitment_type = $this->db->get();
        $data['appoitment_type'] = $appoitment_type->result();
                
        return $this->load->view('admin/panel/appointment_list_details', $data);
    }

    public function addNewAppointmentType()
    {
        $sql = "INSERT INTO appointment_type (appointment_name,color_code,appointment_price) VALUES (?,?,?)";
        $this->db->query($sql, array($_POST['appointment_name'], $_POST['color'], $_POST['appointment_price']));

        if ($this->db->affected_rows() != 1) {
            $result['success'] = false;
            $result['message'] = "Appointment Type not Added";
            echo json_encode($result);
        } else {
            $result['success'] = true;
            $result['message'] = "Appointment Type Added successfully";
            echo json_encode($result);
        }
    }

    public function deleteAppointmentType($typeid = '')
    {
        $sql = "DELETE FROM appointment_type WHERE id = ?";
        $this->db->query($sql, array($typeid));

        if ($this->db->affected_rows() != 1) {
            $result['success'] = false;
            $result['message'] = "Appointment Type not deleted";
            echo json_encode($result);
        } else {
            $result['success'] = true;
            $result['message'] = "Appointment Type deleted successfully";
            echo json_encode($result);
        }
    }

    public function editAppointmentType($typeid = '')
    {
        $sql = "SELECT * FROM appointment_type WHERE id = '" . $typeid . "' ";
        $result = $this->db->query($sql)->result();
        echo json_encode(array('status' => true, 'data' => $result));
    }

    public function  updateAppointmentType()
    {
        $sql = "UPDATE appointment_type SET appointment_name = ?, color_code = ?, appointment_price = ? WHERE id = ?";
        $this->db->query($sql, array($_POST['appointment_name'], $_POST['color'], $_POST['appointment_price'], $_POST['id']));

        if ($this->db->affected_rows() != 1 && $this->db->affected_rows() != 0) {
            $result['success'] = false;
            $result['message'] = "Appointment Type details not updated";
            echo json_encode($result);
        } else {
            $result['success'] = true;
            $result['message'] = "Appointment Type details updated successfully";
            echo json_encode($result);
        }
    }

    public function checkOutAppointment(){

        $from_email = $this->session->userdata('email');
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";			            
        $headers .= 'From: <' . $from_email . '>' . "\r\n";

        foreach ($_POST['event_data'] as $event_data) {            
            $logged_user_id = $this->session->userdata('userid');
            $data = "SELECT * from event_transaction WHERE event_id = '" . $event_data['event_id'] . "' ";
            $result = $this->db->query($data)->result();
            if (!empty($result)) {
                foreach($result as $res){
                    if($event_data['use_wallet'] == "true"){                        
                        $this->db->select('client_balance_summary.*');
                        $this->db->from('client_balance_summary');
                        $this->db->where('client_id', $event_data['client_id']);
                        $this->db->where('appointment_type_id',$event_data['appointment_type_id']);
                        $data = $this->db->get();
                        $data = $data->result();
                        foreach($data as $val){                                                            
                            if($val->appointment_balance > $res->price){                                                          
                                $balance = $val->appointment_balance - $res->price;
                            
                                $sql = "UPDATE event_transaction SET `payment_status` = ?, `amount_type` = ? WHERE event_id = ?";
                                $this->db->query($sql, array('paid', 'wallet' ,$event_data['event_id']));             

                                $sql = "UPDATE client_balance_summary SET appointment_balance = ? WHERE id = ?";
                                $this->db->query($sql, array($balance, $val->id));

                                $query = "INSERT INTO client_wallet_transaction(client_id, appointment_type_id, event_id,used_balanced, transsaction_type) VALUES (?,?,?,?,?)";
                                $this->db->query($query, array($event_data['client_id'],$event_data['appointment_type_id'],$event_data['event_id'],$res->price, 'debit'));
                                
                            }else{                                
                                $wallet_balance = $val->appointment_balance;
                                $direct_payment = $res->price - $val->appointment_balance;
                                
                                $sql = "UPDATE event_transaction SET `payment_status` = ?, `price` = ?, `amount_type` = ? WHERE event_id = ?";
                                $this->db->query($sql, array('paid', $wallet_balance ,'wallet' ,$event_data['event_id']));             

                                $query = "INSERT INTO event_transaction (event_id, client_id, appointment_id, provider_id, price, payment_status, amount_type) VALUES (?,?,?,?,?,?,?)";
                                $this->db->query($query, array($event_data['event_id'], $event_data['client_id'], $event_data['appointment_type_id'], $logged_user_id, $direct_payment, 'paid', 'Mastercard'));

                                $query = "INSERT INTO client_wallet_transaction(client_id, appointment_type_id, event_id,used_balanced, transsaction_type) VALUES (?,?,?,?,?)";
                                $this->db->query($query, array($event_data['client_id'],$event_data['appointment_type_id'],$event_data['event_id'],$wallet_balance, 'debit'));

                                $balance = 0;
                                $sql = "UPDATE client_balance_summary SET appointment_balance = ? WHERE id = ?";
                                $this->db->query($sql, array($balance, $val->id));                                
                            }
                        }
                    }else{
                        $sql = "UPDATE event_transaction SET `payment_status` = ?, `amount_type` = ? WHERE event_id = ?";
                        $this->db->query($sql, array('paid','Mastercard' ,$event_data['event_id']));       
                    }

                    $this->db->select('event_transaction.*,appointment_type.id as appointment_type_id, appointment_type.appointment_name, users.id as user_id,users.firstname,users.lastname,users.email');
                    $this->db->from('event_transaction');                    
                    $this->db->join('appointment_type','appointment_type.id = event_transaction.appointment_id','left');
                    $this->db->join('users', 'users.id = event_transaction.client_id','left');
                    $this->db->where('event_transaction.event_id', $event_data['event_id']);
                    $appoitment_type = $this->db->get();
                    $result = $appoitment_type->result();
                    $useremail = $result[0]->email;     
                    $body = $this->load->view('emails/receipt', ['result' => $result], true);                            			                    
			        $to = $useremail;
                    $result = my_email_send($to, "Payment Receipt", "receipt", array('msg_data' => $body), 'support@perfect-forms.net');
                    return $result;                    
                }                
            } else {
                // $data = "SELECT  `events`.*,
                //     `appointment_type`.`id` as `appointment_id`,
				//     `appointment_type`.`appointment_name`,
				//     `appointment_type`.`color_code`,
                //     `appointment_type`.`appointment_price`,                    
                //     `event_transaction`.`id` as `price_detail_id`,
                //     `event_transaction`.`event_id`,
                //     `event_transaction`.`payment_status`
                // FROM (`events`)                
                // LEFT JOIN `event_transaction` ON `event_transaction`.`event_id` = `events`.`id`
                // LEFT JOIN `appointment_type` ON `appointment_type`.`id` = `events`.`appointment_type`
                // WHERE `events`.`id` = $event_id";

                // $result = $this->db->query($data)->result();
                // foreach ($result as $val) {
                //     $query = "INSERT INTO event_transaction (event_id, client_id, appointment_id, provider_id, price, payment_status) VALUES (?,?,?,?,?,?)";
                //     $this->db->query($query, array($event_id, $val->client_id, $val->appointment_type, $logged_user_id, $val->appointment_price, 'paid'));

                //     $query = "INSERT INTO client_wallet_transaction(client_id, appointment_type_id, event_id,used_balanced, transsaction_type) VALUES (?,?,?,?,?)";
                //     $this->db->query($query, array($val->client_id, $val->appointment_type, $event_id,$val->appointment_price, 'debit'));
                // }
            }
        }        
        if ($this->db->affected_rows() != 1) {
            $result['success'] = false;
            $result['message'] = "Appointment not checkout successfully";
            echo json_encode($result);
        } else {
            $result['success'] = true;
            $result['message'] = "Appointment checkout successfully";
            echo json_encode($result);
        }
    }
}
