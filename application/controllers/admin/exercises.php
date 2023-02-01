<?php

class Exercises extends My_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Exercises';
        $data['active_class'] = 'exercise';
        if (!empty($_POST)) {
            if (!empty($_POST['exercise_name']))
                $data['exercise_name'] = $exercise_name = $_POST['exercise_name'];
        }
        //count all patients here role id= 3
        $listExercises = new Exercise();
        if (!empty($exercise_name)) {
            $listExercises->group_start();
            $listExercises->or_like('name', $exercise_name);
            $listExercises->group_end();
        }

       
        $listExercises->where('company_id', $data['global']['companyid']);
        
       
        $listExercises->where('isdeleted', 0);
        $listExercises->get();
        //paginition
        $totalresult = $listExercises->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/exercises/index", $totalresult, $numlinks, $per_page);
        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        //count all exercises for this therapist
        $listExercises = new Exercise();
        if (!empty($exercise_name)) {
            $listExercises->group_start();
            $listExercises->or_like('name', $exercise_name);
            $listExercises->group_end();
        }
  
        $listExercises->where('company_id', $data['global']['companyid']);
        $listExercises->where('isdeleted', 0);
        $listExercises->order_by('name', 'ASC');
        $listExercises->limit($per_page, (($page - 1) * $per_page));
        $listExercises->get();

        foreach ($listExercises as $lip) {
            $data['exerciselist'][] = $lip->show_result();
        }
        //add all existing videos of therapist
        $getAllVideos = new Video();
        $getAllVideos->where('ispublic', 0);
        $getAllVideos->where('company_id', $this->session->userdata('companyid'));               
        $getAllVideos->where('isdeleted', 0);
        $getAllVideos->get();
        if ($getAllVideos->exists()) {
            foreach ($getAllVideos as $gtv) {
                $data['exercise_videos'][] = $gtv->show_result();
            }
        }
        
                $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $this->session->userdata('companyid'));
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video.isdeleted', 0);
                $getEXVID = $this->db->get();
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp = array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name,
                            'thumbnail'=>$geVID->thumbnail,
                            'test'=>'333333'
                                
                        );
                        $data['exercise_videos'][] = $temp;
                    }
                }
         
        $this->load->view('admin/panel/exercises', $data);
    }
    
    
    
    public function addgeneralexercise($routineId = "")
    {
        
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Exercises';
        $data['active_class'] = 'exercise';
        $data['isgeneral']=true;
        $data['clientid'] =0;
        if (!empty($_POST)) {
            if (!empty($_POST['exercise_name']))
                $data['exercise_name'] = $exercise_name = $_POST['exercise_name'];
        }
        //count all patients here role id= 3
        $listExercises = new Exercise();
        if (!empty($exercise_name)) {
            $listExercises->group_start();
            $listExercises->or_like('name', $exercise_name);
            $listExercises->group_end();
        }

       
        $listExercises->where('company_id', $data['global']['companyid']); 
        $listExercises->where('isdeleted', 0);
        $listExercises->get();
        //paginition
        $totalresult = $listExercises->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/exercises/index", $totalresult, $numlinks, $per_page);
        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }

        $getAllfolders = new Exercise_folder();        
        $getAllfolders->where('folder_type !=', 0);
        $getAllfolders->where('company_id', $this->session->userdata('companyid'));
        $getAllfolders->order_by('folder_name', 'asc');
        $getAllfolders->get();
        
         foreach ($getAllfolders as $gtv) {
                $data['cleint_folders'][]=$gtv->show_result(); 
                 
            }
       
        //add all existing videos of therapist
         $getAllfolders = new Exercise_folder();        
		 $getAllfolders->where('folder_type', 0);
		 $getAllfolders->where('company_id', $this->session->userdata('companyid'));
		 $getAllfolders->order_by('folder_name', 'asc');
		 $getAllfolders->get();
         foreach ($getAllfolders as $gtv) {
                $data['general_folders'][] = $gtv->show_result();
         }
        

                $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $this->session->userdata('companyid'));
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video_folder.folder_type', 0);
                $this->db->where('company_video.folder_id !=', 0);
                $getEXVID = $this->db->get();
               //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp[$geVID->foldername][]= array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name, 
                            'thumbnail'=>$geVID->thumbnail ,
                            'test'=>'4444444'     
                        );
                    }
                    $data['general_videos'] = $temp;
                }
                
               $data['assginedfolder'] = [$routineId];  
               
            $this->db->select('videos.*');
            $this->db->from('videos');
            $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
            $this->db->where('company_video.company_id', $this->session->userdata('companyid'));                
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
          $data["adding"] = true;

          $data["path"] = "/admin/exercises/addgeneralexercise/";
          
        $this->load->view('admin/panel/editexercises', $data);
        
    }
     public function addclientexercise($clientid)
    {
         
        
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Exercises';
        $data['active_class'] = 'exercise';
        $data['isgeneral']=false;
        $data['client_id'] = $clientid;     
        $this->load->library('user_agent');
    

        if (!empty($_POST)) {
            if (!empty($_POST['exercise_name']))
                $data['exercise_name'] = $exercise_name = $_POST['exercise_name'];
        }
        //count all patients here role id= 3
        $listExercises = new Exercise();
        if (!empty($exercise_name)) {
            $listExercises->group_start();
            $listExercises->or_like('name', $exercise_name);
            $listExercises->group_end();
        }

       
        $listExercises->where('company_id', $data['global']['companyid']); 
        $listExercises->where('isdeleted', 0);
        $listExercises->get();
        //paginition
        $totalresult = $listExercises->result_count();
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/exercises/index", $totalresult, $numlinks, $per_page);
        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 1;
        }
        
        
        $getAllfolders = new Exercise_folder();
        // $getAllfolders->where('client_id =', $clientid);
        $getAllfolders->where('company_id', $this->session->userdata('companyid'));
        $getAllfolders->order_by('folder_name', 'asc');
        $getAllfolders->get();
        
         foreach ($getAllfolders as $gtv) {
                $data['cleint_folders'][]=$gtv->show_result(); 
                 
            }
            
        //add all existing videos of therapist
         $getAllfolders = new Exercise_folder();        
        $getAllfolders->where('folder_type', 0);
        $getAllfolders->where('company_id', $this->session->userdata('companyid'));
        $getAllfolders->order_by("folder_name", 'asc');
        $getAllfolders->get();
         foreach ($getAllfolders as $gtv) {
                $data['general_folders'][] = $gtv->show_result();
            }
       
        //add all existing videos of therapist
        
        
                $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $this->session->userdata('companyid'));
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video_folder.folder_type', 0);
                $this->db->where('company_video.folder_id !=', 0);
                $this->db->order_by("videos.title", 'asc');
                $getEXVID = $this->db->get();
               //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        
                        $temp[$geVID->foldername][]= array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name,
                            'thumbnail'=>$geVID->thumbnail,
                            'test'=>'111111'
                                
                        );
                        
                    }$data['general_videos'] = $temp;
                }
                
                
               
                $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $this->session->userdata('companyid'));
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('company_video_folder.folder_type', 1);
                $this->db->where('company_video_folder.client_id =', $clientid);
                $this->db->order_by("videos.title", 'asc');
                $getEXVID = $this->db->get();
              //echo $this->db->last_query();exit;
                if ($getEXVID->num_rows() > 0) {
                    $temp=  array();
                    foreach ($getEXVID->result() as $geVID) {
                        $temp[$geVID->foldername][]= array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name,
                            'thumbnail'=>$geVID->thumbnail,
                            'test'=>'222222'
                            
                                
                        );
                        
                    }$data['client_videos'] = $temp;
                }
                
               $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $this->session->userdata('companyid'));                
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

            if ($this->agent->is_referral()&&(strpos($this->agent->referrer(), 'admin/patients') !== false)) {

                $data['isfrom']=$this->agent->referrer();} else{
                     $data['isfrom']='';
                }  

 $data["adding"] = true;
 
$data['assginedfolder'][] =  $data['cleint_folders'][0]["id"];
 
    		$folderId = $data['cleint_folders'][0]["id"];
    		  $sqlVideoFolder = "select A.id as folderId, B.id as companyVideoFolderId from exercise_folder as A
left outer join company_video_folder as B on A.client_id=B.client_id
where A.id=".$folderId;

$comVidId = $this->db->query( $sqlVideoFolder)->result();
$data['companyVideoFolderId']=$comVidId[0]->companyVideoFolderId;;
          $data["path"] = "/admin/exercises/addclientexercise/".$clientid;

        $this->load->view('admin/panel/editexercises', $data);
        
    }
   
	

    public function addNewExercise() {
        
        // print_r($_POST);exit;
        if ($_POST['btnSaveGeneralRoutineText'] == 1) {
            $_POST['clientfolderid'] = [];
        }
        $data['page_title'] = 'Add Exercises';
        $data['active_class'] = 'exercise';
      // print_r($_POST);exit;
         $videoids=  explode(',', $_POST['videoids']);
         //print_r($videoids);exit;
        if (!empty($_POST)) {
         
            
            $exc_name = $_POST['name'];
            $descrip = $_POST['description'];
            
      
           // $Exercisefolder_exercise= new Exercisefolder_exercise();
            
                    $addEx = new Exercise();
                    $addEx->name = $exc_name;
                    $addEx->description = $descrip;
                    $addEx->therapist_id = $this->session->userdata('userid');
                    $addEx->company_id =$this->session->userdata('companyid');  
                    if ($addEx->save()) {

                        $ex_id = $addEx->id;
                        //add ex videos
                        $videoids=  explode(',', $_POST['videoids']);

                        foreach ($videoids as $key => $val) {
                            $addEXVID = new Exercise_videos();
                            $addEXVID->videos_id = $val;
                            $addEXVID->exercise_id = $ex_id;
                            $addEXVID->company_id =$this->session->userdata('companyid');                   
                            $addEXVID->order =$key+1;
                            $addEXVID->save();
                            //echo  $this->db->last_query();exit;

                        }
                        // $generalfolderid=$_POST['generalfolderid'];
                        // $generalfolderid = explode(',', $_POST['generalfolderid']);
                        
                        if($_POST['generalfolderid']){
                            $generalfolderid = explode(',', $_POST['generalfolderid']);
                        }else{
                            $generalfolderid=$_POST['generalfolderid'];
                        }
                
                        // var_dump('abc',$generalfolderid);die;
                        

                        foreach ($generalfolderid as $folderid) {
                                    $Exercisefolder_exercise= new Exercisefolder_exercise();
                                    $Exercisefolder_exercise->exercise_id=$ex_id;
                                    $Exercisefolder_exercise->exercisefolder_id=$folderid;
                                    $Exercisefolder_exercise->company_id=$this->session->userdata('companyid');
                                    // var_dump('abc', $folderid);die;
                                    $Exercisefolder_exercise->save();
                                    $clinet_id=$folderid;

                           // echo  $this->db->last_query();exit;
                        }

                        $users=array();
                        $exercisesuser= new Users_exercise();
                        $exercisesuser->where('exercise_id', $ex_id);
                        $exercisesuser->get();
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
                                        my_iphone_push_notification($userspushtokens, 'You have new routine '.$exc_name,$ext_params);
                                    }
                                }


                                $usersdetial= new User();
                                $usersdetial->where_in('id', $users);
                                $usersdetial->get();

                                foreach ($usersdetial as $udetail)
                                {
                                    $userdetail=$udetail->show_result();
                                    $sendMailStatus = my_email_send($userdetail['email'], "You have new routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                                }



                            }
                        }
                    }
         
                $clientfolderid=$_POST['clientfolderid'];
                foreach ($clientfolderid as $folderid) {
                        $addEx = new Exercise();
                        $addEx->name = $exc_name;
                        $addEx->description = $descrip;
                        $addEx->therapist_id = $this->session->userdata('userid');
                        $addEx->company_id =$this->session->userdata('companyid');  

                        if ($addEx->save()) {

                            $ex_id = $addEx->id;
                            //add ex videos
                            $videoids=  explode(',', $_POST['videoids']);

                            foreach ($videoids as $key => $val) {
                                $addEXVID = new Exercise_videos();
                                $addEXVID->videos_id = $val;
                                $addEXVID->exercise_id = $ex_id;
                                $addEXVID->company_id =$this->session->userdata('companyid');                   
                                $addEXVID->order =$key+1;
                                $addEXVID->save();
                                //echo  $this->db->last_query();exit;

                            }
                            $clinet_id=$folderid;
                            $Exercisefolder_exercise= new Exercisefolder_exercise();
                            $Exercisefolder_exercise->exercise_id=$ex_id;
                            $Exercisefolder_exercise->exercisefolder_id=$folderid;
                            $Exercisefolder_exercise->company_id=$this->session->userdata('companyid');
                            $Exercisefolder_exercise->save();
                            
                            $getfoldersdetail = new Exercise_folder();
                            $folderdetail=$getfoldersdetail->get_by_id($clinet_id);
                            if($getfoldersdetail->exists())
                            {$updateExer = new Users_exercise();
                                $updateExer->users_id = $folderdetail->client_id;
                                $updateExer->exercise_id = $ex_id;
                                $updateExer->save(); }

                        }
                    //echo  $this->db->last_query();exit;


                    $users=array();
                    $exercisesuser= new Users_exercise();
                    $exercisesuser->where('exercise_id', $ex_id);
                    $exercisesuser->get();
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
                                    my_iphone_push_notification($userspushtokens, 'You have new routine '.$exc_name,$ext_params);
                                }
                            }


                            $usersdetial= new User();
                            $usersdetial->where_in('id', $users);
                            $usersdetial->get();


                            foreach ($usersdetial as $udetail)
                            {

                                $userdetail=$udetail->show_result();
                          
                                $sendMailStatus = my_email_send($userdetail['email'], "You have new routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                            }



                        }
                    }
                }
                
             // echo  $this->db->last_query();exit;





                my_alert_message("success", "New Routine Added Successfully");
                if ((strpos($_POST['isfrom'], 'admin/patients') !== false)) {
                    if((strpos($_POST['isfrom'], 'admin/patients/index') !== false))
                    {
//                        redirect($_POST['isfrom'].'/'.$_POST['clientid']);
                         header('Location: '.$_POST['isfrom'].'/'.$_POST['clientid']);
                    }else{
	                    header('Location: /admin/patients/index/1/'.$_POST['clientid']);
                        //redirect('admin/patients/index/1/'.$_POST['clientid']);
                    }
                    
                $data['isfrom']=$this->agent->referrer();} 
                if($_POST['isfrom']=='admin/patients')
                {
                    
                }else{
	                
	            redirect('admin/exercisefolders/detail/'.$clinet_id);
	                //header('Location: /admin/exercisefolders/detail/'.$clinet_id);
	               }
            
            
        }
         else {
                my_alert_message("danger", "Error Routine adding new Client");
                //redirect('admin/exercises');
                header('Location: /admin/exercises');
            }
    }

    public function UpdateExercise() {

        //print_r($_POST);exit;
        
        if ($_POST['btnSaveGeneralRoutineText'] == 1) {
            $_POST['clientfolderid'] = [];
        }
        
        $data['page_title'] = 'Edit Exercises';
        $data['active_class'] = 'exercise';
        $origin = $this->input->post("origin");
                $patient_id = $this->input->post("patient_id");
        
        // TODO: this has an issue when updating a routine. Need to check 	
            $this->form_validation->set_rules('exerciseid', "Routine ID", "required");

            if ($this->form_validation->run() == FALSE) {
                my_alert_message("danger", "2.) Please provide valid data");
                redirect('admin/patients');
            }

            $exer_id = default_value($this->input->post("exerciseid"));
          
           
            $updateExercise = new Exercise();
            $updateExercise->get_by_id($exer_id);
            if ($updateExercise->exists()) {           
                
              
                $updateExercise->name = default_value($this->input->post("name"), "");
                $updateExercise->description = default_value($this->input->post("description"), "");
                $updateExercise->update_at = my_datenow();
                $result = $updateExercise->save();
                
/*
                print("<pre>".print_r($result,true)."</pre>");
                  echo $this->input->post("name");
                echo "<br/>";
                 echo $exer_id;
*/
           
                if ($updateExercise->save()) {
/*
	                echo "SAVED";
	                die;
*/

                    $videos=array();
                    //delete all videos from Exercise_videos where this $exer_id
                    $deleteAllExercise = new Exercise_videos();
                    $deleteAllExercise->where('exercise_id', $exer_id);
                    $deleteAllExercise->get();
                    if ($deleteAllExercise->exists()) {
                        foreach ($deleteAllExercise as $vids)
                        {
                            $foldetail=$vids->show_result();
                            $videos[]=$foldetail['videos_id'];
                        }
                        $deleteAllExercise->delete_all();
                    }

                    //add  new videos to exercise videos 
                     $ex_id = $addEx->id;
                   //add ex videos
                    $videoids=  explode(',', $_POST['videoids']);
                     $sendnotification=false;
                    foreach ($videoids as $key => $val) {
                        if(!empty($videos)&&!(in_array($val, $videos)))
                        {  
	                        //$sendnotification=true;
                        }
                        if($val != ""){
	                          $addEXVID = new Exercise_videos();
                        $addEXVID->videos_id = $val;
                        $addEXVID->exercise_id = $exer_id;
                        $addEXVID->company_id =$this->session->userdata('companyid');                   
                        $addEXVID->order =$key+1;
                        $addEXVID->save();

                        }
                      
                    }
                    
                    $deleteExercisefolder_exercise = new Exercisefolder_exercise();
                    $deleteExercisefolder_exercise->where('exercise_id', $exer_id);
                    $deleteExercisefolder_exercise->get();
                    if ($deleteExercisefolder_exercise->exists()) {
                        $deleteExercisefolder_exercise->delete_all();
                    }
                    
                    
                    //  $generalfolderid = explode(',', $_POST['generalfolderid']);
                    if($_POST['generalfolderid']){
                        $generalfolderid = explode(',', $_POST['generalfolderid']);
                    }else{
                        $generalfolderid=$_POST['generalfolderid'];
                    }
                    // $generalfolderid=$_POST['generalfolderid'];  
                    foreach ($generalfolderid as $folderid) {
                        $clinet_id=$folderid;
                       $Exercisefolder_exercise= new Exercisefolder_exercise();
                       $Exercisefolder_exercise->exercise_id=$exer_id;
                       $Exercisefolder_exercise->exercisefolder_id=$folderid;
                       $Exercisefolder_exercise->company_id=$this->session->userdata('companyid');
                       $Exercisefolder_exercise->save();
                      // echo  $this->db->last_query();exit;
                   }
                    $clientfolderid=$_POST['clientfolderid'];
                    $myfolderid = 0;
                    foreach ($clientfolderid as $folderid) {
                        $myfolderid = $folderid;
                        $clinet_id=$folderid;
                        $Exercisefolder_exercise= new Exercisefolder_exercise();
                        $Exercisefolder_exercise->exercise_id=$exer_id;
                        $Exercisefolder_exercise->exercisefolder_id=$folderid;
                        $Exercisefolder_exercise->company_id=$this->session->userdata('companyid');
                        $Exercisefolder_exercise->save();
                        
                           $getfoldersdetail = new Exercise_folder();
                           $folderdetail=$getfoldersdetail->get_by_id($folderid);
                            if($getfoldersdetail->exists())
                            {
                                
                                $exercisesuser= new Users_exercise();
                                $exercisesuser->where('exercise_id', $exer_id);
                                $exercisesuser->where('users_id', $folderdetail->client_id);
                                $exercisesuser->get();
                                if (!$exercisesuser->exists()) {
                                    $updateExer = new Users_exercise();
                                    $updateExer->users_id = $folderdetail->client_id;
                                    $updateExer->exercise_id = $exer_id;
                                    $updateExer->save();

                                }
                                
                            }
                                                                           
                        //echo  $this->db->last_query();exit;
                    }
                    //echo $sendnotification;exit;
                   if($sendnotification)
                    {

                        $users=array();
                        $exercisesuser= new Users_exercise();
                        $exercisesuser->where('exercise_id', $exer_id);
                        $exercisesuser->get();
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
                                    $ext_params['exerciseid']=$exer_id;
                                    my_iphone_push_notification($userspushtokens, 'You have new video in routine '.$updateExercise->name,$ext_params);
                                }
                            }


                                $usersdetial= new User();
                                $usersdetial->where_in('id', $users);
                                $userdata=$usersdetial->get();

                            foreach ($usersdetial as $udetail)
                            {
                                $userdetail=$udetail->show_result();
                                $sendMailStatus = my_email_send($userdetail['email'], "You have new video in routine", "newexercise", $userdetail, 'support@perfect-forms.net');
                            }
                      }
                    }
                    
                 }
                    my_alert_message("success", "Routine details updated successfully");
//                      redirect('admin/patients/index/1/'.$patient_id);  
                      header('Location: /admin/patients/index/1/'.$patient_id);
/*
                    if($origin == 'client'){
	                                    redirect('admin/patients/index/1/'.$patient_id);    
                    }else{
                  	  redirect('admin/exercisefolders/detail/'.$clinet_id);	                    
                    }
*/

                } else {
                    my_alert_message("danger", "Error in updating Routine details");
                    redirect('admin/exercises');
                }
            } else {
                my_alert_message("danger", "Invalid Routine ID");
                redirect('admin/exercises');
            }
        
    }

    public function addNewVideoForExercise() {
        if (!empty($_POST)) {
            $exercise_id = $_POST['id'];
            $name = $_POST['name'];
            $title = $_POST['title'];
            $order = $_POST['order'];
            $addNewVideo = new Video();
            $addNewVideo->title = $title;
            $addNewVideo->name = $name;
            $addNewVideo->order = $order;
            $addNewVideo->exercise_id = $exercise_id;
            if ($addNewVideo->save()) {
                echo json_encode(array('status' => true, 'data' => array('id' => $addNewVideo->id)));
            } else {
                echo json_encode(array('status' => false));
            }
        } else {
            echo json_encode(array('status' => false));
        }
    }

    public function deleteExerciseVideo($video_id = "") {
        if (!empty($video_id)) {
            $Video = new Video();
            $Video->get_by_id($video_id);
            if ($Video->exists()) {
                $Video->isdeleted = 1;
                $Video->delete_at = my_datenow();
                if ($Video->save()) {
                    echo json_encode(array('status' => true));
                } else {
                    echo json_encode(array('status' => false));
                }
            } else {
                echo json_encode(array('status' => false));
            }
        } else {
            echo json_encode(array('status' => false));
        }
    }
    

    public function detail($exercise_id = "", $patiend_id = "") {
        $data['page_title'] = 'Edit Exercises';
        $data['active_class'] = 'exercise';
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
                //echo $this->db->last_query();exit;
                //$getEXVID->num_rows()
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
                        
                        $data['assginedfolder'][] = $getFOLDER->id;
                        if($getFOLDER->client_id>0){
                            $client_id=$getFOLDER->client_id;
                        }
                    }
                                   
                   
                }
                
                
               
                
                $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $this->session->userdata('companyid'));
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
                            'thumbnail' => $geVID->thumbnail,
                            'test'=>'77777'
                                
                        );
                        
                    }ksort($temp);
                    $data['general_videos'] =$temp ;
                }
                
                //print_r($data['general_videos']);exit;
                $data['client_videos']=array();
                $data['isgeneral']=true;
                $data['exercise_id']=$exercise_id;
                $data['companyId'] = $this->session->userdata('companyid');
                $data['client_id'] = $client_id;
				$data['patiend_id'] = $patiend_id;

               if($client_id>0)
               {
                $data['isgeneral']=false;
                $this->db->select('videos.*,company_video_folder.folder_name as foldername');
                $this->db->from('company_video_folder');
                $this->db->join('company_video', 'company_video.folder_id=company_video_folder.id', 'left');
                $this->db->join('videos', 'videos.id=company_video.video_id', 'left');
                $this->db->where('company_video_folder.company_id', $this->session->userdata('companyid'));
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
               $getAllfolders->where('company_id', $this->session->userdata('companyid'));
               $getAllfolders->order_by('folder_name', 'ASC');
               $getAllfolders->get();
        
                foreach ($getAllfolders as $gtv) {
                       $data['cleint_folders'][]=$gtv->show_result(); 

                   }
                   
               }else{
                $data['cleint_folders']=$data['general_folders']=array();
                $getAllfolders = new Exercise_folder(); 
                $getAllfolders->where('folder_type !=', 0);
                $getAllfolders->where('company_id', $this->session->userdata('companyid'));
                $getAllfolders->order_by('folder_name', 'ASC');
                $getAllfolders->get();

                 foreach ($getAllfolders as $gtv) {
                        $data['cleint_folders'][]=$gtv->show_result(); 

                    }
                   
               }
            
               $getAllfolders = new Exercise_folder();        
               $getAllfolders->where('folder_type', 0);
               $getAllfolders->where('company_id', $this->session->userdata('companyid'));
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
                $this->db->where('company_video.company_id', $this->session->userdata('companyid'));                
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
                
//                    		$folderId = $data['cleint_folders'][0]["id"];
    		  $sqlVideoFolder = "select id as companyVideoFolderId from company_video_folder where client_id=".$client_id;
// echo $sqlVideoFolder;
$comVidId = $this->db->query( $sqlVideoFolder)->result();
$data['companyVideoFolderId']=$comVidId[0]->companyVideoFolderId;;
/*
echo $data['companyVideoFolderId'];
echo "9:47 PM";
die;
*/
               //echo "<pre>";
               //print_r($data);
               
            //   exit;
               $data["adding"] = false;
               $data["path"] = "/admin/exercises/detail/".$exercise_id."/".$patiend_id;
               
                 $this->load->view('admin/panel/editexercises', $data);
                
               // echo json_encode(array('status' => true, 'data' => $data));
            } else {
                echo json_encode(array('status' => false, 'message' => "Routine details not available"));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => "1.) Please provide valid data."));
        }
    }
    
    
    
    public function deleteExrecisebyFolder($exer_id = "")
    {
        
        //print_r($_POST);exit;
        if (!empty($exer_id)&&!empty($_POST['folderid'])) {
            
               
            //delete patient
            $deleteExercise = new Exercise();
            $deleteExercise->get_by_id($exer_id);
            if ($deleteExercise->exists()) {
               $getExercisefolder_exercise = new Exercisefolder_exercise();        
               $getExercisefolder_exercise->where('exercisefolder_id', $_POST['folderid']);
               $getExercisefolder_exercise->where('company_id', $this->session->userdata('companyid'));
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

    public function deleteExercise($exer_id = "") {

        if (!empty($exer_id)) {
            //delete patient
            $deleteExercise = new Exercise();
            $deleteExercise->get_by_id($exer_id);
            if ($deleteExercise->exists()) {
                $deleteExercise->isdeleted = 1;
                $deleteExercise->delete_at = my_datenow();
                if ($deleteExercise->save()) {
                    //delete asigned exercies to patients
                    $updateExer = new Users_exercise();
                    $updateExer->get_by_exercise_id($exer_id);
                    foreach ($updateExer as $uexxer) {
                        $uexxer->isdeleted = 1;
                        $uexxer->delete_at = my_datenow();
                        $uexxer->save();
                    }

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

    public function Pluploader() {
        //print_r($_REQUEST);exit;
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
        $jsondata['originalname']=(isset($_REQUEST["name"]))? preg_replace('/\\.[^.\\s]{3,4}$/', '', $_REQUEST["name"]):'';

        echo json_encode($jsondata);
    }

}
