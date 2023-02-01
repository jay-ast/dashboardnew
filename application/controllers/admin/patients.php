<?php

class Patients extends My_Controller
{

    public function __construct()
    {

        parent::__construct();
        // ini_set('display_errors',1);
        //var_dump($this->session->userdata('roleid'));exit;
        if ($this->session->userdata('roleid') != 2) { // not a tharapist
            //print_r($this->session->userdata);exit;
            /*if ($this->session->userdata('companyid') > 0) { // company admin and user
                redirect('/admin/therapists');
            }*/
            if ($this->session->userdata('companyid') == 0) { //super admin
                redirect('/admin/companies');
            }
        }
    }

    public function index()
    {

        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Clients';
        $data['active_class'] = 'patient';
        $therapist_id = $data['global']['userid'];
        if (!empty($_POST)) {
            if (!empty($_POST['fullname']))
                $data['fullname'] = $fullname = $_POST['fullname'];
            if (!empty($_POST['email']))
                $data['email'] = $email = $_POST['email'];
        }
        //count all patients here role id= 3
        $listPatients = new Patient();
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }
        $listPatients->where('roles_id', 3);
        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->where('isdeleted', 0);

        $listPatients->get();
        //paginition
        $totalresult = $listPatients->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/patients/index", $totalresult, $numlinks, $per_page, 4);

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        if ($this->uri->segment(5)) {
            $data['userid'] = $this->uri->segment(5);
        } else {
            $data['userid'] = '';
        }

        //count all patients here role id= 3
        $listPatients = new User();
        $listPatients->where('roles_id', 3);
        $listPatients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }

        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');
        $listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();

        //echo $this->db->last_query();

        foreach ($listPatients as $lip) {
            $userdetail = $lip->show_result();
            $userlisted[] = $userdetail['id'];
            $data['patientlist'][] = $userdetail;
        }
        if ($this->uri->segment(5) && (!in_array($userlisted))) {

            $userdetail = new User();
            $userdetail->where('id',  $data['userid']);
            $userdetail->get();;
            $data['patientlist'][] = $userdetail->show_result();
        }


        //get all exercies of therapist
        $exercies = new Exercise();
        $exercies->where('company_id', $data['global']['companyid']);
        $exercies->where('isdeleted', 0);
        $exercies->get();
        $data['generalexercies'] = array();
        $data['exerciesvideos'] = array();

        /* $this->db->select('exercise.*,exercisefolder_exercise.exercisefolder_id as folderid');
                $this->db->from('exercise_folder');
                $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted',0);               
                //$this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
                $getEx=$this->db->get(); */


        //                $this->db->select('exercise.*,exercisefolder_exercise.exercisefolder_id as folderid,exercisefolder_exercise.insert_at as insertdate');
        $this->db->select('exercise.*');
        $this->db->from('exercise_folder');
        $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
        $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
        $this->db->where('exercise.isdeleted', 0);

        $this->db->where('exercise_folder.client_id', 0);
        //$this->db->where('exercise_folder.client_id', $patient_id);
        $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
        $this->db->group_by('exercise.id');
        $this->db->order_by('exercise.name', 'ASC');
        $getEx = $this->db->get();
        //echo $this->db->last_query();exit;
        foreach ($getEx->result() as $ges) {

            $temp['name'] = $ges->name;
            $temp['id'] = $ges->id;
            $temp['folderid'] = $ges->folderid;
            $data['generalexercies'][] = $temp;
        }

        $this->load->view('admin/panel/patients', $data);
    }

    public function index_search()
    {

        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Clients';
        $data['active_class'] = 'patient';
        $therapist_id = $data['global']['userid'];
        if (!empty($_POST)) {
            if (!empty($_POST['fullname']))
                $data['fullname'] = $fullname = $_POST['fullname'];
            if (!empty($_POST['email']))
                $data['email'] = $email = $_POST['email'];
        }



        //count all patients here role id= 3
        $listPatients = new Patient();
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }
        $listPatients->where('roles_id', 3);
        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->where('isdeleted', 0);

        $listPatients->get();
        //paginition
        $totalresult = $listPatients->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/patients/index", $totalresult, $numlinks, $per_page, 4);

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        if ($this->uri->segment(5)) {
            $data['userid'] = $this->uri->segment(5);
        } else {
            $data['userid'] = '';
        }

        //count all patients here role id= 3
        $listPatients = new User();
        $listPatients->where('roles_id', 3);
        $listPatients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }

        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');
        $listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();

        //echo $this->db->last_query();

        foreach ($listPatients as $lip) {
            $userdetail = $lip->show_result();
            $userlisted[] = $userdetail['id'];
            $userdetail['myfullname'] = $userdetail["firstname"] . " " . $userdetail["lastname"];
            $userdetail['logininformation'] = $userdetail["email"] . " (" . $userdetail["password"] . ")";
            $data['patientlist'][] = $userdetail;
        }
        if ($this->uri->segment(5) && (!in_array($userlisted))) {

            $userdetail = new User();
            $userdetail->where('id',  $data['userid']);
            $userdetail->get();;
            $data['patientlist'][] = $userdetail->show_result();
        }


        //get all exercies of therapist
        $exercies = new Exercise();
        $exercies->where('company_id', $data['global']['companyid']);
        $exercies->where('isdeleted', 0);
        $exercies->get();
        $data['generalexercies'] = array();

        $this->db->select('exercise.*');
        $this->db->from('exercise_folder');
        $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
        $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
        $this->db->where('exercise.isdeleted', 0);

        $this->db->where('exercise_folder.client_id', 0);
        //$this->db->where('exercise_folder.client_id', $patient_id);
        $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
        $this->db->group_by('exercise.id');
        $this->db->order_by('exercise.name', 'ASC');
        $getEx = $this->db->get();
        //echo $this->db->last_query();exit;
        foreach ($getEx->result() as $ges) {

            $temp['name'] = $ges->name;
            $temp['id'] = $ges->id;
            $temp['folderid'] = $ges->folderid;
            $data['generalexercies'][] = $temp;
        }

        echo json_encode($data);
    }

    public function indexx()
    {
        echo "11111";
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Clients';
        $data['active_class'] = 'patient';
        $therapist_id = $data['global']['userid'];
        if (!empty($_POST)) {
            if (!empty($_POST['fullname']))
                $data['fullname'] = $fullname = $_POST['fullname'];
            if (!empty($_POST['email']))
                $data['email'] = $email = $_POST['email'];
        }
        //count all patients here role id= 3
        $listPatients = new Patient();
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }
        $listPatients->where('roles_id', 3);
        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->where('isdeleted', 0);

        $listPatients->get();
        //paginition
        $totalresult = $listPatients->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/patients/index", $totalresult, $numlinks, $per_page, 4);

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        //count all patients here role id= 3
        $listPatients = new User();
        $listPatients->where('roles_id', 3);
        $listPatients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }

        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');
        $listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();

        //echo $this->db->last_query();

        foreach ($listPatients as $lip) {
            $data['patientlist'][] = $lip->show_result();
        }

        //get all exercies of therapist
        $exercies = new Exercise();
        $exercies->where('company_id', $data['global']['companyid']);
        $exercies->where('isdeleted', 0);
        $exercies->get();
        $data['exercies'] = array();
        if ($exercies->exists()) {
            foreach ($exercies as $exc) {
                $data['exercies'][] = $exc->show_result();
            }
        }




        $this->load->view('admin/panel/patients', $data);
    }

    public function addNewPatient()
    {
        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('firstname', "First Name", "required");
            //$this->form_validation->set_rules('phone', "Pgone", "required");
            //$this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "Please provide valid data");
                redirect('admin/patients');
            }

            //validate email address for exsisting
            $para['email'] = default_value($this->input->post("email"), "");
            $validateEmail = new Authentication();
            $user_data = $validateEmail->get_by_email($para['email']);
            if ($validateEmail->exists()) {
                $result['success'] = false;
                $result['issue'] = 'email';
                $result['patient_id'] = !empty($user_data->id) ? $user_data->id : '';
                $result['message'] = "Email ID is already used by other Client";

                echo json_encode($result);

                /*
					my_alert_message("danger", "Email ID is already used by other User");
					redirect('admin/patients');
*/
                /*
	                                
	            $result['success']=false;
                $result['message']="Email ID is already used by other Client";
				echo json_encode($result);
				exit;
*/
                //                redirect('admin/patients');
            } else {




                $para['firstname'] = default_value($this->input->post("firstname"), "");
                $para['lastname'] = default_value($this->input->post("lastname"), "");
                $para['password'] = default_value($this->input->post("password"), "perfectforms");
                $para['phone'] = default_value($this->input->post("phone"), "");
                $para['date_of_birth'] = default_value($this->input->post("date_of_birth"), "");
                $para['physical_address'] = default_value($this->input->post("physical_address"), "");
                $para['emergency_contact'] = default_value($this->input->post("emergency_contact"), "");
                $para['street'] = default_value($this->input->post("street"), "");
                $para['city'] = default_value($this->input->post("city"), "");
                $para['postal_code'] = default_value($this->input->post("postal_code"), "");
                $para['country'] = default_value($this->input->post("country"), "");
                $para['emergency_contact_name'] = default_value($this->input->post("emergency contact_name"), "");

                $para['parent_id'] = $this->session->userdata('userid'); //therapist
                $para['company_id'] = $this->session->userdata('companyid'); //companyid
                $para['roles_id'] = 3; //patient
                $createPatient = new Patient();

                $patient_id = $createPatient->create($para);
                if ($patient_id != false) {
                    //add entries to user_exercise table if exist
                    if (isset($_POST['exercises']) && count($_POST['exercises']) > 0) {
                        foreach ($_POST['exercises'] as $key => $val) {
                            $addEx = new Users_exercise();
                            $addEx->users_id = $patient_id;
                            $addEx->exercise_id = $val;
                            $addEx->save();
                        }
                    }

                    $folder = new Company_video_folder();
                    $folder->company_id = $this->session->userdata('companyid');
                    $folder->folder_name = $para['firstname'] . ' ' . $para['lastname'];
                    $folder->folder_type = 1;
                    $folder->client_id = $patient_id;
                    $folder->save();

                    $Exercise_folder = new Exercise_folder();
                    $Exercise_folder->company_id = $this->session->userdata('companyid');
                    $Exercise_folder->folder_name = $para['firstname'] . ' ' . $para['lastname'];
                    $Exercise_folder->folder_type = 1;
                    $Exercise_folder->client_id = $patient_id;
                    $Exercise_folder->save();

                    $params['username'] = $para['email'];
                    $params['password'] =  $para['password'];
                    $params['name'] = $this->input->post("firstname");

                    $sendMailStatus = my_email_send($params['username'], "Perfect Forms User Login", "registercustomer", $params, 'support@perfect-forms.net');


                    if (isset($_POST['btnsaveclientuser']) && $_POST['btnsaveclientuser'] != '') {
                        redirect('/admin/exercises/addclientexercise/' . $patient_id);
                    } else {
                        $result['success'] = true;
                        $result['patient_id'] = $patient_id;
                        // redirect('/admin/exercises/addclientexercise/'.$patient_id);  
                        //redirect('admin/patients/index/1/'.$patient_id);  

                        echo json_encode($result);
                        exit;
                        // my_alert_message("success", "New Client Added Successfully");

                        // redirect('admin/patients');
                    }
                } else {

                    if (isset($_POST['btnsaveclientuser']) && $_POST['btnsaveclientuser'] != '') {
                        my_alert_message("danger", "Error while adding new Client");
                        redirect('admin/patients');
                    } else {
                        $result['success'] = false;
                        my_alert_message("danger", "Error while adding new Client");
                        $result['url'] = url('admin/patients');
                        echo json_encode($result);
                        exit;
                    }
                }
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/patients');
        }
    }

    public function updatePatient()
    {        
        if (!empty($_POST)) {

            $this->form_validation->set_rules('patientid', "Patient ID", "required");
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('firstname', "First Name", "required");
            //$this->form_validation->set_rules('phone', "Pgone", "required");
            //$this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "Please provide valid data");
                redirect('admin/patients');
            }

            $patientid = default_value($this->input->post("patientid"));
            $email = default_value($this->input->post("email"));


            $updatePatient = new Patient();
            $updatePatient->get_by_id($patientid);            
            if ($updatePatient->exists()) {                
                $updatePatient->firstname = default_value($this->input->post("firstname"), "");
                $updatePatient->lastname = default_value($this->input->post("lastname"), "");
                $updatePatient->password = default_value($this->input->post("password"), "perfectforms");
                $updatePatient->phone = default_value($this->input->post("phone"), "");

                $updatePatient->date_of_birth = default_value($this->input->post("date_of_birth"), "");
                $updatePatient->physical_address = default_value($this->input->post("physical_address"), "");
                $updatePatient->emergency_contact = default_value($this->input->post("emergency_contact"), "");

                
                $updatePatient->emergency_contact_name = default_value($this->input->post("emergency_contact_name"), "");
                $updatePatient->street = default_value($this->input->post("street"), "");
                $updatePatient->city = default_value($this->input->post("city"), "");    
                $updatePatient->postal_code = default_value($this->input->post("postal_code"), "");
                $updatePatient->country = default_value($this->input->post("country"), "");                

                $updatePatient->company_id = $this->session->userdata('companyid'); //companyid
                $updatePatient->update_at = my_datenow();                
                if ($updatePatient->save()) {
                    $updatefolder = new Company_video_folder();
                    $updatefolder->get_by_client_id($patientid);
                    if ($updatefolder->exists()) {
                        $updatefolder->folder_name = $updatePatient->firstname . ' ' . $updatePatient->lastname;
                        $updatefolder->save();
                    }


                    $UpdateExercise_folder = new Exercise_folder();
                    $UpdateExercise_folder->get_by_client_id($patientid);
                    if ($updatefolder->exists()) {
                        $UpdateExercise_folder->folder_name = $updatePatient->firstname . ' ' . $updatePatient->lastname;
                        $UpdateExercise_folder->save();
                    }
                    //update exercise
                    if (isset($_POST['exercises'])) {
                        $excer = $_POST['exercises'];
                    } else {
                        $excer = array();
                    }

                    $updateExer = new Users_exercise();
                    $updateExer->where('users_id', (int) $patientid);
                    $updateExer->get();
                    $already_in = array();
                    foreach ($updateExer as $uexxer) {
                        $already_in[] = $uexxer->exercise_id;
                        if (!in_array($uexxer->exercise_id, $excer)) {
                            //delete
                            $updateExers = new Users_exercise();
                            $updateExers->where('users_id', (int) $patientid);
                            $updateExers->where('exercise_id', (int) $uexxer->exercise_id);
                            $updateExers->delete();
                        }
                    }
                    //add new 

                    foreach ($excer as $key => $val) {
                        if (!in_array($val, $already_in)) {
                            $updateExer = new Users_exercise();
                            $updateExer->users_id = $patientid;
                            $updateExer->exercise_id = $val;
                            $updateExer->save();

                            $usersdetial = new User();
                            $usersdetial->where('id', (int) $patientid);
                            $usersdetial->get();

                            foreach ($usersdetial as $udetail) {
                                $userdetail = $udetail->show_result();
                                $sendMailStatus = my_email_send($userdetail['email'], "You have new routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                            }
                        }
                    }
                    
                    //Email Update
                    $validateEmail = new Patient();
                    $validateEmail->select('id');
                    $validateEmail->where('email', $email);
                    $validateEmail->where('id !=', $patientid);
                    $validateEmail->get();

                    if (!$validateEmail->exists()) {
                        $updatePatient->email = default_value($this->input->post("email"));
                        $updatePatient->save();
                        my_alert_message("success", "Client details updated successfully");
                        redirect('admin/patients');
                    } else {
                        my_alert_message("warning", "Client details updated except Email. Email is already taken.");
                        redirect('admin/patients');
                    }
                } else {
                    my_alert_message("danger", "Error in updating Client details");
                    redirect('admin/patients');
                }
            } else {
                my_alert_message("danger", "Invalid Client ID");
                redirect('admin/patients');
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/patients');
        }
    }

    public function getTherapistClients()
    {
        $therapist_id = $_POST["therapist_id"];
        //	    select id, firstname, lastname, email, phone,email from users where company_id='3'


        $query = $this->db->query("select A.id, A.email,A.phone, concat(A.firstname,' ', A.lastname) as fullname,A.password from users as A where company_id='3' order by A.firstname");

        $result['therapist_id'] = $therapist_id;
        $result['result'] = $query->result();
        echo json_encode($result);
    }


    public function getPatientDetails($patient_id = "")
    {
        if($patient_id){
            date_default_timezone_set('Asia/Kolkata');
            $todayDate = date('Y-m-d');
            $todayTime = date('H:i:s');                        
            $total_count = "SELECT count(*) as total_count FROM `events` WHERE client_id = $patient_id AND schedule_date < '$todayDate'";
            $total_count = $this->db->query( $total_count)->result();
            $past_appointment_count = $total_count[0]->total_count; 

            $current_date_count = "SELECT count(*) as total_count FROM `events` WHERE client_id = $patient_id AND schedule_date = '$todayDate' AND start_time < ' $todayTime'";
            $current_date_count = $this->db->query($current_date_count)->result();
            $current_appointment_count = $current_date_count[0]->total_count; 
        }
        
        $this->db->query('SET SESSION sql_mode = ""');
        if (!empty($patient_id)) {
            $getPatientDetails = new Patient();
            $getPatientDetails->get_by_id($patient_id);
            $this->load->model('patient');

            $user = $this->patient->get_user_info($patient_id);
            $folderID = $user['id'];
            $companyID = $user['company_id'];


            if ($getPatientDetails->exists()) {
                $data = $getPatientDetails->show_result();
                //get Assigned exercises
                $data['clientexercies'] = array();
                $data['assingedexercies'] = array();
                $data['generalexercies'] = array();

                // $this->db->select('exercise.*,exercisefolder_exercise.insert_at as insertdate');
                // $this->db->from('exercisefolder_exercise');
                // $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                // $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');                
                // $this->db->where('exercisefolder_exercise.company_id', $companyID);
                // $this->db->where('exercisefolder_exercise.exercisefolder_id', $folderID);
                //$this->db->select('exercise.*,exercisefolder_exercise.id as type,exercisefolder_exercise.exercisefolder_id as folderid,exercise_folder.client_id as client_id,users_exercise.insert_at as insertdate');

                $this->db->select('exercise.*,users_exercise.insert_at as insertdate');
                $this->db->from('users_exercise');
                $this->db->join('exercise', 'exercise.id=users_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted', 0);
                $this->db->where('users_exercise.users_id', $patient_id);
                $this->db->group_by('exercise.id');

                if (!empty($_POST['video_name'])) {
                    $data['video_name'] = $_POST['video_name'];
                    $this->db->where("(exercise.name LIKE  '%" . $data['video_name'] . "%') AND 1=", 1);
                }

                //$this->db->where('exercise.isdeleted', 0);
                //$this->db->order_by('exercise.name', 'asc');
                $this->db->order_by('exercise.insert_at', 'DESC');

                $getEXVID = $this->db->get();
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp = array(
                            'assingedexerciesids' => $geVID->id,
                            'id' => $geVID->id,
                            'folderid' => $folderID,
                            'type' => 'client',
                            'title' => $geVID->title,
                            'name' => $geVID->name . "(" . date('m-d-Y', strtotime($geVID->insertdate)) . ")",
                            'insertdate' => date('m-d-Y', strtotime($geVID->insertdate))
                        );

                        $data['assingedexerciesids'][] = $geVID->id;
                        $data['assingedexercies'][] = $temp;
                    }
                }




                //// $data['assingedexercies']=$data['exercies']=$data['assingedexerciesids']=array();
                // $this->db->select('exercise.*,exercisefolder_exercise.id as type,exercisefolder_exercise.exercisefolder_id as folderid,exercise_folder.client_id as client_id,users_exercise.insert_at as insertdate');
                // $this->db->from('users_exercise');
                // $this->db->join('exercise', 'exercise.id=users_exercise.exercise_id', 'left');
                // $this->db->join('exercisefolder_exercise','exercisefolder_exercise.exercise_id=exercise.id', 'left');
                // $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');
                // $this->db->where('exercise.isdeleted',0);
                // $this->db->where('exercise_folder.client_id !=', 0);
                // $this->db->where('users_exercise.users_id', $patient_id);
                // $this->db->group_by('exercise.id');
                // $this->db->order_by('exercise.name', 'ASC');
                // $getEx=$this->db->get();
                // echo $this->db->last_query();exit;
                //  foreach ($getEx->result() as $ges) {
                //         $data['assingedexerciesids'][]=$ges->id;
                //         $temp['name']=$ges->name." (".date('m-d-Y',strtotime($ges->insertdate)).")";
                //         $temp['id']=$ges->id;
                //         $temp['type']=($ges->client_id==''||$ges->client_id==NULL||$ges->client_id==0)?'general':'client';                       
                //         $temp['folderid']=$ges->folderid;
                //         $data['assingedexercies'][] =$temp;
                //     }

                // $this->db->select('exercise.*,exercisefolder_exercise.id as type,exercisefolder_exercise.exercisefolder_id as folderid,exercise_folder.client_id as client_id,users_exercise.insert_at as insertdate');
                // $this->db->from('users_exercise');
                // $this->db->join('exercise', 'exercise.id=users_exercise.exercise_id', 'left');
                // $this->db->join('exercisefolder_exercise','exercisefolder_exercise.exercise_id=exercise.id', 'left');
                // $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');
                // $this->db->where('exercise.isdeleted',0);
                // $this->db->where('users_exercise.users_id', $patient_id);
                // if(!empty($data['assingedexercies'])){$this->db->where_not_in('exercise.id', $data['assingedexerciesids']);}
                // $this->db->group_by('exercise.id');
                // $this->db->order_by('exercise.name', 'ASC');
                // $getEx=$this->db->get();
                // foreach ($getEx->result() as $ges) {
                //     $data['assingedexerciesids'][]=$ges->id;
                //     $temp['name']=$ges->name." (".date('m-d-Y',strtotime($ges->insertdate)).")";
                //     $temp['id']=$ges->id;
                //     $temp['type']=($ges->client_id==''||$ges->client_id==NULL||$ges->client_id==0)?'general':'client';
                //     $temp['folderid']=$ges->folderid;
                //     $data['assingedexercies'][] =$temp;
                // }

                $this->db->select('exercise.*,exercisefolder_exercise.exercisefolder_id as folderid');
                $this->db->from('exercise_folder');
                $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted', 0);
                if (!empty($data['assingedexercies'])) {
                    $this->db->where_not_in('exercise.id', $data['assingedexerciesids']);
                }

                $this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');

                $getEx = $this->db->get();

                foreach ($getEx->result() as $ges) {
                    $data['clientexercieids'][] = $ges->id;
                    $temp['name'] = $ges->name;
                    $temp['id'] = $ges->id;
                    $temp['folderid'] = $ges->folderid;
                    $data['clientexercies'][] = $temp;
                }


                $data['exercies'] = array();
                $this->db->select('exercise.*,exercisefolder_exercise.exercisefolder_id as folderid,exercisefolder_exercise.insert_at as insertdate');
                $this->db->from('exercise_folder');
                $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted', 0);
                if (!empty($data['assingedexercies'])) {
                    $this->db->where_not_in('exercise.id', $data['assingedexerciesids']);
                }
                if (!empty($data['clientexercies'])) {
                    $this->db->where_not_in('exercise.id', $data['clientexercieids']);
                }

                $this->db->where('exercise_folder.client_id', 0);
                //$this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                $getEx = $this->db->get();
                //echo $this->db->last_query();exit;
                foreach ($getEx->result() as $ges) {
                    $temp['name'] = $ges->name;
                    $temp['id'] = $ges->id;
                    $temp['folderid'] = $ges->folderid;
                    $data['generalexercies'][] = $temp;

                    $getExerciseDetails = new Exercise();
                    $getExerciseDetails->get_by_id($ges->id);
                    if ($getExerciseDetails->exists()) {
                        $this->db->select('videos.id,videos.title,exercise_videos.videos_id, exercise_videos.exercise_id');
                        $this->db->from('videos');
                        $this->db->join('exercise_videos', 'exercise_videos.videos_id=videos.id', 'left');
                        $this->db->where('exercise_videos.exercise_id', $ges->id);
                        $this->db->where('videos.isdeleted', 0);
                        $this->db->where('exercise_videos.isdeleted', 0);
                        $this->db->order_by('exercise_videos.order', 'ASC');
                        $getExVid = $this->db->get();

                        if ($getExVid->num_rows() > 0) {
                            $title_array = '';
                            foreach ($getExVid->result() as $key => $geVID) {
                                $title_array .= $geVID->title . ',';
                                $data['exerciesvideos'][$ges->id]['videos'] = $title_array;
                            }
                        }
                    }
                }
                
                $data['appointment_count'] = $past_appointment_count + $current_appointment_count;                
                echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "Client details not available"));
            }
            $getPatientDetails->show_result();
        } else {
            echo json_encode(array('status' => false, 'message' => "Please provide valid data"));
        }
    }

    public function deletePatient($patientid = "")
    {

        if (!empty($patientid)) {
            //delete patient
            $deletePatient = new Patient();
            $deletePatient->get_by_id($patientid);
            if ($deletePatient->exists()) {
                $deletePatient->isdeleted = 1;
                $deletePatient->delete_at = my_datenow();
                if ($deletePatient->delete()) {
                    $deleteexercise = new Users_exercise();
                    $deleteexercise->get_by_users_id($patientid);
                    $deleteexercise->delete_all();

                    $deleteexercise = new Company_video_folder();
                    $deleteexercise->get_by_client_id($patientid);
                    $deleteexercise->delete_all();

                    $deleteexercise = new Exercise_folder();
                    $deleteexercise->get_by_client_id($patientid);
                    $deleteexercise->delete_all();

                    echo json_encode(array('status' => true));
                } else {
                    echo json_encode(array('status' => false));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => "Invalid Client ID"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Required Client ID"));
        }
    }

    public function removeClientRoutine()
    {
        $exerciseId = "2936";
        $deleteExercise = new Exercises();
        $deleteExercise->get_by_id($exerciseId);
        if ($deleteExercise->exists()) {
            $deleteExercise->isdeleted = 1;
            $deleteExercise->delete_at = my_datenow();
            if ($deleteExercise->delete()) {
                echo "success";
            }
        }
    }


    public function deleteassignedExrecise($exer_id = "")
    {
        // echo $exer_id;
        // print_r($_POST);exit;
        if (!empty($exer_id) && !empty($_POST['clientid'])) {


            //delete patient
            $deleteExercise = new Exercise();
            $deleteExercise->get_by_id($exer_id);
            if ($deleteExercise->exists()) {
                $getaExercisefolder_exercise = new Users_exercise();
                $getaExercisefolder_exercise->where('users_id', $_POST['clientid']);
                $getaExercisefolder_exercise->where('exercise_id', $exer_id);
                $getaExercisefolder_exercise->get();
                //print_r($this->db->last_query());    

                if ($getaExercisefolder_exercise->exists()) {
                    $getaExercisefolder_exercise->delete_all();
                    echo json_encode(array('status' => true));
                } else {
                    echo json_encode(array('status' => false));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => "Invalid Routine ID"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Required Routine ID"));
        }
    }

    public function adminOperation()
    {
        print_r($id);
        exit();
        $id = $_POST['user_id'];
        $adminSettings = new Authentication();
        $adminSettings->get_by_id($id);
        if ($adminSettings->exists()) {

            //update fields
            $adminSettings->firstname = $_POST['firstname'];
            $adminSettings->lastname = $_POST['lastname'];

            if ($_POST['password'] != '') {
                $adminSettings->password = $_POST['password'];
            }
            $adminSettings->update_at = my_datenow();
            if ($adminSettings->save()) {
                $logout = '<a href="' . base_url("auth/login/logout") . '">Logout</a>';
                echo json_encode(array('status' => true, 'message' => ' Settings updated successfully.<br>'
                    . '<label class="text-danger">In order to take effect please ' . $logout . ' your current session.</label>'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Sorry, Fail to update admin details.'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Invalid Amin ID'));
        }
    }

    public function getPatientByClientName()
    {
        $search = $_POST['term'];
        if ($search['term']) {
            $search_data = explode(" ", trim($search['term']));
            $firstname = $search_data ? $search_data[0] : ' ';
            $lastname = $search_data ? $search_data[1] : $firstname;

            $sql = "SELECT * FROM users WHERE firstname LIKE '%" . $firstname . "%' AND lastname LIKE '%" . $lastname . "%' OR email LIKE '%" . $firstname . "%'";
            $query_data = $this->db->query($sql)->result();
            // var_dump($data);die;

            if ($query_data) {
                echo json_encode(array('status' => true, 'data' => $query_data));
            } else {
                echo json_encode(array('status' => false, 'message' => "Client not available"));
            }
        }else{
            echo json_encode(array('status' => false, 'message' => "Client not available"));
        }
    }
    
    public function updateClient()
    {        
        if (!empty($_POST)) {

            $this->form_validation->set_rules('patientid', "Patient ID", "required");
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('firstname', "First Name", "required");
            //$this->form_validation->set_rules('phone', "Pgone", "required");
            //$this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "Please provide valid data");
                redirect('admin/patients');
            }

            $patientid = default_value($this->input->post("patientid"));
            $email = default_value($this->input->post("email"));


            $updatePatient = new Patient();
            $updatePatient->get_by_id($patientid);            
            if ($updatePatient->exists()) {                
                $updatePatient->firstname = default_value($this->input->post("firstname"), "");
                $updatePatient->lastname = default_value($this->input->post("lastname"), "");
                $updatePatient->password = default_value($this->input->post("password"), "perfectforms");
                $updatePatient->phone = default_value($this->input->post("phone"), "");

                $updatePatient->date_of_birth = default_value($this->input->post("date_of_birth"), "");
                $updatePatient->physical_address = default_value($this->input->post("physical_address"), "");
                $updatePatient->emergency_contact = default_value($this->input->post("emergency_contact"), "");

                
                $updatePatient->emergency_contact_name = default_value($this->input->post("emergencycontactname"), "");
                $updatePatient->street = default_value($this->input->post("street"), "");
                $updatePatient->city = default_value($this->input->post("city"), "");    
                $updatePatient->postal_code = default_value($this->input->post("postal_code"), "");
                $updatePatient->country = default_value($this->input->post("country"), "");                

                $updatePatient->company_id = $this->session->userdata('companyid'); //companyid
                $updatePatient->update_at = my_datenow();                
                if ($updatePatient->save()) {
                    $updatefolder = new Company_video_folder();
                    $updatefolder->get_by_client_id($patientid);
                    if ($updatefolder->exists()) {
                        $updatefolder->folder_name = $updatePatient->firstname . ' ' . $updatePatient->lastname;
                        $updatefolder->save();
                    }


                    $UpdateExercise_folder = new Exercise_folder();
                    $UpdateExercise_folder->get_by_client_id($patientid);
                    if ($updatefolder->exists()) {
                        $UpdateExercise_folder->folder_name = $updatePatient->firstname . ' ' . $updatePatient->lastname;
                        $UpdateExercise_folder->save();
                    }
                    //update exercise
                    if (isset($_POST['exercises'])) {
                        $excer = $_POST['exercises'];
                    } else {
                        $excer = array();
                    }

                    $updateExer = new Users_exercise();
                    $updateExer->where('users_id', (int) $patientid);
                    $updateExer->get();
                    $already_in = array();
                    foreach ($updateExer as $uexxer) {
                        $already_in[] = $uexxer->exercise_id;
                        if (!in_array($uexxer->exercise_id, $excer)) {
                            //delete
                            $updateExers = new Users_exercise();
                            $updateExers->where('users_id', (int) $patientid);
                            $updateExers->where('exercise_id', (int) $uexxer->exercise_id);
                            $updateExers->delete();
                        }
                    }
                    //add new 

                    foreach ($excer as $key => $val) {
                        if (!in_array($val, $already_in)) {
                            $updateExer = new Users_exercise();
                            $updateExer->users_id = $patientid;
                            $updateExer->exercise_id = $val;
                            $updateExer->save();

                            $usersdetial = new User();
                            $usersdetial->where('id', (int) $patientid);
                            $usersdetial->get();

                            foreach ($usersdetial as $udetail) {
                                $userdetail = $udetail->show_result();
                                $sendMailStatus = my_email_send($userdetail['email'], "You have new routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                            }
                        }
                    }
                    
                    //Email Update
                    $validateEmail = new Patient();
                    $validateEmail->select('id');
                    $validateEmail->where('email', $email);
                    $validateEmail->where('id !=', $patientid);
                    $validateEmail->get();

                    if (!$validateEmail->exists()) {
                        $updatePatient->email = default_value($this->input->post("email"));
                        $updatePatient->save();
                        my_alert_message("success", "Client details updated successfully");
                        // redirect('admin/patients');
                        $result['success'] = true;
                        $result['patient_id'] = $updatePatient->id;
                        echo json_encode($result);
                    } else {
                        my_alert_message("warning", "Client details updated except Email. Email is already taken.");
                        redirect('admin/patients');
                    }
                } else {
                    my_alert_message("danger", "Error in updating Client details");
                    redirect('admin/patients');
                }
            } else {
                my_alert_message("danger", "Invalid Client ID");
                redirect('admin/patients');
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/patients');
        }
    }
    
    public function getScheduleDetails($client_id = ""){        
        $today_date = date('Y-m-d');    
        $client_data = [];     
        $client_data_next_event = "SELECT  `events`.*,
                                `users`.`id`,                                
                                `users`.`firstname`,
                                `users`.`lastname`
                        FROM (`events`)
                        LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
                        WHERE client_id = $client_id  AND `events`.`schedule_date` >= '" . $today_date . "'";
        $client_data['client_data_next_event'] = $this->db->query($client_data_next_event)->result();        
        
        $client_data_past_event = "SELECT  `events`.*,
                                `users`.`id`,                                
                                `users`.`firstname`,
                                `users`.`lastname`
                        FROM (`events`)
                        LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
                        WHERE client_id = $client_id  AND `events`.`schedule_date` < '" . $today_date . "'";
        $client_data['client_data_past_event'] = $this->db->query($client_data_past_event)->result();
        
        $client_name = "SELECT * FROM users WHERE `id` = '" . $client_id .  "'";
        $client_data['client_name'] = $this->db->query($client_name)->result();
        return $this->load->view('admin/panel/appointment_details', ['client_data'=>$client_data]);
    }
    
    public function getNotesDetails($client_id = ""){
        $notes_data = [];
        $notes_details = "SELECT `notes`.`id` as `note_id`,
                        `notes`.`subjective`,
                        `notes`.`objective`,
                        `notes`.`assessment`,
                        `notes`.`plan`,
                        `notes`.`provider_id`,
                        `notes`.`client_id`,
                        `notes`.`created_date`,
                        `users`.`id`,
                        `users`.`firstname`,
                        `users`.`lastname`
                    FROM (`notes`) 
                    LEFT JOIN `users` ON `users`.`id` = `notes`.`provider_id`
                    WHERE client_id = $client_id";
        $notes_data['notes_details'] = $this->db->query($notes_details)->result();

        $client_name = "SELECT * FROM users WHERE `id` = '" . $client_id .  "'";
        $notes_data['client_name'] = $this->db->query($client_name)->result();

        return $this->load->view('admin/panel/notes_details', ['notes_data' => $notes_data]);
    }
    
    public function addNewNotes()
    {    
        // var_dump($_POST);die;
        
        $created_date = date('Y-m-d');
        $sql = "INSERT INTO notes (subjective,objective,assessment,plan,provider_id,client_id,created_date) VALUES (?,?,?,?,?,?,?)";
		$this->db->query($sql, array($_POST['subjective'], $_POST['objective'], $_POST['assessment'], $_POST['plan'], $this->session->userdata('userid'), $_POST['client_id'], $created_date));

        if($this->db->affected_rows() != 1){
            $result['success'] = false;                                
            $result['message'] = "Notes details not added successfully";
            echo json_encode($result);
        }else{
            $result['success'] = true;                                
            $result['message'] = "Notes details added successfully";
            echo json_encode($result);
        }
        
        // if (!empty($_POST)) {
        //     // $createNote = new Notes();
        //     var_dump('adzjvciu');die;
        //     $createNote->subjective  = default_value($this->input->post("subjective"), "");
        //     $createNote->objective   = default_value($this->input->post("objective"), "");
        //     $createNote->assessment  = default_value($this->input->post("assessment"), "");
        //     $createNote->plan        = default_value($this->input->post("plan"), "");
        //     $createNote->provider_id = $this->session->userdata('userid');
        //     $createNote->client_id   = default_value($this->input->post("client_id"), "");
        //     $created_id = $createNote->save();   
        //     var_dump($created_id);die;
        //     if ($created_id) {                
        //         $result['success'] = true;                                
        //         $result['message'] = "Notes details added successfully";
        //         echo json_encode($result);

        //     } else {
        //         $result['success'] = false;                                
        //         $result['message'] = "Notes details not added successfully";
        //         echo json_encode($result);
        //     }
        // } else {
        //     $result['success'] = false;                                
        //     $result['message'] = "Please Provide Valid Data";
        //     echo json_encode($result);
        // }
    }
    
    public function editNotesDetails($note_id = '')
    {
        $notes_details = "SELECT * FROM notes WHERE `id` = '" . $note_id . "' ";
        $notes_details = $this->db->query($notes_details)->result();

        return $this->load->view('admin/panel/edit_notes_details', ['notes_details' => $notes_details]);
    }

    public function updateNotesDetails()
    {
        // var_dump($_POST);die;
        $sql = "UPDATE notes SET subjective = ?, objective = ?, assessment = ?, plan = ? WHERE id = ?";
		$this->db->query($sql, array($_POST['subjective'], $_POST['objective'], $_POST['assessment'], $_POST['plan'],$_POST['note_id']));
        
        if($this->db->affected_rows() != 1){
            $result['success'] = false;                                
            $result['message'] = "Notes details not updated";
            echo json_encode($result);
        }else{
            $result['success'] = true;                                
            $result['message'] = "Notes details updated successfully";
            echo json_encode($result);
        }
    }

    public function deleteNotes($noteid = '')
	{
		$sql = "DELETE FROM notes WHERE id = ?";
		$this->db->query($sql, array($noteid));
		
        if($this->db->affected_rows() != 1){
            $result['success'] = false;                                
            $result['message'] = "Notes not deleted";
            echo json_encode($result);
        }else{
            $result['success'] = true;                                
            $result['message'] = "Notes delete successfully";
            echo json_encode($result);
        }
	}

    public function updateRoutine(){        
        if (!empty($_POST)) {
            $patientid = default_value($this->input->post("patientid"));
            $updatePatient = new Patient();
            $updatePatient->get_by_id($patientid);
            if ($updatePatient->exists()) {
                $updatePatient->company_id = $this->session->userdata('companyid'); //companyid
                $updatePatient->update_at = my_datenow();
                if ($updatePatient->save()) {
                    $updatefolder = new Company_video_folder();
                    $updatefolder->get_by_client_id($patientid);
                    if ($updatefolder->exists()) {
                        $updatefolder->folder_name = $updatePatient->firstname . ' ' . $updatePatient->lastname;
                        $updatefolder->save();
                    }


                    $UpdateExercise_folder = new Exercise_folder();
                    $UpdateExercise_folder->get_by_client_id($patientid);
                    if ($updatefolder->exists()) {
                        $UpdateExercise_folder->folder_name = $updatePatient->firstname . ' ' . $updatePatient->lastname;
                        $UpdateExercise_folder->save();
                    }
                    //update exercise
                    if (isset($_POST['exercises'])) {
                        $excer = $_POST['exercises'];
                    } else {
                        $excer = array();
                    }

                    $updateExer = new Users_exercise();
                    $updateExer->where('users_id', (int) $patientid);
                    $updateExer->get();
                    $already_in = array();
                    foreach ($updateExer as $uexxer) {
                        $already_in[] = $uexxer->exercise_id;
                        if (!in_array($uexxer->exercise_id, $excer)) {
                            //delete
                            $updateExers = new Users_exercise();
                            $updateExers->where('users_id', (int) $patientid);
                            $updateExers->where('exercise_id', (int) $uexxer->exercise_id);
                            $updateExers->delete();
                        }
                    }
                    //add new 

                    foreach ($excer as $key => $val) {
                        if (!in_array($val, $already_in)) {
                            $updateExer = new Users_exercise();
                            $updateExer->users_id = $patientid;
                            $updateExer->exercise_id = $val;
                            $updateExer->save();

                            $usersdetial = new User();
                            $usersdetial->where('id', (int) $patientid);
                            $usersdetial->get();

                            foreach ($usersdetial as $udetail) {
                                $userdetail = $udetail->show_result();
                                $sendMailStatus = my_email_send($userdetail['email'], "You have new routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                            }
                        }
                    }

                    //Email Update
                    $validateEmail = new Patient();
                    $validateEmail->select('id');
                    $validateEmail->where('email', $email);
                    $validateEmail->where('id !=', $patientid);
                    $validateEmail->get();

                    if (!$validateEmail->exists()) {
                        $updatePatient->email = default_value($this->input->post("email"));
                        $updatePatient->save();
                        my_alert_message("success", "Client details updated successfully");
                        redirect('admin/patients');
                    } else {
                        my_alert_message("warning", "Client details updated except Email. Email is already taken.");
                        redirect('admin/patients');
                    }
                } else {
                    my_alert_message("danger", "Error in updating Client details");
                    redirect('admin/patients');
                }
            } else {
                my_alert_message("danger", "Invalid Client ID");
                redirect('admin/patients');
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/patients');
        }
    }
    
    public function loadCreateNoteView()
    {
        return $this->load->view('admin/panel/create_note_view');
    }
}