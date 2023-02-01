<?php

class Therapists extends My_Controller {

    public function __construct() {
        parent::__construct();
         
           if($this->session->userdata('roleid')==2){redirect('/admin/patients');}
            if($this->session->userdata('roleid')==1&&$this->session->userdata('companyid')==0){redirect('/admin/companies');}
        
    }

    public function index() {
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Users';
        $data['active_class'] = 'therapist';
        $therapist_id = $data['global']['userid'];
        if (!empty($_POST)) {
            if (!empty($_POST['fullname']))
                $data['fullname'] = $fullname = $_POST['fullname'];
            if (!empty($_POST['email']))
                $data['email'] = $email = $_POST['email'];
        }
        
            $getCompanytDetails = new Company();
            $getCompanytDetails->get_by_id($this->session->userdata('companyid'));
           
                $datas = $getCompanytDetails->show_result();
                $getUser = new Patient();
                $getUser->where('roles_id', 1);
                $user=new Patient();
                $userdata=$user->get_by_id($datas['company_admin'])->all_to_array(); 
                $data['company']['name']=$datas['company_name'];
                $data['company']['address']=$datas['company_address'];
                $data['company']['logo']= $datas['company_logo'];
                $data['company']['email']=$userdata[0]['email'];
                $data['company']['fname']=$userdata[0]['firstname'];
                $data['company']['lname']=$userdata[0]['lastname'];
                $data['company']['contact']=$userdata[0]['phone'];
                $data['company']['password']=$userdata[0]['password'];
           
       
        //count all therapists here role id= 3
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
        $listPatients->where('roles_id', 2);
        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->where('isdeleted', 0);
        //$listPatients->where('parent_id', $therapist_id);
        $listPatients->get();
        //paginition
        $totalresult = $listPatients->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/therapists/index", $totalresult, $numlinks, $per_page, 4);

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        //count all therapists here role id= 3
        $listPatients = new User();
        $listPatients->where('roles_id', 2);
        $listPatients->where('company_id', $data['global']['companyid']);
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
        //$listPatients->where('parent_id', $therapist_id);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');
        $listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();

        //echo $this->db->last_query();

        foreach ($listPatients as $lip) {
            $data['therapistlist'][] = $lip->show_result();
        }
        
        $this->load->view('admin/panel/therapists', $data);
    }

    public function addNewTherapist() {

        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('firstname', "First Name", "required");
            $this->form_validation->set_rules('phone', "Pgone", "required");
            $this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "Please provide valid data");
                redirect('admin/therapists');
            }

            //validate email address for exsisting
            $para['email'] = default_value($this->input->post("email"), "");
            $validateEmail = new Authentication();
            $validateEmail->get_by_email($para['email']);
            if ($validateEmail->exists()) {
                my_alert_message("danger", "Email ID is already used by other User");
                redirect('admin/therapists');
            } else {
                $para['firstname'] = default_value($this->input->post("firstname"), "");
                $para['lastname'] = default_value($this->input->post("lastname"), "");
                $para['password'] = default_value($this->input->post("password"), "");
                $para['phone'] = default_value($this->input->post("phone"), "");
                $para['parent_id'] = $this->session->userdata('userid'); //adminId of company
                $para['company_id'] = $this->session->userdata('companyid'); //companyid
                $para['roles_id'] = 2; //therapist
                $createPatient = new Patient();
                $patient_id = $createPatient->create($para);
                if ($patient_id != false) {
                    
                     $sendMailStatus = my_email_send($para['email'], "Perfect Forms User Login", "registertherapist", $para, 'support@perfect-forms.net');

                    
                    my_alert_message("success", "New User Added Successfully");
                    redirect('admin/therapists');
                } else {
                    my_alert_message("danger", "Error while adding new User");
                    redirect('admin/therapists');
                }
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/therapists');
        }
    }

    public function updateTherapist() {

        if (!empty($_POST)) {
            $this->form_validation->set_rules('therapistid', "Therapist ID", "required");
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('firstname', "First Name", "required");
            $this->form_validation->set_rules('phone', "Pgone", "required");
            $this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "Please provide valid data");
                redirect('admin/therapists');
            }

            $therapistid = default_value($this->input->post("therapistid"));
            $email = default_value($this->input->post("email"));


            $updatePatient = new Patient();
            $updatePatient->get_by_id($therapistid);
            if ($updatePatient->exists()) {
                $updatePatient->firstname = default_value($this->input->post("firstname"), "");
                $updatePatient->lastname = default_value($this->input->post("lastname"), "");
                $updatePatient->password = default_value($this->input->post("password"), "");
                $updatePatient->phone = default_value($this->input->post("phone"), "");
                $updatePatient->update_at = my_datenow();
                if ($updatePatient->save()) {
                   
                    //Email Update
                    $validateEmail = new Patient();
                    $validateEmail->select('id');
                    $validateEmail->where('email', $email);
                    $validateEmail->where('id !=', $therapistid);
                    $validateEmail->get();

                    if (!$validateEmail->exists()) {
                        $updatePatient->email = default_value($this->input->post("email"));
                        $updatePatient->save();
                        my_alert_message("success", "User details updated successfully");
                        redirect('admin/therapists');
                    } else {
                        my_alert_message("warning", "User details updated except Email. Email is already taken.");
                        redirect('admin/therapists');
                    }
                } else {
                    my_alert_message("danger", "Error in updating User details");
                    redirect('admin/therapists');
                }
            } else {
                my_alert_message("danger", "Invalid User ID");
                redirect('admin/therapists');
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/therapists');
        }
    }

    public function getTherapistDetails($patient_id = "") {
        if (!empty($patient_id)) {
            $getPatientDetails = new Patient();
            $getPatientDetails->get_by_id($patient_id);
            if ($getPatientDetails->exists()) {
                $data = $getPatientDetails->show_result();
                //get Assigned exercises

                $getEx = new Users_exercise();
                $getEx->where('isdeleted', 0);
                $getEx->get_by_users_id($patient_id);
                if ($getEx->exists()) {
                    foreach ($getEx as $ge) {
                        $eid = $ge->exercise_id;
                        $getEDetail = new Exercise();
                        $getEDetail->where('isdeleted', 0);
                        $getEDetail->get_by_id($eid);
                        $data['exercies'][] = $getEDetail->show_result();
                    }
                }
                echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "User details not available"));
            }
            
        } else {
            echo json_encode(array('status' => false, 'message' => "Please provide valid data"));
        }
    }

    public function deleteTherapist($therapistid = "") {

        if (!empty($therapistid)) {
            //delete patient
            $deletePatient = new Patient();
            $deletePatient->get_by_id($therapistid);
            if ($deletePatient->exists()) {
                $deletePatient->isdeleted = 1;
                $deletePatient->delete_at = my_datenow();
                if ($deletePatient->save()) {
                    echo json_encode(array('status' => true));
                } else {
                    echo json_encode(array('status' => false));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => "Invalid User ID"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Required User ID"));
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
    
    public function updateCompany() {
      //  print_r($_POST);exit;

        if (!empty($_POST)) {
            $this->form_validation->set_rules('companyid', "Company ID", "required");
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('companyname', "Company Name", "required");
            $this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "Please provide valid data");
                redirect('admin/companies');
            }

            $patientid = default_value($this->input->post("companyid"));
            $email = default_value($this->input->post("email"));


            $updateCompany = new Company();
            $updateCompany->get_by_id($_POST['companyid']);
            if ($updateCompany->exists()) {
               $updateCompany->company_name = default_value($this->input->post("companyname"), "");
                $updateCompany->company_logo = default_value($this->input->post("companylogo"), "");
                $updateCompany->company_address = default_value($this->input->post("companyaddress"), "");
                $updateCompany->update_at = my_datenow();
                if ($updateCompany->save()) {
                    //update exercise
                    $updateUser = new Patient();
                    $updateUser->where('email', $_POST['email']);
                    $updateUser->where('id !=',$updateCompany->company_admin);
                    $emailexist=$updateUser->count();
                  
                    if($emailexist > 0)
                    {
                       my_alert_message("success", "Email alredy used by another User");
                        redirect('admin/therapists'); 
                    }
                    
                    $updateuser['firstname']=$_POST['fname'];
                    $updateuser['lastname']=$_POST['lname'];
                    $updateuser['phone']=$_POST['phone'];
                    $updateuser['password']=$_POST['password'];
                    $updateuser['update_at']=my_datenow();

                    $updateUser = new Patient();
                    $updateUser->where('roles_id', 1);
                    $updateUser->where('company_id', $_POST['companyid']);
                    $update=$updateUser->update($updateuser);
                    if ($update) {
                        
                        my_alert_message("success", "Company details updated successfully");
                        redirect('admin/therapists');
                    } else {
                        my_alert_message("warning", "Company details updated except Email and Password.");
                        redirect('admin/therapists');
                    }
                  }
                  else {
                    my_alert_message("danger", "Error in updating Company details");
                    redirect('admin/therapists');
                  }
                } else {
                    my_alert_message("danger", "No such Comapny Exist");
                    redirect('admin/therapists');
                }
            } else {
                my_alert_message("danger", "Invalid Data");
                redirect('admin/companies');
            }
        } 
        
        public function Pluploader() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        $targetDir = 'assets/uploads/' . $this->input->post('folder');

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }


        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }
        $jsondata['name'] = $fileName;
        $filePath = $targetDir . '/' . $fileName;

// Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files	
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


// Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

// Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $filePath);
        }

        $jsondata['pathname'] = $filePath;

        echo json_encode($jsondata);
    }

   
}
