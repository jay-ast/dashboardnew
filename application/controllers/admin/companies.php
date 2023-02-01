<?php

class Companies extends My_Controller {

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('companyid') != 0) {
            if ($this->session->userdata('roleid') == 2) {
                redirect('/admin/patients');
            }
            if ($this->session->userdata('roleid') == 1) {
                redirect('/admin/therapists');
            }
        }
    }

    public function index() {
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Companies';
        $data['active_class'] = 'companies';

        if (!empty($_POST)) {
            if (!empty($_POST['fullname']))
                $data['fullname'] = $fullname = $_POST['fullname'];
            if (!empty($_POST['email']))
                $data['email'] = $email = $_POST['email'];
        }
        //count all comapnies here    


        $listCompanies = new Company();
        if (!empty($fullname)) {
            $listCompanies->group_start();
            $listCompanies->or_like('company_name', $fullname);
            $listCompanies->group_end();
        }
        if (!empty($email)) {
            $listCompanies->group_start();
            $listCompanies->or_like('company_email', $email);
            $listCompanies->group_end();
        }
        $listCompanies->get();
        $totalresult = $listCompanies->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/companies/index", $totalresult, $numlinks, $per_page, 4);

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        //count all Companies here
        $listCompanies = new Company();
        if (!empty($fullname)) {
            $listCompanies->group_start();
            $listCompanies->or_like('company_name', $fullname);
            $listCompanies->group_end();
        }
        if (!empty($email)) {
            $listCompanies->group_start();
            $listCompanies->or_like('company_email', $email);
            $listCompanies->group_end();
        }
        $listCompanies->order_by('company_name', 'ASC');
        $listCompanies->get();


        //echo $this->db->last_query();

        foreach ($listCompanies as $comp) {
            $temp['companydata'] = $comp->show_result();
            $user = new Patient();
            $userdata = $user->get_by_id($comp->company_admin)->all_to_array();
            $temp['admindata'] = isset($userdata[0])?$userdata[0]:'';
            $user = new Patient();
            $user->where('roles_id', 2);
            $total = $user->where('company_id', $comp->id)->count();

            $temp['totalthr'] = $total;
            $data['complist'][] = $temp;
        }
        $getAllVideos = new Video();
        /*if (!empty($_POST['video_name'])) {
            $getAllVideos->like("title", $_POST['video_name']);
            $data['video_name'] = $_POST['video_name'];
        } */
        $getAllVideos->where("ispublic", 1);
        $getAllVideos->where("isdeleted", 0);
        /*if (empty($_POST['video_name']))
            $getAllVideos->limit($per_page, (($page - 1) * $per_page)); */
        $getAllVideos->get();
        foreach ($getAllVideos as $gtv) {
            $data['public_videos'][] = $gtv->show_result();
        }

        $this->load->view('admin/panel/companies', $data);
    }

    public function addNewCompany() {

        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('companyname', "Company Name", "required");
            $this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "Please provide valid data");
                redirect('admin/companies');
            }

            //validate email address for exsisting
            $para['email'] = default_value($this->input->post("email"), "");
            $validateEmail = new Authentication();
            $validateEmail->get_by_email($para['email']);
            if ($validateEmail->exists()) {
                my_alert_message("danger", "Email ID is already used by other User");
                redirect('admin/companies');
            } else {
                $para['company_name'] = default_value($this->input->post("companyname"), "");
                $para['company_logo'] = default_value($this->input->post("companylogo"), "");
                $para['company_email'] = default_value($this->input->post("email"), "");
                $para['company_address'] = default_value($this->input->post("companyaddress"), "");
                $createcompany = new Company();
                $company_id = $createcompany->create($para);
                if ($company_id <= 0) {
                    my_alert_message("danger", "Error while adding new Company");
                    redirect('admin/companies');
                }
                $para['firstname'] = default_value($this->input->post("fname"), "");
                $para['lastname'] = default_value($this->input->post("lname"), "");
                $para['password'] = default_value($this->input->post("password"), "");
                $para['phone'] = default_value($this->input->post("phone"), "");
                $para['parent_id'] = 0;
                $para['roles_id'] = 1; //admin
                $para['company_id'] = $company_id; //companyid
                $createPatient = new Patient();
                $patient_id = $createPatient->create($para);
                if ($patient_id != false) {
                    //add entries to user_exercise table
                    $update['company_admin'] = $patient_id;
                    $updatecompany = new Company();
                    $updatecompany->where('id', $company_id);
                    $updatecompany->update($update);
                    
                    $params['username'] =$this->input->post("email");
                    $params['password'] =  $this->input->post("password");
                    $params['name'] =$this->input->post("companyname");
                   
                    $sendMailStatus = my_email_send($params['username'], "Perfect Forms Company Administrator Login", "registercompany", $params, 'support@perfect-forms.net');

                    my_alert_message("success", "New Company Added Successfully");
                    
                    redirect('admin/companies');
                } else {
                    my_alert_message("danger", "Error while adding new Company");
                    redirect('admin/companies');
                }
            }
        } else {
            my_alert_message("danger", "Please provide valid data");
            redirect('admin/companies');
        }
    }

    public function updateCompany() {
        // print_r($_POST);exit;

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
                    $updateUser->where('id !=', $updateCompany->company_admin);
                    $emailexist = $updateUser->count();

                    if ($emailexist > 0) {
                        my_alert_message("success", "Email alredy used by another User");
                        redirect('admin/companies');
                    }

                    $updateuser['firstname'] = $_POST['fname'];
                    $updateuser['lastname'] = $_POST['lname'];
                    $updateuser['phone'] = $_POST['phone'];
                    $updateuser['password'] = $_POST['password'];
                    $updateuser['update_at'] = my_datenow();

                    $updateUser = new Patient();
                    $updateUser->where('roles_id', 1);
                    $updateUser->where('company_id', $_POST['companyid']);
                    $update = $updateUser->update($updateuser);
                    if ($update) {

                        my_alert_message("success", "Company details updated successfully");
                        redirect('admin/companies');
                    } else {
                        my_alert_message("warning", "Company details updated except Email and Password.");
                        redirect('admin/companies');
                    }
                } else {
                    my_alert_message("danger", "Error in updating Company details");
                    redirect('admin/companies');
                }
            } else {
                my_alert_message("danger", "No such Comapny Exist");
                redirect('admin/companies');
            }
        } else {
            my_alert_message("danger", "Invalid Data");
            redirect('admin/companies');
        }
    }

    public function getCompanyDetails($company_id = "") {
        if (!empty($company_id)) {
            $getCompanytDetails = new Company();
            $getCompanytDetails->get_by_id($company_id);
            if ($getCompanytDetails->exists()) {
                $datas = $getCompanytDetails->show_result();
                // print_r($data);exit;
                //get Assigned exercises

                $getUser = new Patient();
                $getUser->where('roles_id', 1);
                $user = new Patient();
                $userdata = $user->get_by_id($datas['company_admin'])->all_to_array();
                $data['admindata']['name'] = $datas['company_name'];
                $data['admindata']['address'] = $datas['company_address'];
                $data['admindata']['logo'] = $datas['company_logo'];
                $data['admindata']['email'] = $userdata[0]['email'];
                $data['admindata']['fname'] = $userdata[0]['firstname'];
                $data['admindata']['lname'] = $userdata[0]['lastname'];
                $data['admindata']['contact'] = $userdata[0]['phone'];
                $data['admindata']['password'] = $userdata[0]['password'];

                echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "Client details not available"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Please provide valid data"));
        }
    }

    public function deleteCompany($companyid = "") {

        if (!empty($companyid)) {

            //delete patient
            $deleteCompany = new Company();
            $deleteCompany->get_by_id($companyid);
            $state = ($deleteCompany->isdeleted == 1) ? 0 : 1;
            if ($deleteCompany->exists()) {
                $deleteCompany->isdeleted = $state;
                $deleteCompany->delete_at = my_datenow();
                if ($deleteCompany->save()) {
                    $deleteUser = new Patient();
                    $deleteUser->where('company_id', $companyid);
                    $deleteUser->where_in('roles_id', array(1, 2));
                    $delete['isdeleted'] = $state;
                    $delete['delete_at'] = my_datenow();
                    $deleteUser->update($delete);
                    echo json_encode(array('status' => true, 'state' => $state));
                } else {
                    echo json_encode(array('status' => false));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => "Invalid Company ID"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Required Company ID"));
        }
    }

    public function getAssignedVideos($company_id = "") {
        if (!empty($company_id)) {
            $data['videos'] = array();
            $getvideoDetails = new Company_video();
            $getvideoDetails->get_by_company_id($company_id);
            if ($getvideoDetails->exists()) {
                $data['details'] = $getvideoDetails->show_result();
                //Exercise Videos
                $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $company_id);
                $this->db->where('company_video.folder_id', 0);
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video.isdeleted', 0);
                $this->db->order_by('company_video.id', 'ASC');
                $getEXVID = $this->db->get();
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp = array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,
                            'name' => $geVID->name
                        );
                        $data['videos'][] = $temp;
                    }
                }
                echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "No videos available not available"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Please provide valid data"));
        }
    }

    public function updateassignedvideo() {
        //print_r($_POST);exit;

        if (!empty($_POST)) {
            $this->form_validation->set_rules('id', "Company ID", "required");

            if ($this->form_validation->run() == FALSE) {
                $resp['success'] = false;
                $resp['message'] = 'Parameter is missing';
            } else {
                if (!isset($_POST['assignedvideos'])) {
                    $_POST['assignedvideos'] = array();
                }
                $videosassigned = array();

                $getvideoDetails = new Company_video();
                $getvideoDetails->where('company_id', $_POST['id']);
                $getvideoDetails->where('folder_id', 0);
                
                $allcompaniesvideos = $getvideoDetails->get()->all_to_array();
                foreach ($allcompaniesvideos as $cmpv) {
                    $videosassigned[] = $cmpv['video_id'];
                }
                $deletedvideos = array_diff($videosassigned, $_POST['assignedvideos']);
                // print_r($deletedvideos);exit;
                foreach ($deletedvideos as $vid) {
                    $updatearr['isdeleted'] = 1;
                    $updatearr['delete_at'] = my_datenow();
                    $getvideoDetails = new Company_video();
                    $getvideoDetails->where('company_id', $_POST['id']);
                    $getvideoDetails->where('folder_id', 0);
                    $getvideoDetails->where('video_id', $vid);
                    $videoid = $getvideoDetails->update($updatearr);
                    $EXVID = new Exercise_videos();
                    $EXVID->where('company_id', $_POST['id']);
                    $EXVID->where('videos_id', $vid);
                    $EXVID->get()->delete_all();
                }

                $videoid = 0;
                foreach ($_POST['assignedvideos'] as $vid) {
                    if (!in_array($vid, $videosassigned)) {
                        $videoarray['video_id'] = $vid;
                        $videoarray['company_id'] = $_POST['id'];
                        $videoDetails = new Company_video();
                        $videoid = $videoDetails->create($videoarray);
                    } else {
                        $updatearr['isdeleted'] = 0;
                        $getvideoDetails = new Company_video();
                        $getvideoDetails->where('company_id', $_POST['id']);
                        $getvideoDetails->where('video_id', $vid);
                        $videoid = $getvideoDetails->update($updatearr);
                    }
                }
                if ($videoid > 0) {
                    $resp['success'] = true;
                    $resp['message'] = 'video assigned successfully';
                } else {
                    $resp['success'] = false;
                    $resp['message'] = 'there is some problem please try again';
                }
                //echo json_encode($resp);exit;
            }
            echo json_encode($resp);
            exit;
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
