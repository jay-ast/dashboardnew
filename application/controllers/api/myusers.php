<?php

require APPPATH . "core/MY_Mobile_Controller.php";

class Users extends MY_Mobile_Controller {

    public function __construct() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
    }

    public function loginmobile() {
        
        $data["body"] = "t222222";
        $data["email"] = var_dump($this->input->post());

        if (!empty($_POST)) {
            //var_dump($_POST);
            $email = $_POST['email'];
            //var_dump($email);
            $password = $_POST['password'];
            $authentication = new Authentication();
   
            if ($authentication->validateEmail($email)) {
                
                $credential = $authentication->validateCredential('email', $email, $password);
                if ($credential != FALSE) {


                    if ($credential['roleid'] == 2 && $credential['companyid'] != 0) {
                        $data['patientlist']=array();
                        $data['user_details'] = $credential;

                        $listPatients = new User();
                        $listPatients->where('roles_id', 3);
                        $listPatients->where('isdeleted', 0);

                        $listPatients->where('company_id', $credential['companyid']);
                        $listPatients->order_by('firstname', 'ASC');
                        $listPatients->order_by('lastname', 'ASC');
                        $listPatients->get();
                        foreach ($listPatients as $lip) {
                            $userdetail=$lip->show_result();
                            unset($userdetail['password']);
                            $data['patientlist'][] = $userdetail;
                        }

                      
                    }else{
                        $this->error("Invalid Email ID or Account Deactivated");
                    }
                    
                    foreach($credential as $k=> $v)
                    {
                        $credential[$k]=($credential[$k]==NULL||$credential[$k]=='')?'':$credential[$k];
                    }
                    $user_id = $credential['userid'];
                    if(isset($_POST['pushtoken']))
                    {
                    $Users_sessions = new Users_sessions();                        
                    $Users_sessions->get_by_user_id($user_id);
                    if ($Users_sessions->exists()) { 
                        $updatedata['pushtoken']=$_POST['pushtoken'];
                        $Users_sessions->update($updatedata);
                        
                    }else{
                        $Users_sessions = new Users_sessions();   
                        $insertdata['user_id']=$user_id;
                        $insertdata['session_id']=  rand(5,50);
                        $insertdata['pushtoken']=  $_POST['pushtoken'];
                        $Users_sessions->create($insertdata);
                     }
                    }
                    $data['user_details'] = $credential;
                    
                    //add user assigned exercises
                    $exercises = array();
                    $getExercisesID = new Users_exercise();
                    $getExercisesID->select('exercise_id');
                    $getExercisesID->where('isdeleted', 0);
                    $getExercisesID->get_by_users_id($user_id);
                    if ($getExercisesID->exists()) {
                        foreach ($getExercisesID as $ge) {
                            $exc_id = $ge->exercise_id;
                            //get ever exercise detail
                            $exersisedetail = new Exercise();
                            $exersisedetail->get_by_id($exc_id);
                            $data['user_details']['exercises'][] = $exersisedetail->show_result();
                        }
                    }
                     $this->success2("Login Successfull", $data);
                } else {
                    $this->error("Invalid Password");
                }
            } else {
                $this->error("Invalid Email ID or Account Deactivated");
            }
        }

    }
    public function login() {
       
        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
           
            if ($this->form_validation->run() == FALSE) {
                $this->error("Please provide required valid parameter");
            } else {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $authentication = new Authentication();
                if ($authentication->validateEmail($email)) {
                    
                    $credential = $authentication->validateCredential('email', $email, $password);
                    if ($credential != FALSE) {


                        if ($credential['roleid'] == 2 && $credential['companyid'] != 0) {
                            $data['patientlist']=array();
                            $data['user_details'] = $credential;

                            $listPatients = new User();
                            $listPatients->where('roles_id', 3);
                            $listPatients->where('isdeleted', 0);

                            $listPatients->where('company_id', $credential['companyid']);
                            $listPatients->order_by('firstname', 'ASC');
                            $listPatients->order_by('lastname', 'ASC');
                            $listPatients->get();
                            foreach ($listPatients as $lip) {
                                $userdetail=$lip->show_result();
                                unset($userdetail['password']);
                                $data['patientlist'][] = $userdetail;
                            }

                            $this->success("Login Successfull", $data);
                            //Login 2
                        }else{
                            $this->error("Invalid Email ID or Account Deactivated");
                        }
                        
                        foreach($credential as $k=> $v)
                        {
                            $credential[$k]=($credential[$k]==NULL||$credential[$k]=='')?'':$credential[$k];
                        }
                        $user_id = $credential['userid'];
                        if(isset($_POST['pushtoken']))
                        {
                        $Users_sessions = new Users_sessions();                        
                        $Users_sessions->get_by_user_id($user_id);
                        if ($Users_sessions->exists()) { 
                            $updatedata['pushtoken']=$_POST['pushtoken'];
                            $Users_sessions->update($updatedata);
                            
                        }else{
                            $Users_sessions = new Users_sessions();   
                            $insertdata['user_id']=$user_id;
                            $insertdata['session_id']=  rand(5,50);
                            $insertdata['pushtoken']=  $_POST['pushtoken'];
                            $Users_sessions->create($insertdata);
                         }
                        }
                        $data['user_details'] = $credential;
                        
                        //add user assigned exercises
                        $exercises = array();
                        $getExercisesID = new Users_exercise();
                        $getExercisesID->select('exercise_id');
                        $getExercisesID->where('isdeleted', 0);
                        $getExercisesID->get_by_users_id($user_id);
                        if ($getExercisesID->exists()) {
                            foreach ($getExercisesID as $ge) {
                                $exc_id = $ge->exercise_id;
                                //get ever exercise detail
                                $exersisedetail = new Exercise();
                                $exersisedetail->get_by_id($exc_id);
                                $data['user_details']['exercises'][] = $exersisedetail->show_result();
                            }
                        }
                        $this->success("Login Successfull", $data);
                        //Login 1 
                    } else {
                        $this->error("Invalid Password");
                    }
                } else {
                    $this->error("Invalid Email ID or Account Deactivated");
                }
            }
        } else {
            $this->error("Not valid request");
        }
    }


    public function getpatient() {
        if (!empty($_POST)) {
            $this->form_validation->set_rules('userid', 'Companyid', 'required|integer');
            if ($this->form_validation->run() == FALSE) {
                $this->error("Please provide required valid parameter");
            } else {
                $data['patientlist']=array();

                $user= new User();
                //$userdetail=$user->get_by_id($_POST['userid']);
                $userdetails=$user->get_by_id($_POST['userid'])->all_to_array();

                if(!empty($userdetails))
                {
                    $listPatients = new User();
                    $listPatients->where('roles_id', 3);
                    $listPatients->where('isdeleted', 0);

                    $listPatients->where('company_id', $userdetails[0]['company_id']);
                    $listPatients->order_by('firstname', 'ASC');
                    $listPatients->order_by('lastname', 'ASC');
                    $listPatients->get();
                    foreach ($listPatients as $lip) {
                        $userdetail=$lip->show_result();
                        unset($userdetail['password']);
                        $data['patientlist'][] = $userdetail;
                    }

                    $this->success("data fetch successfully", $data);

                }


            }
        } else {
            $this->error("Not valid request");
        }
    }

    /**
     * Change request user id email id
     * @param int $user_id app login  user_id
     * @param string $email New Email ID
     * @return json Status
     */
    public function changeEmail() {
        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('userid', 'Email', 'required|integer');
            if ($this->form_validation->run() == FALSE) {
                $this->error("Please provide required valid parameter");
            } else {
                $new_email = $_POST['email'];
                $userid = $_POST['userid'];
                $changeEmail = new Authentication();
                $changeEmail->get_by_id($userid);
                if ($changeEmail->exists()) {
                    $changeEmail->email = $new_email;
                    $changeEmail->update_at = my_datenow();
                    if ($changeEmail->save()) {
                        $this->success("Email updated successfully");
                    } else {
                        $this->error("Error while updating Email");
                    }
                } else {
                    $this->error("Invalid User ID");
                }
            }
        } else {
            $this->error("Not valid request");
        }
    }

    /**
     * Change Login user new password
     * @param string $old_password
     * @param string $new_password
     * @param int $userid
     */
    public function changePassword() {
        if (!empty($_POST)) {

            $this->form_validation->set_rules('userid', 'User ID', 'required|integer');
            $this->form_validation->set_rules('old_password', 'Old Password', 'required|min_length[6]');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            if ($this->form_validation->run() == FALSE) {

                $this->error("Password rules violation");
            } else {

                $userid = $_POST['userid'];
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];

                $changePassword = new Authentication();
                $changePassword->where('password', $old_password);
                $changePassword->get_by_id((int) $userid);
                //echo $this->db->last_query();
                if ($changePassword->exists()) {
                    $changePassword->password = $new_password;
                    $changePassword->update_at = my_datenow();
                    if ($changePassword->save()) {
                        $this->success("Password updated successfully");
                    } else {
                        $this->error("Error while updating Password");
                    }
                } else {
                    $this->error("Invalid Old Password");
                }
            }
        } else {
            $this->error("Not valid request");
        }
    }
    
    public function checktoken()
    {
        $ext_params['exerciseid']=22;
                              
        my_iphone_push_notification(array($_POST['pushtoken']), 'Hello User, You have new video in exrcise');
        echo done;
    }

    public function forgotPassword() {
        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', 'Email ID', 'required|email');
            if ($this->form_validation->run() == FALSE) {
                $this->error("Please provide valid Email");
            } else {
                $email = $_POST['email'];

                $forgotPassword = new Authentication();
                $forgotPassword->get_by_email($email);
                //echo $this->db->last_query();
                if ($forgotPassword->exists()) {
                    $new_password = random_string('alnum', 6);
                    //send email to email id
                    $params['name'] = $forgotPassword->firstname . ' ' . $forgotPassword->lastname;
                    $params['sitename'] = 'Perfect Forms Video App';
                    $params['password'] = $new_password;
                    $email = $forgotPassword->email;
                    $sendMailStatus = my_email_send($email, "Reset Password-- Perfect Forms Video App", "forgotpassword", $params, 'support@perfect-forms.net');

                    if ($sendMailStatus) {
                        $forgotPassword->password = $new_password;
                        $forgotPassword->update_at = my_datenow();
                        if ($forgotPassword->save()) {
                            $this->success("Please check your inbox. We have sent you an email with your temporary password.");
                        } else {
                            $this->error("Error while resting password");
                        }
                    } else {
                        $this->error("Error while sending email of your password");
                    }
                } else {
                    $this->error("Invalid User ID");
                }
            }
        } else {
            $this->error("Not valid request");
        }
    }


    public function addpatient() {



        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('firstname', "First Name", "required");
            $this->form_validation->set_rules('lastname', "First Name", "required");
            //$this->form_validation->set_rules('phone', "Pgone", "required");
            //$this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                $this->error("Please provide valid data");
            }


            //validate email address for exsisting
            $para['email'] = default_value($this->input->post("email"), "");
            $validateEmail = new Authentication();
            $validateEmail->get_by_email($para['email']);
            if ($validateEmail->exists()) {
                $this->error("Email ID is already used by other Client");
            } else {


                $user= new User();
                //$userdetail=$user->get_by_id($_POST['userid']);
                $userdetails=$user->get_by_id($_POST['userid'])->all_to_array();

                //print_r($userdetails);exit;

                $para['firstname'] = default_value($this->input->post("firstname"), "");
                $para['lastname'] = default_value($this->input->post("lastname"), "");
                $para['password'] = default_value($this->input->post("password"), "perfectforms");
                $para['phone'] = default_value($this->input->post("phone"), "");
                $para['parent_id'] = $_POST['userid']; //therapist
                $para['company_id'] = $userdetails[0]['company_id']; //companyid
                $para['roles_id'] = 3; //patient
                $createPatient = new Patient();

                $patient_id = $createPatient->create($para);
                if ($patient_id != false) {

                    //add entries to user_exercise table if exist


                    $folder= new Company_video_folder();
                    $folder->company_id =$userdetails[0]['company_id'];
                    $folder->folder_name = $para['firstname'].' '.$para['lastname'];
                    $folder->folder_type = 1;
                    $folder->client_id = $patient_id;
                    $folder->save();

                    $Exercise_folder= new Exercise_folder();
                    $Exercise_folder->company_id =$userdetails[0]['company_id'];
                    $Exercise_folder->folder_name = $para['firstname'].' '.$para['lastname'];
                    $Exercise_folder->folder_type = 1;
                    $Exercise_folder->client_id = $patient_id;
                    $Exercise_folder->save();

                    $params['username'] =$para['email'];
                    $params['password'] =  $para['password'];
                    $params['name'] =$this->input->post("firstname");

                    $sendMailStatus = my_email_send($params['username'], "Perfect Forms User Login", "registercustomer", $params, 'support@perfect-forms.net');




                        $result['success']=true;
                        $result['patient_id']=$patient_id;
                        $this->success("New Patient Added Successfully", $result);
                        // my_alert_message("success", "New Client Added Successfully");
                } else {

                    $this->error("Error while adding new Client");

                }
            }
        } else {
            $this->error("Please provide valid data");
        }
    }

}
