<?php

require APPPATH . "core/MY_Mobile_Controller.php";
use CodeIgniter\HTTP\IncomingRequest;
class Users extends MY_Mobile_Controller {

    public function __construct() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
    }
    

    public function saveVideosToRoutine() {
	    
		$videos = $_POST["videos"];
		$exercise_id = $_POST["exercise_id"];
		$companyid = $_POST["companyid"];
		$arrVideos = explode(",", $videos);
		
		$deleteExercise = new Exercise_videos();
		$deleteExercise->where('exercise_id', $exercise_id);
		$deleteExercise->get();
		foreach($deleteExercise as $delExe){
			$delExe->delete();	
		}
  		
  		
		$i = 0;
		foreach($arrVideos as $video){
			$addExercise = new Exercise_videos();
			$addExercise->exercise_id = $exercise_id;
			$addExercise->videos_id = $video;
			$addExercise->order = $i;
			$addExercise->company_id = $companyid;
			$addExercise->save();
			$i++;
		}
				
		$data["exe"] =  $addExercise->id;
		echo json_encode($data);
	}
    
    public function removeClientRoutine() {
	    
		$exer_id = $_POST["routineId"];
		$folder_id = $_POST["folder_id"];
		
		//Exercise Folder
		$deleteExercise = new Exercisefolder_exercise();
		$deleteExercise->where('exercise_id', $exer_id);
		$deleteExercise->where('exercisefolder_id', $folder_id);
		$deleteExercise->get();
  		$deleteExercise->delete();
  		
  		//Exercise
  		$deleteExercise2 = new Exercise();
		$deleteExercise2->where('id', $exer_id);
		$deleteExercise2->get();
  		$deleteExercise2->delete();
  		
  		$deleteExercise3 = new Exercise_videos();
		$deleteExercise3->where('exercise_id', $exer_id);
		$deleteExercise3->get();
  		$deleteExercise3->delete();
  		
  		$deleteExercise3 = new Users_exercise();
		$deleteExercise3->where('exercise_id', $exer_id);
		$deleteExercise3->get();
  		$deleteExercise3->delete();


		$data["routine"] =  $_POST["routineId"];
		$data["exe"] =  $deleteExercise->id;
		$data["folder_id"] =  $folder_id;
		echo json_encode($data);
	}
	
	public function cloneClientRoutine() {
	    
		$exerciseId = $_POST["id"];
		$patientId = $_POST["patientId"];
		$folderId = $_POST["folderId"];
		$companyId = $_POST["companyId"];
		
		$getRoutineData = new Exercise();
		$getRoutineData->where('id', $exerciseId);
		$getRoutineData->get();
		
		$newData = new Exercise();
		$newData->therapist_id = $getRoutineData->therapist_id;
		$newData->company_id = $getRoutineData->company_id;
		$newData->name = $getRoutineData->name." COPY";
		$newData->description = $getRoutineData->description;
		$newData->save();
		
		$userExer = new Users_exercise();
		$userExer->users_id = $patientId;
		$userExer->exercise_id = $newData->id;
		$userExer->save();
		
		$videosExer = new Exercise_videos();
		$videosExer->where_in('exercise_id', (int) $exerciseId);
		$videosExer->get();
		$arrVideo = [];
		foreach($videosExer as $video){
			$newvideo = new Exercise_videos();
			$newvideo->videos_id = $video->videos_id;
			$newvideo->exercise_id = $newData->id;
			$newvideo->company_id = $video->company_id;
			$newvideo->order = $video->order;
			$newvideo->save();
			array_push($arrVideo, $newvideo->id);
		}
		
		//General and Client
		$Exercisefolder_exercise = new Exercisefolder_exercise();
		$Exercisefolder_exercise->where('exercise_id', (int) $exerciseId);
		$Exercisefolder_exercise->get();
		$arrVideo2 = [];
		foreach($Exercisefolder_exercise as $video){
			$newExercisefolder_exercise = new Exercisefolder_exercise();
			$newExercisefolder_exercise->exercise_id = $newData->id;
			$newExercisefolder_exercise->exercisefolder_id = $folderId;
			$newExercisefolder_exercise->company_id = $companyId;
			$newExercisefolder_exercise->save();
			array_push($arrVideo2, $newExercisefolder_exercise->id);
		}
		

		$data["arrvideo"] = $arrVideo;
		$data["Exercisefolder_exercise"] = $arrVideo2;
		$data["success"] =  true;
		$data["newdata_exerid"] = $newData->id;

		echo json_encode($data);
	}
	
	public function newClientRoutine() {
	    

		$patientId = $_POST["patientId"];
		$folderId = $_POST["folderId"];
		$companyId = $_POST["companyId"];
		$therapistId = $_POST["therapistId"];
		
		$newData = new Exercise();
		$newData->therapist_id = $therapistId;
		$newData->company_id = $companyId;
		$newData->name = 'Type Routine Name';
		$newData->description = "";
		$newData->company_id = $companyId;
		$newData->save();
		$newExerciseId = $newData->id;
		
		$userExer = new Users_exercise();
		$userExer->users_id = $patientId;
		$userExer->exercise_id = $newExerciseId;
		$userExer->save();
		
		$userExer = new Exercisefolder_exercise();
		$userExer->exercisefolder_id = $folderId;
		$userExer->exercise_id = $newExerciseId;
		$userExer->company_id = $companyId;
		
		$userExer->save();
		

		$data["success"] =  true;
		$data["newdata_exerid"] = $newExerciseId;

		echo json_encode($data);
	}
	
	public function newGeneralRoutine() {
	    


		
		$exerciseFolderId = $_POST["folderId"]; //952		
		$companyId = $_POST["companyId"]; // 3
		$therapistId = $_POST["therapistId"]; //878
		

		$newData = new Exercise();
		$newData->therapist_id = $therapistId;
		$newData->company_id = $companyId;
		$newData->name = 'Type Routine Name';
		$newData->description = "";
		$newData->company_id = $companyId;
		$newData->save();
		$newExerciseId = $newData->id;
		
		
		$userExer = new Exercisefolder_exercise();
		$userExer->exercisefolder_id = $exerciseFolderId;
		$userExer->exercise_id = $newExerciseId;
		$userExer->company_id = $companyId;
		
		$userExer->save();
		

		$data["success"] =  true;
		$data["newdata_exerid"] = $newExerciseId;


		echo json_encode($data);
	}
	
	public function deleteExrecisebyFolder(){
		 //print_r($_POST);exit;
		 $companyId = $_POST['companyId'];
		 $folderId = $_POST['folderId'];
		 $exer_id = $_POST['exerciseId'];
		 
        if (!empty($exer_id)&&!empty($folderId)) {
            
            //delete patient
            $deleteExercise = new Exercise();
            $deleteExercise->get_by_id($exer_id);
            if ($deleteExercise->exists()) {
               $getExercisefolder_exercise = new Exercisefolder_exercise();        
               $getExercisefolder_exercise->where('exercisefolder_id', $folderId);
               $getExercisefolder_exercise->where('company_id', $companyId);
               $getExercisefolder_exercise->where('exercise_id',$exer_id);
               $getExercisefolder_exercise->get();
               if ($getExercisefolder_exercise->exists()) {
                        $getExercisefolder_exercise->delete_all();
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
        $data["success"] =  true;
		
		echo json_encode($data);
   	}
	
	
	public function loadCounter() {
	    

		$patientId = $_POST["clientId"];
		$companyId = $_POST["companyId"];
		
		
		$generalRoutines = new Exercise_folder();    
	    $generalRoutines->where('folder_type', 0);
	    $generalRoutines->where('company_id', $companyId);
		$generalRoutines->get();
		if($patientId == ""){
			$listPatients = new Patient();
	        $listPatients->where('roles_id', 3);
	        $listPatients->where('company_id', $companyId);
	        $listPatients->where('isdeleted', 0);
	        $listPatients->get();
			$getEXVID =  $listPatients->result_count();
			$data["showclient"] = "BBBBBB";
        }
        else{
	        $this->db->select('videos.*');
	        $this->db->from('videos');
	        $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
	        $this->db->where('company_video.company_id', $companyId);
	        $this->db->where('company_video.folder_id', $patientId);
	       
	        $this->db->where('videos.isdeleted', 0);
	        $this->db->where('company_video.isdeleted', 0);
	        $getEXVID = $this->db->get()->num_rows();
	        $data["showclient"] = "AAAAAA";
        }
        
        
               

		$count = $generalRoutines->result_count();
			//$generalRoutines->num_rows();
		$data["client"] =  $getEXVID;
		$data["general"] = $count;

		echo json_encode($data);
	}
	
	public function loadVideoCounter() {
	    

		$therapistId = $_POST["therapistId"];
		$companyId = $_POST["companyId"];
		
		
		$this->db->select('count(*) as generalcount');
		$this->db->from('company_video_folder as A');
		$this->db->join('company_video as B', 'A.id=B.folder_id', 'left');
		$this->db->where('A.folder_type',0);
		$this->db->where('A.company_id', $companyId);
    		    
                   
		$data['generalcount'] = $this->db->get()->result()[0]->generalcount;
		
		
		$this->db->select('count(*) as clientcount');
		$this->db->from('videos as A');
		$this->db->join('company_video as B', 'B.video_id=A.id', 'left');
		$this->db->where('A.therapist_id',$therapistId);
		$this->db->where('B.company_id', $companyId);
		$data['clientcount'] = $this->db->get()->result()[0]->clientcount;


		echo json_encode($data);
	}
	 
	
	
	public function removeRoutineVideo() {
	    
		$videos_id = $_POST["videos_id"];
		$exercise_id = $_POST["exercise_id"];
		
		$deleteExercise = new Exercise_videos();
		$deleteExercise->where('exercise_id', $exercise_id);
		$deleteExercise->where('videos_id', $videos_id);
		$deleteExercise->get();

    //    $deleteExercise->isdeleted = 1;
  //      $deleteExercise->delete_at = my_datenow();
  		$deleteExercise->delete();
		$data["videos_id"] =  $_POST["videos_id"];
		$data["exercise_id"] =  $_POST["exercise_id"];
		
		$data["exe"] =  $deleteExercise->id;
		echo json_encode($data);
	}
	
    public function deleteassignedExrecise($exer_id = "")
    {
        $exer_id = $_POST['exec_id'];
        //print_r($_POST);exit;
        if (!empty($exer_id) && !empty($_POST['clientid'])) {
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
    
    public function updatePatient() {
       
        if (!empty($_POST)) {
            
            $this->form_validation->set_rules('patientid', "Patient ID", "required");
            $this->form_validation->set_rules('email', "Email", "required|email");
            $this->form_validation->set_rules('firstname', "First Name", "required");
            //$this->form_validation->set_rules('phone', "Pgone", "required");
            //$this->form_validation->set_rules('password', "Password", "required");
            if ($this->form_validation->run() == FALSE) {
	            $result['success'] = false;
	            $result['message'] = 'Please provide valid data';
	            echo json_encode($result);
	            exit;
            }
			$patient_id = $_POST["patientid"];
			$email = $_POST["email"];
			$firstname = $_POST["firstname"];
			$lastname = $_POST["lastname"];
			$phone = $_POST["phone"];
			$companyid = $_POST["companyid"];
			
            $patientid = $patient_id;
            $email = $email;
  

            $updatePatient = new Patient();
            $updatePatient->get_by_id($patientid);
            if ($updatePatient->exists()) {
                $updatePatient->firstname = default_value($firstname, "");
                $updatePatient->lastname = default_value($lastname, "");
                // $updatePatient->password = default_value($this->input->post("password"), "perfectforms");
                $updatePatient->phone = default_value($phone, "");
                $updatePatient->company_id = $this->input->post('companyid'); //companyid
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
                        $UpdateExercise_folder->company_id = $this->input->post('companyid');                        
                        //Figure out this what will be the value
                        $UpdateExercise_folder->folder_type = 1;
                        $UpdateExercise_folder->save();
                    }
                    //update exercise
                    if(isset($_POST['exercises'])){
                    $excer = $_POST['exercises'];}else{$excer=array();}

                    $updateExer = new Users_exercise();
                    $updateExer->where_in('users_id', (int) $patientid);
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
						$result['success'] = true;
						$result['message'] = 'Client details updated successfully';
                    } else {
	                    $result['success'] = false;
						$result['message'] = 'Client details updated except Email. Email is already taken.';
                    }
                } else {
	                $result['success'] = false;
					$result['message'] = 'Error in updating Client details';
                }
            } else {
                $result['success'] = false;
				$result['message'] = 'Invalid Client ID';
            }
        } else {
			$result['success'] = false;
			$result['message'] = 'Please provide valid data';
        }
        
		echo json_encode($result);
        
    }
    
    public function addNewPatient() {
        
        if (!empty($_POST)) {
            $email = $_POST["email"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $password = $_POST["password"];
            $phone = $_POST["phone"];
            $userid = $_POST["userid"];
            $companyid = $_POST["companyid"];
            
            
            //validate email address for exsisting
            $para['email'] = default_value($email, "");
            $validateEmail = new Authentication();
            $validateEmail->get_by_email($para['email']);
            if ($validateEmail->exists()) {
	            $result["success"] = false;
                $result["message"] = "Email ID is already used by other Client";
                echo json_encode($result);
                exit;
            } else {
                $para['firstname'] = default_value($firstname, "");
                $para['lastname'] = default_value($lastname, "");
                $para['password'] = default_value($password, "perfectforms");
                $para['phone'] = default_value($phone, "");
                $para['parent_id'] = $userid; //therapist
                $para['company_id'] = $companyid; //companyid
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
                    $Exercise_folder->company_id = $companyid;
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

                    }
                } else {                    
                    $result['success']=false;
                    $result["message"] = "Error while adding new Client";
                }
            }
        } else {
			$result['success'] = false;
			$result["message"] = "Please provide valid data";
				
        }
                  echo json_encode($result);
    }
    
    
    public function deletePatient() {
		$patientid = $_POST['patientid'];
		
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
    
    public function general_exercises() {
	    //get all exercies of therapist
        
		$data['generalexercies'] = array(); 
		$this->db->select('exercise.*');
		$this->db->from('exercise_folder');
		$this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
		$this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
		$this->db->where('exercise.isdeleted',0);
		$this->db->where('exercise_folder.client_id', 0);
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
        echo json_encode($data);
    }
    
    public function createFolderToUser() {
	    
//This function create exercise folder to user
/*
	   $sql =  'select A.* from users as A
		left outer join exercise_folder as B on A.id=B.client_id
		where A.id NOT IN (select concat_ws(",",client_id) from exercise_folder)
		and A.company_id="3"
		and A.isdeleted = 0
		and A.roles_id=3
		order by A.firstname';

		
		$result = $this->db->query($sql);
		$arrData = $result->result_array();
		foreach($arrData as $data){
			echo $data['firstname'];
			echo "<br/>";
			$Exercise_folder= new Exercise_folder();

            $Exercise_folder->company_id =$data['company_id'];
            $Exercise_folder->folder_name = $data['firstname'].' '.$data['lastname'];
            $Exercise_folder->folder_type = 1;
            $Exercise_folder->client_id = $data["id"];
            $Exercise_folder->save();

		}
		//var_dump($arrData);
		echo "Done";
*/
		
    }
    
    
    public function patients() {

		
        $therapist_id = $_POST["userid"];
        $companyid = $_POST["companyid"];
        $pagenumber = $_POST["pagenumber"];
        $stepmax = $_POST["stepmax"];
        $stepmin = $_POST["stepmin"];

		
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
        $listPatients->where('company_id', $companyid);
        $listPatients->where('isdeleted', 0);

        $listPatients->get();
        //paginition
        $totalresult = $listPatients->result_count();
        $numlinks = 3;
        $per_page = 150;
		
		$data["numlinks"] = $numlinks;
		$data["per_page"] = $per_page;
		$page = $pagenumber;
		$data['userid'] = $therapist_id;
		$data['pagenumber'] = $pagenumber;
		
        //count all patients here role id= 3
        $listPatients = new User();
        $listPatients->where('roles_id', 3);
        $listPatients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listPatients->group_start();
			$listPatients->or_like('firstname',$fullname, both);
            $listPatients->or_like('lastname', $fullname, both);
			$listPatients->or_like('email', $fullname);
            $listPatients->group_end();
        }
        // $listPatients->where('company_id', $companyid);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');
/*
        $listNumber = $listPatients->countRow();
		$numrows =  $listNumber;
*/

        $listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();
        //echo $this->db->last_query();
		//$totalresult = 0;
		$data['patientlist'] = [];
		$j = 0;
	
        foreach ($listPatients as $index=>$lip) {
           
            $userdetail=$lip->show_result(); 
            $data['generalexercies'] = array(); 
			$this->db->select('id');
			$this->db->from('exercise_folder');
			$this->db->where('client_id',$userdetail["id"]);
			$getExFolder=$this->db->get()->result();
			$userdetail['folderId'] = $getExFolder[0]->id;
            $userlisted[]=$userdetail['id'];   
            unset($userdetail['password']);     
           // if($index > $stepmin && $index <= $stepmax){
	           	$userdetail['fullname'] = $userdetail['firstname'].' '.$userdetail['lastname'];
	          	$data['patientlist'][] = $userdetail;
	          	$j++;
	            //$totalresult++;
            //}
        }
        $data["totalresult"] = $totalresult;
        $data['counter'] = $j;
        // $data['numrows'] = $numrows;
        
        // $data["totalresult"] = $totalresult;
        echo json_encode($data);
    }
    
    public function listClient() {

		
        $therapist_id = $_POST["userid"];
        $companyid = $_POST["companyid"];
        $pagenumber = $_POST["pagenumber"];
        $stepmax = $_POST["stepmax"];
        $stepmin = $_POST["stepmin"];

		
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
        $listPatients->where('company_id', $companyid);
        $listPatients->where('isdeleted', 0);

        $listPatients->get();
        //paginition
        $totalresult = $listPatients->result_count();
        $numlinks = 3;
        $per_page = 1000;
		
		$data["numlinks"] = $numlinks;
		$data["per_page"] = $per_page;
		$page = $pagenumber;
		$data['userid'] = $therapist_id;
		$data['pagenumber'] = $pagenumber;
		
        //count all patients here role id= 3
        $listPatients = new User();
        $listPatients->where('roles_id', 3);
        $listPatients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listPatients->group_start();
			$listPatients->or_like('firstname',$fullname, both);
            $listPatients->or_like('lastname', $fullname, both);
			$listPatients->or_like('email', $fullname);
            $listPatients->group_end();
        }
        // $listPatients->where('company_id', $companyid);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');
/*
        $listNumber = $listPatients->countRow();
		$numrows =  $listNumber;
*/

        $listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();
        //echo $this->db->last_query();
		//$totalresult = 0;
		$data['patientlist'] = [];
		
        foreach ($listPatients as $index=>$lip) {           
            $userdetail=$lip->show_result(); 
			$this->db->select('id');
			$this->db->from('exercise_folder');
			$this->db->where('client_id',$userdetail["id"]);
			$getExFolder=$this->db->get()->result();
			$userdetail['folderId'] = $getExFolder[0]->id;
            $userlisted[]=$userdetail['id'];   
           	$mydetail['fullname'] = $userdetail['firstname'].' '.$userdetail['lastname'];
           	$mydetail['id'] = $userdetail['id'];
          	$data['patientlist'][] = $mydetail;
        }
        $data["totalresult"] = $totalresult;
        // $data['numrows'] = $numrows;
        
        // $data["totalresult"] = $totalresult;
        echo json_encode($data);
    }
    
    public function getClientDetails() {
	    $patient_id = $_POST["patientId"];
	    
		 	$this->db->select('*');
			$this->db->from('exercise_folder');
            $this->db->where('id',$patient_id );
            $clientDetail = $this->db->get()->result();
            
           echo json_encode($clientDetail);
		
    }
    
    
    public function getClientRoutines() {
	    $companyId = $_POST["companyId"];
	    $folderId = $_POST["patientId"];
	    
	    $this->db->select('exercise.*,exercisefolder_exercise.insert_at as insertdate');
			$this->db->from('exercisefolder_exercise');
			$this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
			$this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');                
			$this->db->where('exercisefolder_exercise.company_id', $companyId);
			$this->db->where('exercisefolder_exercise.exercisefolder_id', $folderId);
            $this->db->where('exercise.isdeleted', 0);
            $this->db->order_by('exercise.name', 'asc');
               
            $getEXVID = $this->db->get();
          //echo $this->db->last_query();exit;
            if ($getEXVID->num_rows() > 0) {
                foreach ($getEXVID->result() as $geVID) {
                     $foldervideos = new Exercise_videos();
                     $foldervideos->where('exercise_id', $geVID->id);
                     $fvideocount=$foldervideos->count();
                    $temp = array(
                        'id' => $geVID->id,
                        'title' => $geVID->title,                           
                        'name' => $geVID->name,
                        'numberofvideo'=>$fvideocount,
                        'insertdate'=>date('m-d-Y',strtotime($geVID->insertdate))
                    );
                    $data['exercise_name'][] = $temp;
                }
            }
            echo json_encode($data);
            exit;
    }
    
    public function getUserDetails() {
		$patientId = $_POST['patientId'];
		$companyId = $_POST['companyId'];
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id',$patientId);
		$this->db->where('company_id',$companyId);
		$users =  $this->db->get();
	
		foreach ($users->result() as $user) {
			$data['user'] = $user;
		}

		echo json_encode($data);
		exit;
    }
    
    
    public function getPatientDetails() {
		$patient_id = $_POST['patient_id'];
		$companyid = $_POST['companyid'];
		$this->db->query('SET SESSION sql_mode = ""');
		
        if (!empty($patient_id)) {
            $getPatientDetails = new Exercise_folder();
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
                        $data['assingedexerciesids_2'][]=$ges->id;
                        $temp['label']= $ges->name." (".date('m-d-Y',strtotime($ges->insertdate)).")";
                        $temp['name']= $ges->name;
                        $temp['mydate']= date('m-d-Y',strtotime($ges->insertdate));
                        
                        $temp['id']=$ges->id;
                        $temp['type']=($ges->client_id==''||$ges->client_id==NULL||$ges->client_id==0)?'general':'client';                       
                        $temp['folderid']=$ges->folderid;
                        $data['assingedexercies'][] =$temp;
                        $data['assingedIds'][] =$ges->id;
                }

                $this->db->select('exercise.*,exercisefolder_exercise.id as type,exercisefolder_exercise.exercisefolder_id as folderid,exercise_folder.client_id as client_id,users_exercise.insert_at as insertdate');
                $this->db->from('users_exercise');
                $this->db->join('exercise', 'exercise.id=users_exercise.exercise_id', 'left');
                $this->db->join('exercisefolder_exercise','exercisefolder_exercise.exercise_id=exercise.id', 'left');
                $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');
                $this->db->where('exercise.isdeleted',0);
                $this->db->where('users_exercise.users_id', $patient_id);
                $this->db->where_not_in('exercise.id', $data['assingedexerciesids']);
//                 if(!empty($data['assingedexercies'])){$this->db->where_not_in('exercise.id', $data['assingedexerciesids']);}
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                $getEx=$this->db->get();
                foreach ($getEx->result() as $ges) {
	                
                    
                    $temp['label']=$ges->name." (".date('m-d-Y',strtotime($ges->insertdate)).")";
                    $temp['name']= $ges->name;
                        $temp['mydate']= date('m-d-Y',strtotime($ges->insertdate));
                        
                    $temp['id']=$ges->id;
                    $temp['type']=($ges->client_id==''||$ges->client_id==NULL||$ges->client_id==0)?'general':'client';
                    if($temp['type'] == 'general')
	                    $data['assingedexerciesids_1'][]=$ges->id;
	                    
                    $temp['folderid']=$ges->folderid;
                    $data['assingedexercies'][] =$temp;
                }

                $this->db->select('exercise.*,exercisefolder_exercise.exercisefolder_id as folderid');
                $this->db->from('exercise_folder');
                $this->db->join('exercisefolder_exercise', 'exercisefolder_exercise.exercisefolder_id=exercise_folder.id', 'left');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted', 0);
//                 if(!empty($data['assingedexercies'])){$this->db->where_not_in('exercise.id', $data['assingedexerciesids']);}
                
                $this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $companyid);
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                
                $getEx=$this->db->get();
                //echo $this->db->last_query();exit;
                    foreach ($getEx->result() as $ges) {
                        $data['clientexercieids'][]=$ges->id;
                        $temp['label']=$ges->name;
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
/*
                if(!empty($data['assingedexercies'])){$this->db->where_not_in('exercise.id', $data['assingedexerciesids']);}
                if(!empty($data['clientexercies'])){$this->db->where_not_in('exercise.id', $data['clientexercieids']);}
*/
                
                $this->db->where('exercise_folder.client_id', 0);
                //$this->db->where('exercise_folder.client_id', $patient_id);
                $this->db->where('exercise_folder.company_id', $companyid);
                $this->db->group_by('exercise.id');
                $this->db->order_by('exercise.name', 'ASC');
                $getEx=$this->db->get();
                //echo $this->db->last_query();exit;
                    foreach ($getEx->result() as $ges) {
                        
                        $temp['label']=$ges->name;
                        $temp['id']=$ges->id;
                        $temp['folderid']=$ges->folderid;
                        // $data['generalexercies'][] =$temp;
                    }

                echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "Client details not available"));
            }
            $getPatientDetails->show_result();
        } else {
            echo json_encode(array('status' => false, 'message' => "Please provide valid data"));
        }
    }
    
    public function getRoutineDetails() {
		$patient_id = $_POST['patient_id'];
		$companyid = $_POST['companyid'];
		$this->db->query('SET SESSION sql_mode = ""');
		
    }
    
    public function getExerciseDetails() {
	    $exercise_id = $_POST["exercise_id"];
        $company_id = $_POST["companyId"];
        $getExerciseDetails = new Exercise();
        $data['details'] = $exercise_id;
        $getExerciseDetails->get_by_id($exercise_id);
        if ($getExerciseDetails->exists()) {
                $data['details'] = $getExerciseDetails->show_result();
        }
        echo json_encode($data);
         
    }
    
    public function exerciseDetails() {
        
        $exercise_id = $_POST["exercise_id"];
        $company_id = $_POST["companyId"];
        if (!empty($exercise_id)) {
            $data['videos'] = array();
            $getExerciseDetails = new Exercise();
            $getExerciseDetails->get_by_id($exercise_id);
            if ($getExerciseDetails->exists()) {
                $data['details'] = $getExerciseDetails->show_result();
                //Exercise Videos
                $this->db->select('videos.id,videos.title');
                $this->db->from('videos');
                $this->db->join('exercise_videos', 'exercise_videos.videos_id=videos.id', 'left');                
                $this->db->where('exercise_videos.exercise_id', $exercise_id);
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('exercise_videos.isdeleted', 0);
                $this->db->order_by('exercise_videos.order', 'ASC');
                $getEXVID = $this->db->get();
                $data['videos']=array();
                if ($getEXVID->num_rows() > 0) {
                    $temp=array();
                    foreach ($getEXVID->result() as $geVID) {
                        
                        $data['assginedvideos'][] = $geVID->id;
                        $data['assginedvideosname'][] = $geVID->title;
                    }
                }
                $this->db->select('exercise_folder.*');
                $this->db->from('exercisefolder_exercise');
                $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');
                $this->db->where('exercisefolder_exercise.exercise_id', $exercise_id);
                $this->db->order_by('exercise_folder.folder_name', 'asc');
                $getVIDEOFOLDER = $this->db->get();
               // echo $this->db->last_query();exit;
                $client_id=0;
                $data['assginedfolder']=array();
                 if ($getVIDEOFOLDER->num_rows() > 0) {
                    foreach ($getVIDEOFOLDER->result() as $getFOLDER) {    
                        
                        $data['assginedfolder'][] = (int)$getFOLDER->id;
                        if($getFOLDER->client_id>0){
                            $client_id=$getFOLDER->client_id;
                        }
                    }
                }
      
                $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $company_id);
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video_folder.folder_type', 0);
                $this->db->where('company_video.folder_id !=', 0);
                $this->db->order_by('videos.title', 'ASC');
                $getEXVID = $this->db->get();
               //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp[$geVID->foldername][]= array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name,  
                            'thumbnail' => $geVID->thumbnail
                        );
                    }ksort($temp);
                    $data['general_videos'] =$temp ;
                }
               // print_r($data['general_videos']);exit;
               $data['client_videos']=array();
                $data['isgeneral']=true;
               if($client_id>0)
               {
                  $data['isgeneral']=false;
                $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $company_id);
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video_folder.folder_type', 1);
                $this->db->where('company_video_folder.client_id =', $client_id);
                $this->db->order_by('videos.title', 'ASC');
                $getEXVID = $this->db->get();
              //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    $temp=  array();
                    foreach ($getEXVID->result() as $geVID) {
                        $temp[$geVID->foldername][]= array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name,
                            'thumbnail' => $geVID->thumbnail                            
                                
                        );
                        
                    }ksort($temp);$data['client_videos'] = $temp;
                }
               }
               
               if($client_id>0)
               {
               $data['cleint_folders']=$data['general_folders']=array();
               $getAllfolders = new Exercise_folder();
               $getAllfolders->where('client_id =', $client_id);
               $getAllfolders->where('company_id', $company_id);
               $getAllfolders->order_by('folder_name', 'ASC');
               $getAllfolders->get();
        
                foreach ($getAllfolders as $gtv) {
                       $data['cleint_folders'][]=$gtv->show_result(); 

                   }
                   
               }else{
                $data['cleint_folders']=$data['general_folders']=array();
                $getAllfolders = new Exercise_folder(); 
                $getAllfolders->where('folder_type !=', 0);
                $getAllfolders->where('company_id', $company_id);
                $getAllfolders->order_by('folder_name', 'ASC');
                $getAllfolders->get();

                 foreach ($getAllfolders as $gtv) {
                        $data['cleint_folders'][]=$gtv->show_result(); 

                    }
                   
               }
            
               $getAllfolders = new Exercise_folder();        
               $getAllfolders->where('folder_type', 0);
               $getAllfolders->where('company_id', $company_id);
               $getAllfolders->order_by('folder_name', 'ASC');
               $getAllfolders->get();
               //echo $this->db->last_query();exit;
                foreach ($getAllfolders as $gtv) {
                       $data['general_folders'][] = $gtv->show_result();
                   }
                   //print_r($data['general_folders']) ;exit; 
                 /*    
                $getAllVideos = new Video();
                $getAllVideos->where("ispublic", 1);
                $getAllVideos->where("isdeleted", 0);
                $getAllVideos->order_by("title", 'asc');
                $getAllVideos->get(); */
                $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $company_id);                
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('videos.ispublic', 1);                
                $this->db->where('company_video.isdeleted', 0);
                $this->db->order_by('videos.id', 'desc');
                $getAllVideos = $this->db->get();
                foreach ($getAllVideos->result() as $gtv) {
                    
                    $data['public_videos'][] = array(
                                    'id' => $gtv->id,
                                    'title' => $gtv->title,
                                    'name' => $gtv->name,
                                    'thumbnail' => $gtv->thumbnail,
                                    'therapist_id' => $gtv->exercise_id
                                );
                }   
                $data["lists"] = [];
                echo json_encode($data);
               //echo "<pre>";
               //print_r($data);exit;
                // $this->load->view('admin/panel/editexercises', $data);
                
               // echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "Routine details not available"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Please provide valid data"));
        }
    }
    
    
    public function deleteExercisebyFolder($exer_id = "")
    {
        
        $folderid = $_POST['folderid'];
        $exer_id  = $_POST['exer_id'];
        $companyid = $_POST['companyid'];
        //print_r($_POST);exit;
        if (!empty($exer_id)&&!empty($_POST['folderid'])) {
            //delete patient
            $deleteExercise = new Exercise();
            $deleteExercise->get_by_id($exer_id);
            if ($deleteExercise->exists()) {
               $getExercisefolder_exercise = new Exercisefolder_exercise();        
               $getExercisefolder_exercise->where('exercisefolder_id', $folderid);
               $getExercisefolder_exercise->where('company_id', $companyid);
               $getExercisefolder_exercise->where('exercise_id',$exer_id);
               $getExercisefolder_exercise->get();
               if ($getExercisefolder_exercise->exists()) {
                        $getExercisefolder_exercise->delete_all();
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

    
    public function deleteclientfolder() {
        //echo 11;exit;
		$folderid = $_POST["folderid"];
		$companyid = $_POST["companyid"];
		
        if (!empty($folderid)) {
            //delete patient
            $deletefolder = new Exercise_folder();
            $deletefolder->where('company_id', $companyid);
            $deletefolder->where('id', $folderid); 
            $deletefolder->where('folder_type', 1);
            $deletefolder->get();
            if ($deletefolder->exists()) {
                if ($deletefolder->delete()) {
                    $deleteExercisefolder_exercise = new Exercisefolder_exercise();
                    $deleteExercisefolder_exercise->where('exercisefolder_id', $folderid);
                    $folserdetail=$deleteExercisefolder_exercise->get();
                    if ($deleteExercisefolder_exercise->exists()) {
                        
                        
                        $deleteExercisefolder_exercise->delete_all();
                        
                        
                    }
                  //$deleteexercise= new Users_exercise();
                  //$deleteexercise->get_by_users_id($patientid);
                  //$deleteexercise->delete_all();
                    echo json_encode(array('status' => true));
                } else {
                    echo json_encode(array('status' => false));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => "Invalid Folder ID"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Required Folder ID"));
        }
    }
    
    //Remove Routine
    public function deletegeneralfolder($folderid = "") {
        //echo 11;exit;
		$folderid = $_POST["folderid"];
		$companyid = $_POST["companyid"];
        if (!empty($folderid)) {
            //delete patient
            $deletefolder = new Exercise_folder();
            $deletefolder->where('company_id', $companyid);
            $deletefolder->where('id', $folderid); 
            $deletefolder->where('folder_type', 0);
            $deletefolder->get();
            if ($deletefolder->exists()) {
                if ($deletefolder->delete()) {
                  //$deleteexercise= new Users_exercise();
                  //$deleteexercise->get_by_users_id($patientid);
                  //$deleteexercise->delete_all();
                    echo json_encode(array('status' => true));
                } else {
                    echo json_encode(array('status' => false));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => "Invalid Folder ID"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "Required Folder ID"));
        }
    }
    
    //Fetching Routine Details
    public function routinedetails()
    {
        
		$companyid = $_POST['companyid'];
		$folderid = $_POST["folderid"];
		$currentPage = $_POST["currentPage"];
        $folder = new Exercise_folder();
            $folder->where('company_id', $companyid );

            if($folderid != "null")
	            $folder->where('id', $folderid);

            $folder->get();
			if ($folder->exists()) {
			  foreach ($folder as $gtv) {
			    	$data['folderdetails'] = $gtv->show_result();
				}
			}
			else {
			    $data['danger'] =  "Opps there is some error please try again later";
			}
			$data['isgeneral']=(isset($data['folderdetails']['folder_type'])&&$data['folderdetails']['folder_type']==0)?true:false;

        //add all existing videos of therapist
        
			$this->db->select('exercise.*,exercisefolder_exercise.insert_at as insertdate');
			$this->db->from('exercisefolder_exercise');
			$this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
			$this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');                
			$this->db->where('exercisefolder_exercise.company_id', $companyid);
			$this->db->where('exercisefolder_exercise.exercisefolder_id', $folderid);
			
			if (!empty($_POST['video_name'])) {
				$data['video_name'] = $_POST['video_name'];
				$this->db->where("(exercise.name LIKE  '%".$data['video_name']."%') AND 1=",1);
			}
			
			$this->db->where('exercise.isdeleted', 0);
			$this->db->order_by('exercise.name', 'asc');
               
            $getEXVID = $this->db->get();
            $totalVideoCount = 0;
			//echo $this->db->last_query();exit;
            if ($getEXVID->num_rows() > 0) {
                foreach ($getEXVID->result() as $geVID) {
					$foldervideos = new Exercise_videos();
					$foldervideos->where('exercise_id', $geVID->id);
					$fvideocount=$foldervideos->count();
                    $temp = array(
                        'id' => $geVID->id,
                        'title' => $geVID->title,                           
                        'name' => $geVID->name,
                        'numberofvideo'=>$fvideocount,
                        'insertdate'=>date('m-d-Y',strtotime($geVID->insertdate))
                    );
                    $totalVideoCount += $fvideocount;
                    $data['exercise_name'][] = $temp;
                }
            }      
	    $data['totalvideocount'] = $totalVideoCount;    
	  	// $data['totalresult'] = $totalresult;
	    $data['folderid'] = $folderid;
		echo json_encode($data);
    }
    
    //For Fetching Client Routines
     public function clientroutinesfolder() {
         
        $companyid = $_POST['companyid'];
        $per_page = $_POST['per_page'];
		$page = $_POST['page'];
        $data['isgeneral'] = false;
        
       $getAllfolders = new Exercise_folder();

		$searchText = $_POST['searchText'];
		
	    if($searchText != ""){
		    $getAllfolders->group_start();
            $getAllfolders->or_like('folder_name', $searchText);
            $getAllfolders->group_end();
	    }
	    
		$data['searchText'] = $searchText;

        $getAllfolders->where('folder_type', 1);
        $getAllfolders->where('client_id !=', 0);
        $getAllfolders->where('company_id', $companyid);
        $getAllfolders->order_by('folder_name', 'asc');
        $getAllfolders->limit($per_page, (($page - 1) * $per_page));
        $getAllfolders->get();
        $folderdetail = $data['folder_remained'] = array();
        
        foreach ($getAllfolders as $gtv) {
			$folderdetail= $gtv->show_result();
			
			$this->db->select('exercise.*,users_exercise.*');
                $this->db->from('users_exercise');
                $this->db->join('exercise', 'exercise.id=users_exercise.exercise_id', 'right');
//                $this->db->where('exercise_folder.client_id !=', 0);
                $this->db->where('users_exercise.users_id', $gtv->client_id);
                $getEx=$this->db->get();
                
                
			$folderdetail['routinecount']=$getEx->num_rows();
			$folderdetail['HERE']='BBBBB';
			$folderdetail['folderid']=$gtv->id;              
			$data['general_folders'][]=$folderdetail; 
			$folderids[]=$folderdetail['id'];
        }
        
        $listPatients = new Patient();
        $listPatients->where('roles_id', 3);
        $listPatients->where('company_id', $companyid);
        $listPatients->where('isdeleted', 0);
        $listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();
        foreach($listPatients as $Patients)
        {
            $patriendetail=$Patients->show_result(); 
            if(!in_array($patriendetail['id'], $folderdetail))
	            {
		            $patriendetail->remove = true;
		            $data['folder_remained'][] = $patriendetail;}
        }    
		echo json_encode($data);
         
     }
    
    //For fetching general Routines 
	public function generalroutinesfolder() {
	     
	    $companyid = $_POST['companyid'];
	    $data['isgeneral'] = true;
	      $per_page = $_POST['per_page'];
		$page = $_POST['page'];
		
		
		
	    //add all existing videos of therapist
	    $getAllfolders = new Exercise_folder();
	
	    if (!empty($_POST['folder_name'])) {
	        $getAllfolders->like("folder_name", $_POST['folder_name']);
	        $data['folder_name'] = $_POST['folder_name'];
	    }
	    
	    $getAllfolders->where('folder_type', 0);
	    $getAllfolders->where('company_id', $companyid);

	    $searchText = $_POST['searchText'];
	    if($searchText != ""){
		    $getAllfolders->group_start();
            $getAllfolders->or_like('folder_name', $searchText);
            $getAllfolders->group_end();
	    }
	    $getAllfolders->order_by('folder_name', 'asc');
		$getAllfolders->limit($per_page, (($page - 1) * $per_page));
	    $getAllfolders->get();
	    foreach ($getAllfolders as $gtv) {
			$folderdetail=$gtv->show_result();
			$routinesinfolder= new Exercisefolder_exercise();
			$routinesinfolder->where('exercisefolder_id', $gtv->id);
			$folderdetail['routinecount']=$routinesinfolder->count(); 
			$folderdetail['HERE']='AAAAAAA';
			$folderdetail['folderid']= $gtv->id;
			$folderdetail['isShow'] = true;
			$date = new DateTime($folderdetail['insert_at']);
			$folderdetail['insert_at'] = $date->format('M d, Y h:i a');
			$data['general_folders'][] = $folderdetail;
	    }
	    echo json_encode($data); 
	 }
    
    public function addNewExercise() {
        
         $videoids=  explode(',', $_POST['videoids']);
         $userid = $_POST['userid'];
         $exerciseId = $_POST['exercise_id'];
         $clientid = $_POST['clientid'];
         $companyid = $_POST['companyid'];
         $generalfolderid = explode(',', $_POST['generalfolderid']);
         $clientfolderid = explode(',', $_POST['clientfolderid']);
		 $exc_name = $_POST['name'];
		 $descrip = $_POST['description'];
		
        if (!empty($_POST)) {
	        
                $addEx = new Exercise();
                if($exerciseId != "" || $exerciseId > 0){
	                $addEx->id = $exerciseId;	                
                }

                $addEx->name = $exc_name;
                $addEx->description = $descrip;
                $addEx->therapist_id = $userid;
                $addEx->company_id =$companyid;  
				$resultAdd = $addEx->save();
				
				if ($resultAdd) {

                    $ex_id = $addEx->id;
                    //add ex videos
                    // $videoids=  explode(',', $_POST['videoids']);
					$addEXVID = new Exercise_videos();
	                $addEXVID->where('exercise_id',$ex_id);
	                $addEXVID->get();
	                if ($addEXVID->exists()) {
	                    $updated=$addEXVID->delete_all();
	                }
	                //General Videos
                    foreach ($videoids as $key => $val) {
                        if($val != ""){
							$addEXVID = new Exercise_videos();
                            $addEXVID->videos_id = $val;
                            $addEXVID->exercise_id = $ex_id;
                            $addEXVID->company_id = $companyid;                   
                            $addEXVID->order =$key+1;
                            $addEXVID->save();
                        }
                    }
                    //General Folder
                    $Exercisefolder_exercise = new Exercisefolder_exercise();
	                $Exercisefolder_exercise->where('exercise_id',$ex_id);
	                $Exercisefolder_exercise->get();
	                if ($Exercisefolder_exercise->exists()) {
	                    $updated=$Exercisefolder_exercise->delete_all();
	                }
                    foreach ($generalfolderid as $folderid) {
                        if($folderid != '' ){

                            $Exercisefolder_exercise= new Exercisefolder_exercise();
                            $Exercisefolder_exercise->exercise_id=$ex_id;
                            $Exercisefolder_exercise->exercisefolder_id=$folderid;
                            $Exercisefolder_exercise->company_id=$companyid;
                            $Exercisefolder_exercise->save();
                            $clinet_id=$folderid;

						}
                       // echo  $this->db->last_query();exit;
                    }


					//Send Notification to User
                    $users=array();
                    $exercisesuser= new Users_exercise();
                    $exercisesuser->where('exercise_id', $ex_id);
                    $exercisesuser->get();
                    //TODO What we will do in Client Folders to Save Routine?
                    
                    if ($exercisesuser->exists()) {
	                   
                        foreach ($exercisesuser as $exrs)
                        {
                            $exrsdetail=$exrs->show_result();
                            $users[]=$exrsdetail['users_id'];
                        }

                        if(!empty($users))
                        {
                            $userspushtokens=array();
                            $userssession= new Users_sessions();
                            $userssession->where_in('user_id', $users);
                            $userssession->get();

                            if ($userssession->exists()) {
                                foreach ($userssession as $userssessionids)
                                {
                                    $userspushtokens[]=$userssessionids->pushtoken;
                                }

                                if(!empty($userspushtokens))
                                {
                                    $ext_params['exerciseid']=$ex_id;
                                    my_iphone_push_notification($userspushtokens, 'You have new/updated routine '.$exc_name,$ext_params);
                                }
                            }


                            $usersdetial= new User();
                            $usersdetial->where_in('id', $users);
                            $usersdetial->get();

                            foreach ($usersdetial as $udetail)
                            {
                                $userdetail=$udetail->show_result();
                                $sendMailStatus = my_email_send($userdetail['email'], "You have new/updated routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                            }
                        }
                    }
                }
		}
		$data["folderId"] = $folderdetail->id;
		$data["result"] = "success";
		echo json_encode($data);
    }
    
    
    public function addRoutineToClient() {
        
        $therapistId = $_POST['therapistId'];
		$companyId = $_POST['companyId'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$usersId = explode(',', $_POST['usersId']);
		$videosId = explode(',', $_POST['videosId']);
		$folderId = $_POST['folderId'];
		$patientId = $_POST['patientId'];
		$exerciseId = $_POST['exerciseId'];
		$videoType = $_POST['videoType'];
		
        if (!empty($_POST)) {
	        foreach($usersId as $user){
		        $addEx = new Exercise();
                $addEx->therapist_id = $therapistId;
                $addEx->company_id = $companyId;
                $addEx->name = $name;
                $addEx->description = $description;  
				$myExer = $addEx->save();
				$exerId = $addEx->id;
				$order = 0;
				echo $myExer->id;
				
				foreach($videosId as $video){
					$addExercise_videos = new Exercise_videos();
	                $addExercise_videos->videos_id = $video;
	                $addExercise_videos->exercise_id = $exerId;
	                $addExercise_videos->company_id = $companyId; 
	                $addExercise_videos->order = $order ;  
					$addExercise_videos->save();
					$order++;
				}
				
				$exerFolderExer = new Exercisefolder_exercise();
                $exerFolderExer->exercise_id = $exerId;
                $exerFolderExer->exercisefolder_id = $user;
                $exerFolderExer->company_id = $companyId;
				$exerFolderExer->save();
				
				$User_exercise = new Users_exercise();
                $User_exercise->users_id = $user;
                $User_exercise->exercise_id = $exerId;
				$User_exercise->save();
				
				
	        }
		}

		$data["result"] = "success";
		echo json_encode($data);
    }
    
    
    public function addRoutineToGeneral() {
        
        $therapistId = $_POST['therapistId'];
		$companyId = $_POST['companyId'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$generalsId = explode(',', $_POST['generalsId']);
		$videosId = explode(',', $_POST['videosId']);
		$folderId = $_POST['folderId'];
		$patientId = $_POST['patientId'];
		$videoType = $_POST['videoType'];
		$exerId = $_POST['exerciseId'];
		
        if (!empty($_POST)) {
	        foreach($generalsId as $user){
		        $order = 0;
/*
				foreach($videosId as $video){
					$addExercise_videos = new Exercise_videos();
	                $addExercise_videos->videos_id = $video;
	                $addExercise_videos->exercise_id = $exerId;
	                $addExercise_videos->company_id = $companyId; 
	                $addExercise_videos->order = $order ;  
					$addExercise_videos->save();
					$order++;
				}
*/
				
				$exerFolderExer = new Exercisefolder_exercise();
                $exerFolderExer->exercise_id = $exerId;
                $exerFolderExer->exercisefolder_id = $user;
                $exerFolderExer->company_id = $companyId;
				$exerFolderExer->save();
	        }
		}

		$data["result"] = "success";
		echo json_encode($data);
    }

    
    public function updateClientRoutine() {
        
         $userid = $_POST['userid'];
         $exerciseId = $_POST['exercise_id'];
         $clientid = $_POST['clientid'];
         $companyid = $_POST['companyid'];
		 $exc_name = $_POST['name'];
		 $descrip = $_POST['description'];
		
		 //print_r($videoids);exit;
        if (!empty($_POST)) {
	        
                $addEx = new Exercise();
                if($exerciseId != "" || $exerciseId > 0){
	                $addEx->id = $exerciseId;	                
                }

                $addEx->name = $exc_name;
                $addEx->description = $descrip;
                $addEx->therapist_id = $userid;
                $addEx->company_id =$companyid;  
				$resultAdd = $addEx->save();
				
				if ($resultAdd) {

                    $ex_id = $addEx->id;
                    
					//Send Notification to User
                    $users=array();
                    $exercisesuser= new Users_exercise();
                    $exercisesuser->where('exercise_id', $ex_id);
                    $exercisesuser->get();
                    //TODO What we will do in Client Folders to Save Routine?
                    
                    if ($exercisesuser->exists()) {
	                   
                        foreach ($exercisesuser as $exrs)
                        {
                            $exrsdetail=$exrs->show_result();
                            $users[]=$exrsdetail['users_id'];
                        }

                        if(!empty($users))
                        {
                            $userspushtokens=array();
                            $userssession= new Users_sessions();
                            $userssession->where_in('user_id', $users);
                            $userssession->get();

                            if ($userssession->exists()) {
                                foreach ($userssession as $userssessionids)
                                {
                                    $userspushtokens[]=$userssessionids->pushtoken;
                                }

                                if(!empty($userspushtokens))
                                {
                                    $ext_params['exerciseid']=$ex_id;
                                    my_iphone_push_notification($userspushtokens, 'You have new/updated routine '.$exc_name,$ext_params);
                                }
                            }


                            $usersdetial= new User();
                            $usersdetial->where_in('id', $users);
                            $usersdetial->get();

                            foreach ($usersdetial as $udetail)
                            {
                                $userdetail=$udetail->show_result();
                                $sendMailStatus = my_email_send($userdetail['email'], "You have new/updated routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                            }
                        }
                    }
                }
		}
		$data["folderId"] = $folderdetail->id;
		$data["result"] = "success";
		echo json_encode($data);
    }
    
     public function addgeneralfolder() 
     {
        if (!empty($_POST)) {
            
              $name = $_POST['folder_name'];  
			  $companyId = $_POST['companyId']; 
			  if($name != ""){
	              $folder= new Exercise_folder();
	              $folder->company_id = $companyId ;
	              $folder->folder_name = $name;
	              $folder->folder_type = 0;
	              if($folder->save())
	              {
	               echo "success";
	              }   
              }               
        }
    }

        
    
    public function fetchClientVideos() 
    {
	    $companyid = $_POST['companyid'];
	    $clientid = 87;
	    $this->db->select('videos.*,company_video_folder.folder_name as foldername');
        $this->db->from('company_video_folder');
        $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
        $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
        $this->db->where('company_video_folder.company_id', $companyid);
        $this->db->where('videos.isdeleted', 0);
        $this->db->where('company_video_folder.folder_type', 1);
		// $this->db->where('company_video_folder.client_id =', $clientid);
        $this->db->order_by("videos.title", 'asc');
        $getEXVID = $this->db->get();
        $data['success'] = "1";
//      echo $this->db->last_query();exit;
        if ($getEXVID->num_rows() > 0) {
            foreach ($getEXVID->result() as $geVID) {              
                $results[$geVID->foldername][] = array(
                    'id' => $geVID->id,
                    'label' => $geVID->title, 
                    'labelKey' => $geVID->id                             
                    // 'name' => $geVID->name,
                    // 'thumbnail'=>$geVID->thumbnail       
                );
            }

            foreach($results as $index=>$result){
	            $temp = [];
	            $temp["id"] = $index;
	            $temp["label"] = $index."(".count($result).")";
	            $temp["children"] = $result;
	            $finalresult[] = $temp;
            }

            // $data['general_videos'] = $finalresult;
            $data['results'] = $results;
            
			
        }
        echo json_encode($data);
		
    }
    
    public function getGeneralByFolderName() {
	    $companyId = $_POST['companyId'];
	    $folderName = $_POST['folderName'];
	     $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $companyId);
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video_folder.folder_type', 0);
                $this->db->where('company_video.folder_id !=', 0);
                $this->db->where('company_video_folder.folder_name', $folderName);
                $this->db->order_by('videos.title', 'ASC');
                $getEXVID = $this->db->get();
               //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
	                $temp[] = $getEXVID->result();
					ksort($temp);
                    $data['general_videos'] =$temp ;
                }
                
				echo json_encode($data);

    }
    
    public function getGeneralCategory() {


	    $companyId = $_POST['companyId'];
	    $this->db->select('company_video_folder.folder_name as foldername');
        $this->db->from('company_video_folder');
        $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
        $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
        $this->db->where('company_video_folder.company_id', $companyId);
        $this->db->where('videos.isdeleted', 0);
        $this->db->where('company_video_folder.folder_type', 0);
        $this->db->where('company_video.folder_id !=', 0);
        $this->db->group_by('company_video_folder.folder_name');
        $getEXVID = $this->db->get();
       //echo $this->db->last_query();exit;
        if ($getEXVID->num_rows() > 0) {
	        $result = $getEXVID->result();
	        

/*
			$myid = new Exercise_folder();        
			$myid->where('folder_name', $result);
			$myid->get();
*/

			$arrData = [];
			foreach($getEXVID->result() as $gtv){
				
				$myid = new Company_video_folder();        
				$myid->where('folder_name', $gtv->foldername);
				$myid->get();
				$gtv->id = $myid->id;
				array_push($arrData,  $gtv);
			}
			//$temp[] = $object;
			//$object->id =$myid->result();
			
            
			//ksort($temp);
            $data['general_videos'] =$arrData ;
        }
        
		echo json_encode($data);

    }
    
    public function getClientVideos() {
	    
	    $companyId = $_POST["companyId"];
	    $client_id = $_POST["client_id"];
	    
	    		$this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $companyId);
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video_folder.folder_type', 1);
                $this->db->where('company_video_folder.client_id', $client_id);
                $this->db->order_by('videos.title', 'ASC');
                $getEXVID = $this->db->get();
              //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    $temp=  array();
                    $data['client_videos'] = $getEXVID->result();
                }
                 $data['companyId'] = $companyId;
                 $data['client_id'] = $client_id;
                echo json_encode($data);
                

    }
    
    public function checkExerciseName() {

	    $name = $_POST["name"];
		$routineId = $_POST["routineId"];
		
		$this->db->select('*');
		$this->db->from('exercise');
		$this->db->where('exercise.name', $name);                
		$data = $this->db->get();
		
		echo $data->num_rows();

		
    }
    
    public function fetchPublicVideos() {
	    $companyid = $_POST['companyid'];
		$this->db->select('videos.*');
		$this->db->from('videos');
		$this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
		$this->db->where('company_video.company_id', $companyid);                
		$this->db->where('videos.isdeleted', 0);
        $this->db->where('videos.ispublic', 1);                
        $this->db->where('company_video.isdeleted', 0);
        $this->db->order_by('videos.id', 'desc');
		$getAllVideos = $this->db->get();
		
		foreach ($getAllVideos->result() as $gtv) {
			$data[] = array(
			    'id' => $gtv->id,
			    'label' => $gtv->title,
			    'name' => $gtv->name,
			    'labelKey' => $gtv->id,  
			    'thumbnail' => $gtv->thumbnail,
			    'therapist_id' => $gtv->exercise_id
			);
		}
		
		$temp = [];
		$temp["id"] = 1;
		$temp["label"] = 'Public Video';
		$temp["children"] = $data;
		$finalresult['general_videos'][] = $temp;
	            
		echo json_encode($finalresult);

		
    }
    
    public function fetchGeneralVideos() {
	    
	    $companyid = $_POST['companyid'];
	    $this->db->select('videos.*,company_video_folder.folder_name as foldername');
        $this->db->from('company_video_folder');
        $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
        $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
        $this->db->where('company_video_folder.company_id', $companyid);
        $this->db->where('videos.isdeleted', 0);
        $this->db->where('company_video_folder.folder_type', 0);
        $this->db->where('company_video.folder_id !=', 0);
        $this->db->order_by("videos.title", 'asc');
                $this->db->order_by("company_video_folder.folder_name", 'asc');
        $getEXVID = $this->db->get();

        if ($getEXVID->num_rows() > 0) {
            foreach ($getEXVID->result() as $geVID) {              
                $results[$geVID->foldername][] = array(
                            'id' => $geVID->id,
                            'label' => $geVID->title, 
                            'labelKey' => $geVID->id                             
                            //'name' => $geVID->name,
                            //'thumbnail'=>$geVID->thumbnail
                                
                );
            }
            foreach($results as $index=>$result){
	            $temp = [];
	            $temp["id"] = $index;
	            $temp["label"] = $index."(".count($result).")";
	            $temp["children"] = $result;
	            $finalresult[] = $temp;
            }
            $data['general_videos'] = $finalresult;
        }
        
        echo json_encode($data);

    }
    
     public function addgeneralfolderajax() {
        if (!empty($_POST)) {
            
          
             
              $name = $_POST['foldername'];
              $companyid =  $_POST['companyid'];
              $client_id =  $_POST['client_id'];
              $folder= new Exercise_folder();
              $folder->company_id = $companyid;
              $folder->folder_name = $name;
              $folder->client_id = $client_id ;
              //TODO figure this folder type
              $folder->folder_type = 1;
              if($folder->save())
              {
                $response['folder_id']=$client_id;
                $response['folder_name']=$name;
                $response['success']=true;
                  
              }else{
                $response['success']=false;
           
        } 

      }
      else {
                $response['success']=false;
        }
        echo json_encode($response);
        
    
  }


    
    public function fetchClientFolder(){
	    $clientid = $_POST["clientid"];
	    $companyid = $_POST["companyid"];	
	    $videoType = $_POST["videoType"];    
		
	    $getAllfolders = new Exercise_folder();
	    if($videoType == 0)
        	$getAllfolders->where('client_id =', $clientid);
        	
        $getAllfolders->where('company_id', $companyid);
        $getAllfolders->order_by('folder_name', 'asc');
        $getAllfolders->get();
        
         foreach ($getAllfolders as $gtv) {
            $data['client_folders'][]=$gtv->show_result(); 
        }

        echo json_encode($data);
    }
    
     public function fetchGeneralFolders(){
	    $companyid = $_POST["companyid"];
	
		//add all existing videos of therapist
		$getAllfolders = new Exercise_folder();        
		$getAllfolders->where('folder_type', 0);
		$getAllfolders->where('company_id', $companyid);
		$getAllfolders->order_by("folder_name", 'asc');
		$getAllfolders->get();
		foreach ($getAllfolders as $gtv) {
			$data['general_folders'][] = $gtv->show_result();
		}
		
        echo json_encode($data);
    }

    
     
    public function uploadFiles(){
        header("Expires: Mon, 26 Jul 2025 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $result   = [];
		try {
		    foreach ($_FILES as $key=>$file) {
			 $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
			    // var_dump($file);
			     $arrValidVideo = array(
				        'jpg' => 'image/jpeg',
			            'mp4' => 'video/mp4',
			            'mov' => 'video/quicktime',
			            'flv' => 'video/x-flv',
			            '3gp' => 'video/3gpp',
			            'wmv' => 'video/x-ms-wmv',
			            'avi' => 'video/x-msvideo');
			    if (array_search($file["type"],$arrValidVideo)){
				   $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
				}
			    else {
			        throw new RuntimeException('Invalid file format.');
			    }
				$fileNameOnly = "o_".substr(sha1_file($file['tmp_name']),0,13);
				$newFileName = sprintf('./assets/uploads/exercises/%s.%s',
			            $fileNameOnly,
			            $ext);
			            
			    if (!move_uploaded_file($file["tmp_name"],$newFileName)) {
			        throw new RuntimeException('Failed to move uploaded file.');
			    }
			    $file['newname'] = $newFileName;
			    $file['filenameonly'] = $fileNameOnly.'.'.$ext;
				array_push($result,$file);
	    	}		  
		
		} catch (RuntimeException $e) {
		
		    echo $e->getMessage();
		
		}
		
		 echo json_encode($result);

    }
    public function updateTitle(){
		//echo "start";
		$videoid = $_POST["videoid"];
		$title = $_POST["title"];
		$video = new Video();
		$video->get_by_id($videoid);
		
		if ($video->exists()) {
			$video->title = $title;
			$video->update_at = my_datenow();
			$video->save();
		}
		
		echo "Video Title Saved";
    }
    
    public function live_ffmpeg($input_video) {
        $ffmpeg='/public_html/ffmpeg';    
        $video = "/public_html/dashboard/assets/uploads/exercises/$input_video";
        $path_parts = pathinfo($input_video);
        $output_file_name = $path_parts['filename'] . '.png';
        $output = ("/public_html/dashboard/assets/uploads/exercises/thumbnails/$output_file_name");

        // get the screenshot      
        $cmd = "$ffmpeg -i $video -ss 00:00:02.000 -vframes 1 $output";
        shell_exec($cmd);
        return $output_file_name;
    }
    
    public function addNewVideo() {
	    if (!empty($_POST)) {
            ///print_r($_POST);exit;
            $done=false;
            foreach($_POST['videos'] as $i=>$data)
            {
	            $name = $data;
	
	            $addNewVideo = new Video();
	            $addNewVideo->title = '';
	            $addNewVideo->name = $name;
	
	            $thumbnail = $this->live_ffmpeg($name);
	            $addNewVideo->thumbnail = $thumbnail;
	            $addNewVideo->therapist_id = $_POST["therapistid"];
	            $addNewVideo->company_id = $_POST["companyid"];
	            $addNewVideo->folder_id = $_POST['folderid']; 
	            $addNewVideo->ispublic = 0; 
	            $addNewVideo->save();
	            
	            $companyvideo = new Company_video();
	            $companyvideo->video_id=$addNewVideo->id;
	            $companyvideo->company_id = $_POST["companyid"];
	            $companyvideo->folder_id = $_POST['folderid'];
	            $companyvideo->save();            
                $done=true;
                $dataarr[]=array('id' => $addNewVideo->id);
            }
            
            if ($done) {
                echo json_encode(array('status' => true, 'data' => $dataarr));
            } else {
                echo json_encode(array('status' => false));
            }
        } else {
            echo json_encode(array('status' => false));
        }
    }
    
    public function deleteVideo() {
	    $company_id = $_POST["companyid"];
		$video_id = $_POST["video_id"];
        if (!empty($video_id)) {
            $Video = new Video();
            $Video->get_by_id($video_id);
            if ($Video->exists()) {
                
				$Video->isdeleted = 1;
				$Video->delete_at = my_datenow();
				$Video->save();
				$updated=1;
           
                $deletecvideo = new Company_video();
                $deletecvideo->where('company_id',$company_id);
                $deletecvideo->where('video_id',$video_id);
                $deletecvideo->get();
                if ($deletecvideo->exists()) {
                    $updated=$deletecvideo->delete_all();
                }
                //echo $this->db->last_query();exit;
           
                //delete from exercise                    
                $deletevideo = new Exercise_videos();
                $deletevideo->where('company_id',$company_id);
                $deletevideo->where('videos_id',$video_id);
                $deletevideo->get();
                if ($deletevideo->exists()) {
                    $updated=$deletevideo->delete_all();
                }
                if($updated){
                echo json_encode(array('status' => true));}
                else{echo json_encode(array('status' =>false));}
                
            }
            
            else {
                echo json_encode(array('status' => false));
            }
        } else {
            echo json_encode(array('status' => false));
        }
    }
    
    public function Pluploader() {
        //print_r($_REQUEST);exit;
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        $targetDir = 'assets/exercises/';

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }


        $fileName = $file["name"];
        
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
            if ($file["error"] || !is_uploaded_file($file["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($file["tmp_name"], "rb")) {
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
        $jsondata['originalname']=(isset($_REQUEST["name"]))? preg_replace('/\\.[^.\\s]{3,4}$/', '', $_REQUEST["name"]):'';

        echo json_encode($jsondata);
    }
    public function clientdetail2(){
		// echo ($this->uri->segment(4));exit;
		$company_id = $_POST['companyid'];
		$folderid =  $_POST['folderid'];
        $data['page_title'] = 'Public Video Library';
       
        $data['active_class'] = 'videos';
        $folder = new Company_video_folder();
            $folder->where('company_id', $company_id);
            $folder->where('id', $folderid);
            $folder->get();
			if ($folder->exists()) {
              	foreach ($folder as $gtv) {
                	$data['folderdetails'] = $gtv->show_result();
            	}
          	}
		  	else {
			  	$data['error'] = "Opps there is some error please try again later";
          }
          
          $data['isgeneral']=(isset($data['folderdetails']['folder_type'])&&$data['folderdetails']['folder_type']==0)?true:false;

        //add all existing videos of therapist
        
         $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $company_id);
                $this->db->where('company_video.folder_id', $folderid);
                if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
                $this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
                
                
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video.isdeleted', 0);
                $this->db->order_by('videos.title', 'asc');
                $getEXVID = $this->db->get();
                 //echo $this->db->last_query();exit;
        $data['exercise_videos'] = array();
        $totalresult =0;
        if ($getEXVID->num_rows() > 0) {
            //paginition
            $totalresult = $getEXVID->num_rows();
            $numlinks = 3;
            $per_page = 100;
            // $data["links"] = $this->paginationInit("admin/folders/detail/".$folderid, $totalresult, $numlinks, $per_page, 5);
           
             $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $company_id);
                $this->db->where('company_video.folder_id', $folderid);
                if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
                $this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video.isdeleted', 0);
                $this->db->order_by('videos.title', 'asc');
                $this->db->limit($per_page, (($page - 1) * $per_page));
                $getEXVID = $this->db->get();
                //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp = array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name,
                            'thumbnail' => $geVID->thumbnail
                        );
                        $data['exercise_videos'][] = $temp;
                    }
                }
         
        }
        
		 $userdetail = new Exercise_folder();
		$userdetail->select('folder_name');
		$userdetail->where('id', $folderid);
		$userdetail->get();
		$data['userdetail']=$userdetail->folder_name;



        $data['totalresult']=$totalresult;
        $data['folderid']=$folderid;
       echo json_encode($data);
		
	}
    
	public function clientdetail(){
		// echo ($this->uri->segment(4));exit;
		$dataRequest = json_decode(file_get_contents('php://input'),1);
		$company_id = $dataRequest['companyid'];
		$folderid =  $dataRequest['folderid'];
		
        $data['page_title'] = 'Public Video Library';
       
        $data['active_class'] = 'videos';
        $folder = new Company_video_folder();
            $folder->where('company_id', $company_id);
            $folder->where('id', $folderid);
            $folder->get();
			if ($folder->exists()) {
              	foreach ($folder as $gtv) {
                	$data['folderdetails'] = $gtv->show_result();
            	}
          	}
		  	else {
			  	$data['error'] = "Opps there is some error please try again later";
          }
          
          $data['isgeneral']=(isset($data['folderdetails']['folder_type'])&&$data['folderdetails']['folder_type']==0)?true:false;

        //add all existing videos of therapist
        
		    $this->db->select('videos.*');
            $this->db->from('videos');
            $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
            $this->db->where('company_video.company_id', $company_id);
            $this->db->where('company_video.folder_id', $folderid);
            if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
            	$this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
           	}
                
                
            $this->db->where('videos.isdeleted', 0);
            $this->db->where('company_video.isdeleted', 0);
            $this->db->order_by('videos.title', 'asc');
            $getEXVID = $this->db->get();
                 //echo $this->db->last_query();exit;
        $data['exercise_videos'] = array();
        $totalresult =0;
        if ($getEXVID->num_rows() > 0) {
            //paginition
            $totalresult = $getEXVID->num_rows();
            $numlinks = 3;
            $per_page = 100;
            // $data["links"] = $this->paginationInit("admin/folders/detail/".$folderid, $totalresult, $numlinks, $per_page, 5);
           
             $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $company_id);
                $this->db->where('company_video.folder_id', $folderid);
                if (!empty($_POST['video_name'])) {
	                $data['video_name'] = $_POST['video_name'];
	                $this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video.isdeleted', 0);
                $this->db->order_by('videos.title', 'asc');
                $this->db->limit($per_page, (($page - 1) * $per_page));
                $getEXVID = $this->db->get();
                //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp = array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name,
                            'thumbnail' => $geVID->thumbnail,
                            'selected' => false
                        );
                        $data['exercise_videos'][] = $temp;
                    }
                }
         
        }
          
  
        $userdetail = new Exercise_folder();
		$userdetail->select('folder_name');
		$userdetail->where('id', $folderid);
		$userdetail->get();
		$data['userdetail']=$userdetail->folder_name;
		
        
        $data['folderid']=$folderid;            
        $data['totalresult']=$totalresult;

       echo json_encode($data);
		
	}
	
	public function getExercise(){
		// echo ($this->uri->segment(4));exit;
		$dataRequest = json_decode(file_get_contents('php://input'),1);
		$exerciseId = $dataRequest['exerciseId'];
		// $exerciseId = $_POST['exerciseId'];
        $detail = new Exercise();
		$detail->where('id', $exerciseId );
		$detail->get();

		$data['exerciseId']=$exerciseId;
		$data['detail']=$detail->name;
		echo json_encode($data);
		
	}
	
	public function getGeneralExercise(){
		// echo ($this->uri->segment(4));exit;
		$dataRequest = json_decode(file_get_contents('php://input'),1);
		$exerciseId = $dataRequest['exerciseId'];
		// $exerciseId = $_POST['exerciseId'];
		$this->db->select('videos.*');
        $this->db->from('videos');
        $this->db->join('exercise_videos', 'exercise_videos.videos_id=videos.id', 'left');                
        $this->db->where('exercise_videos.exercise_id', (int)$exerciseId);
        $this->db->where('videos.isdeleted', 0);
        $this->db->where('exercise_videos.isdeleted', 0);
        $this->db->order_by('exercise_videos.order', 'ASC');
        $getEXVID = $this->db->get();

		$arrVideo = [];
		foreach($getEXVID->result() as $video){
			$video->selected = false;
			array_push($arrVideo, $video);
		}
		
		$exersisedetail = new Exercise();
        $exersisedetail->get_by_id($exerciseId);

		
		$data['exerciseId']=$exerciseId;
		$data['lists']=$arrVideo;
		$data['detail']=$exersisedetail->show_result();
		echo json_encode($data);
		
	}
	
	public function addVideoToRoutine(){
		// echo ($this->uri->segment(4));exit;
		// $dataRequest = json_decode(file_get_contents('php://input'),1);
		$videoids = $_POST['videoids'];
		$exerciseId = $_POST['exerciseId'];
		$companyId = $_POST['companyId'];

		$arrVideos = explode(",", $videoids);
		$i = 0;
		foreach($arrVideos as $video){
			$hasExer = new Exercise_videos();
			$hasExer->where($exer_id);
			$hasExer->where('videos_id', $video);
			$hasExer->where('exercise_id', $exerciseId);
		                    
            if (!$hasExer->exists()){
				$addExercise = new Exercise_videos();
				$addExercise->exercise_id = $exerciseId;
				$addExercise->videos_id = $video;
				$addExercise->order = $i;
				$addExercise->company_id = $companyId;
				$addExercise->save();	
            }
            
            
			$i++;		
		}
			
			
		$data['exerciseId']=$exerciseId;
		$data['videoids']=$videoids;
		echo json_encode($data);
		
	}
	
	
	public function generalvideosfolder() {
         
         $companyid = $_POST["companyid"];
        $data['isgeneral'] = true;
        

        //add all existing videos of therapist
        $getAllfolders = new Company_video_folder();
        if (!empty($_POST['folder_name'])) {
	        $folderName = $_POST['folder_name'];
            $getAllfolders->like("folder_name", $_POST['folder_name']);
            $data['folder_name'] = $_POST['folder_name'];
        }
        $getAllfolders->where('folder_type', 0);
        $getAllfolders->where('company_id', $companyid);
        $getAllfolders->order_by('folder_name', 'asc');
        $getAllfolders->get();
		foreach ($getAllfolders as $gtv) {
			$folderdetail=$gtv->show_result();
			$videoinfolder= new Company_video();
			$videoinfolder->where('folder_id', $gtv->id);
			$folderdetail['numberofvideo']=$videoinfolder->count(); 
			$data['general_folders'][] = $folderdetail;
		}
            ///echo "<pre>";
           /// print_r($data);exit;
        echo json_encode($data);
         
     }
     
    public function clientvideosfolder() {
         $page = $_POST['page'];
		$per_page = $_POST['per_page'];
		$company_id = $_POST['companyid'];
		$searchText = $_POST['searchText'];
        $data['page_title'] = 'Client Videos Folders';
        $data['active_class'] = 'videos';
        $data['isgeneral'] = false;
        
       $getAllfolders = new Company_video_folder();
        if (!empty($_POST['folder_name'])) {
            $getAllfolders->like("folder_name", $_POST['folder_name']);
            $data['folder_name'] = $_POST['folder_name'];
        }
        $getAllfolders->where('folder_type', 1);
        $getAllfolders->where('client_id !=', 0);
        $searchText = $_POST['searchText'];
	    if($searchText != ""){
		    $getAllfolders->group_start();
            $getAllfolders->or_like('folder_name', $searchText);
            $getAllfolders->group_end();
	    }
	    
        $getAllfolders->where('company_id', $company_id);
        $getAllfolders->order_by('folder_name', 'asc');
        $getAllfolders->limit($per_page, (($page - 1) * $per_page));
        $getAllfolders->get();
        $folderdetail=$data['folder_remained']=array();
        foreach ($getAllfolders as $gtv) {
	             $folderdetail=$gtv->show_result();
	             $videoinfolder= new Company_video();
	             $videoinfolder->where('folder_id', $gtv->id);
	             $folderdetail['numberofvideo']=$videoinfolder->count(); 
	             $data['general_folders'][]=$folderdetail; 
	             $folderids[]=$folderdetail['id'];
        }
           
		$listPatients = new Patient();
        $listPatients->where('roles_id', 3);
        $listPatients->where('company_id', $company_id);
        $listPatients->where('isdeleted', 0);

	    if($searchText != ""){
		    $listPatients->group_start();
            $listPatients->or_like('firstname', $searchText);
            $listPatients->or_like('lastname', $searchText);
            $listPatients->or_like('email', $searchText);
            $listPatients->group_end();
	    }
		$listPatients->limit($per_page, (($page - 1) * $per_page));
        $listPatients->get();
		foreach($listPatients as $Patients)
        {
            $patriendetail=$Patients->show_result(); 
             
            if(!in_array($patriendetail['id'], $folderdetail))
            {$data['folder_remained'][] = $patriendetail;}
        } 
        $data['per_page'] = $per_page;
        echo json_encode($data);         
     }
     

    public function loginmobile() {
        
            //var_dump($_POST);
            $email = $_REQUEST['email'];
            //var_dump($email);
            $password = $_REQUEST['password'];

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
                              //add user assigned exercises


/*
		                    $exercises = array();
		                    
		                    $user_id = $userdetail["id"];
		                     $this->db->select('exercise.*');
                $this->db->from('user_exercise');
                $this->db->join('exercise', 'user_exercise.exercisefolder_id=exercise_folder.id', 'left');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->where('exercise.isdeleted',0);
                
		                    $getExercisesID = new Users_exercise();
		                    $getExercisesID->select('exercise_id');
		                    $getExercisesID->where('isdeleted', 0);
		                    $getExercisesID->where('therapist_id', 78);
		                    $getExercisesID->get_by_users_id($user_id);
		                    if ($getExercisesID->exists()) {
		                        foreach ($getExercisesID as $ge) {
		                            $exc_id = $ge->exercise_id;
		                            //get ever exercise detail
		                            $exersisedetail = new Exercise();
		                            $exersisedetail->get_by_id($exc_id);
		                            $exercises[] = $exersisedetail->show_result();
		                        }
		                    }

		                    $userdetail['exercise'] = $exercises;
*/
		                    
		                    
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
    
    public function emailchange() {
        
            //var_dump($_POST);
            $email = $_REQUEST['email'];
            $newemail = $_REQUEST['newemail'];
            $userid = $_REQUEST['userid'];
            if (!empty($_REQUEST)) {
                    $new_email = $_REQUEST['newemail'];
                    $userid = $_REQUEST['userid'];
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
            } else {
                $this->error("Not valid request");
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
                    $this->error("Invalid Old Password.");
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
    public function changemypassword() {
        if (!empty($_REQUEST)) {
                $userid = $_REQUEST['userid'];
                $old_password = $_REQUEST['old_password'];
                $new_password = $_REQUEST['new_password'];

                $this->db->select('*');
                $this->db->from('users');
                $this->db->where('password', (string)$old_password);
                $this->db->where('id', (int)$userid);

                $getEXVID = $this->db->get();
                if ($getEXVID->num_rows() > 0) {
                    //$data['newpassword'] = $new_password;
                    //$data['update_at'] = my_datenow();
                    //$data['oldpassword'] = (string)$old_password;
                    //$data['userid'] = (int)$userid;

                    $data = array(
                        'password' => $new_password,
                        'update_at' => my_datenow()
                     );
         
         $this->db->where('id', (int)$userid);
         $this->db->update('users', $data);


                    // $result = "111111";
                    // $this->load->model('Authentication'); $this->Authentication->update_password($data);

                    $dataresult['status'] = '1';
                    $dataresult['mytest'] = $getEXVID->num_rows();
                    $dataresult['msg'] = 'Password updated successfully';
                    echo json_encode($dataresult);
                    

                }else{
                    $dataresult['status'] = '0';
                    $dataresult['mytest'] = $getEXVID->num_rows();
                    $dataresult['msg'] = 'Invalid Old Password111';
                    echo json_encode($dataresult);
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
