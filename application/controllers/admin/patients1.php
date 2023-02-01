<?php

class Patients extends My_Controller {

    public function __construct() {
        parent::__construct();
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
    
    
    
    public function index() {
	  
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
            $data['userid']=$this->uri->segment(5);
        } else {
           $data['userid']='';
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
            $userdetail=$lip->show_result(); 
            $userlisted[]=$userdetail['id'];        
            $data['patientlist'][] = $userdetail;
        }
        if($this->uri->segment(5)&&(!in_array($userlisted)))
        {

           $userdetail=new User();
           $userdetail->where('id',  $data['userid']);
           $userdetail->get();           ; 
           $data['patientlist'][]=$userdetail->show_result();

        }


        //get all exercies of therapist
        $exercies = new Exercise();
        $exercies->where('company_id', $data['global']['companyid']);
        $exercies->where('isdeleted', 0);
        $exercies->get();
        $data['generalexercies'] = array();
         
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
                $this->db->where('exercise.isdeleted',0);
                
                $this->db->where('exercise_folder.client_id', 0);
                //$this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                $getEx=$this->db->get();
                //echo $this->db->last_query();exit;
                    foreach ($getEx->result() as $ges) {
                        
                        $temp['name']=$ges->name;
                        $temp['id']=$ges->id;
                        $temp['folderid']=$ges->folderid;
                        $data['generalexercies'][] =$temp;
            }

        $this->load->view('admin/panel/patients', $data);
    }

    public function indexx() {
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

    public function addNewPatient() {
        
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
            $validateEmail->get_by_email($para['email']);
            if ($validateEmail->exists()) {
                my_alert_message("danger", "Email ID is already used by other Client");
                redirect('admin/patients');
            } else {
                $para['firstname'] = default_value($this->input->post("firstname"), "");
                $para['lastname'] = default_value($this->input->post("lastname"), "");
                $para['password'] = default_value($this->input->post("password"), "perfectforms");
                $para['phone'] = default_value($this->input->post("phone"), "");
                $para['parent_id'] = $this->session->userdata('userid'); //therapist
                $para['company_id'] = $this->session->userdata('companyid'); //companyid
                $para['roles_id'] = 3; //patient
                $createPatient = new Patient();
             
                $patient_id = $createPatient->create($para);
                if ($patient_id != false) {
                    //add entries to user_exercise table if exist
                    if (isset($_POST['exercises'])&&count($_POST['exercises']) > 0) {
                        foreach ($_POST['exercises'] as $key => $val) {
                            $addEx = new Users_exercise();
                            $addEx->users_id = $patient_id;
                            $addEx->exercise_id = $val;
                            $addEx->save();
                        }
                    }
                    
                    $folder= new Company_video_folder();
                    $folder->company_id = $this->session->userdata('companyid');
                    $folder->folder_name = $para['firstname'].' '.$para['lastname'];
                    $folder->folder_type = 1;
                    $folder->client_id = $patient_id;
                    $folder->save();

                    $Exercise_folder= new Exercise_folder();
                    $Exercise_folder->company_id = $this->session->userdata('companyid');
                    $Exercise_folder->folder_name = $para['firstname'].' '.$para['lastname'];
                    $Exercise_folder->folder_type = 1;
                    $Exercise_folder->client_id = $patient_id;
                    $Exercise_folder->save();
              
                    $params['username'] =$para['email'];
                    $params['password'] =  $para['password'];
                    $params['name'] =$this->input->post("firstname");
                   
                    $sendMailStatus = my_email_send($params['username'], "Perfect Forms User Login", "registercustomer", $params, 'support@perfect-forms.net');

                   
                    if(isset($_POST['btnsaveclientuser'])&&$_POST['btnsaveclientuser']!='')
                    {
                      redirect('admin/exercises/addclientexercise/'.$patient_id);  
                    }else{
                       $result['success']=true;
                       $result['patient_id']=$patient_id;
                       echo json_encode($result);exit;
                   // my_alert_message("success", "New Client Added Successfully");
                    
                    //redirect('admin/patients');
                    }
                } else {
                    
                    if(isset($_POST['btnsaveclientuser'])&&$_POST['btnsaveclientuser']!='')
                    {
                        my_alert_message("danger", "Error while adding new Client");
                        redirect('admin/patients');
                      
                    }else{
                        $result['success']=false;
                        my_alert_message("danger", "Error while adding new Client");
                        $result['url']=url('admin/patients');
                        echo json_encode($result);exit;
                        
                    }
                    
                }
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/patients');
        }
    }

    public function updatePatient() {
       
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
                $updatePatient->company_id = $this->session->userdata('companyid'); //companyid
                $updatePatient->update_at = my_datenow();
                if ($updatePatient->save()) {
                    $updatefolder = new Company_video_folder();
                    $updatefolder->get_by_client_id($patientid);
                    if($updatefolder->exists())
                    {
                        $updatefolder->folder_name = $updatePatient->firstname.' '.$updatePatient->lastname;
                        $updatefolder->save();
                    }
                   

                    $UpdateExercise_folder= new Exercise_folder();
                    $UpdateExercise_folder->get_by_client_id($patientid);
                    if($updatefolder->exists())
                    {
                        $UpdateExercise_folder->folder_name = $updatePatient->firstname.' '.$updatePatient->lastname;
                        $UpdateExercise_folder->save();
                    }
                    //update exercise
                    if(isset($_POST['exercises'])){
                    $excer = $_POST['exercises'];}else{$excer=array();}

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

                            $usersdetial= new User();
                            $usersdetial->where('id', (int) $patientid);
                            $usersdetial->get();

                            foreach ($usersdetial as $udetail)
                            {
                                $userdetail=$udetail->show_result();
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

    public function getPatientDetails($patient_id = "") {

			$this->db->query('SET SESSION sql_mode = ""');
        if (!empty($patient_id)) {
            $getPatientDetails = new Patient();
            $getPatientDetails->get_by_id($patient_id);
            if ($getPatientDetails->exists()) {
                $data = $getPatientDetails->show_result();
                //get Assigned exercises
              $data['clientexercies']=array(); 
              $data['assingedexercies']=array();
              $data['generalexercies']=array();
               // $data['assingedexercies']=$data['exercies']=$data['assingedexerciesids']=array();
                 $this->db->select('exercise.*,exercisefolder_exercise.id as type,exercisefolder_exercise.exercisefolder_id as folderid,exercise_folder.client_id as client_id,users_exercise.insert_at as insertdate');
                $this->db->from('users_exercise');
                $this->db->join('exercise', 'exercise.id=users_exercise.exercise_id', 'left');
                $this->db->join('exercisefolder_exercise','exercisefolder_exercise.exercise_id=exercise.id', 'left');
                $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');
                $this->db->where('exercise.isdeleted',0);
                $this->db->where('exercise_folder.client_id !=', 0);
                $this->db->where('users_exercise.users_id', $patient_id);
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                $getEx=$this->db->get();
                 foreach ($getEx->result() as $ges) {
                        $data['assingedexerciesids'][]=$ges->id;
                        $temp['name']=$ges->name." (".date('m-d-Y',strtotime($ges->insertdate)).")";
                        $temp['id']=$ges->id;
                        $temp['type']=($ges->client_id==''||$ges->client_id==NULL||$ges->client_id==0)?'general':'client';                       
                        $temp['folderid']=$ges->folderid;
                        $data['assingedexercies'][] =$temp;
                    }

                $this->db->select('exercise.*,exercisefolder_exercise.id as type,exercisefolder_exercise.exercisefolder_id as folderid,exercise_folder.client_id as client_id,users_exercise.insert_at as insertdate');
                $this->db->from('users_exercise');
                $this->db->join('exercise', 'exercise.id=users_exercise.exercise_id', 'left');
                $this->db->join('exercisefolder_exercise','exercisefolder_exercise.exercise_id=exercise.id', 'left');
                $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');
                $this->db->where('exercise.isdeleted',0);
                $this->db->where('users_exercise.users_id', $patient_id);
                if(!empty($data['assingedexercies'])){$this->db->where_not_in('exercise.id', $data['assingedexerciesids']);}
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                $getEx=$this->db->get();
                foreach ($getEx->result() as $ges) {
                    $data['assingedexerciesids'][]=$ges->id;
                    $temp['name']=$ges->name." (".date('m-d-Y',strtotime($ges->insertdate)).")";
                    $temp['id']=$ges->id;
                    $temp['type']=($ges->client_id==''||$ges->client_id==NULL||$ges->client_id==0)?'general':'client';
                    $temp['folderid']=$ges->folderid;
                    $data['assingedexercies'][] =$temp;
                }

                $this->db->select('exercise.*,exercisefolder_exercise.exercisefolder_id as folderid');
                $this->db->from('exercise_folder');
                $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted', 0);
                if(!empty($data['assingedexercies'])){$this->db->where_not_in('exercise.id', $data['assingedexerciesids']);}
                
                $this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                
                $getEx=$this->db->get();
                //echo $this->db->last_query();exit;
                    foreach ($getEx->result() as $ges) {
                        $data['clientexercieids'][]=$ges->id;
                        $temp['name']=$ges->name;
                        $temp['id']=$ges->id;
                        $temp['folderid']=$ges->folderid;
                        $data['clientexercies'][] =$temp;
                    }
                    

                $data['exercies']=array();
                $this->db->select('exercise.*,exercisefolder_exercise.exercisefolder_id as folderid,exercisefolder_exercise.insert_at as insertdate');
                $this->db->from('exercise_folder');
                $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted',0);
                if(!empty($data['assingedexercies'])){$this->db->where_not_in('exercise.id', $data['assingedexerciesids']);}
                if(!empty($data['clientexercies'])){$this->db->where_not_in('exercise.id', $data['clientexercieids']);}
                
                $this->db->where('exercise_folder.client_id', 0);
                //$this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $this->session->userdata('companyid'));
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                $getEx=$this->db->get();
                //echo $this->db->last_query();exit;
                    foreach ($getEx->result() as $ges) {
                        
                        $temp['name']=$ges->name;
                        $temp['id']=$ges->id;
                        $temp['folderid']=$ges->folderid;
                        $data['generalexercies'][] =$temp;
                    }
               
                  
                    
                    
                    
             // echo "<pre>";
              //print_r($data);
                echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "Client details not available"));
            }
            $getPatientDetails->show_result();
        } else {
            echo json_encode(array('status' => false, 'message' => "Please provide valid data"));
        }
    }

    public function deletePatient($patientid = "") {

        if (!empty($patientid)) {
            //delete patient
            $deletePatient = new Patient();
            $deletePatient->get_by_id($patientid);
            if ($deletePatient->exists()) {
                $deletePatient->isdeleted = 1;
                $deletePatient->delete_at = my_datenow();
                if ($deletePatient->delete()) {                    
                  $deleteexercise= new Users_exercise();
                  $deleteexercise->get_by_users_id($patientid);
                  $deleteexercise->delete_all();
                  
                  $deleteexercise= new Company_video_folder();
                  $deleteexercise->get_by_client_id($patientid);
                  $deleteexercise->delete_all();
                  
                  $deleteexercise= new Exercise_folder();
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
    
    
    public function deleteassignedExrecise($exer_id = "")
    {
        
        //print_r($_POST);exit;
        if (!empty($exer_id)&&!empty($_POST['clientid'])) {
            
               
            //delete patient
            $deleteExercise = new Exercise();
            $deleteExercise->get_by_id($exer_id);
            if ($deleteExercise->exists()) {
               $getaExercisefolder_exercise = new Users_exercise();       
               $getaExercisefolder_exercise->where('users_id', $_POST['clientid']);
               $getaExercisefolder_exercise->where('exercise_id',$exer_id);
               $getaExercisefolder_exercise->get();
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

    public function adminOperation() {

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

}
