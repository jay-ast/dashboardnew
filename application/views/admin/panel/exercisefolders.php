<?php

class Exercisefolders extends My_Controller {

    public function __construct() {
        parent::__construct();
         if($this->session->userdata('roleid')!=2)
        {
            
            //if($this->session->userdata('companyid')>0){redirect('/admin/therapist');}
            if($this->session->userdata('companyid')==0){redirect('/admin/companies');}
        }
    }

    
     public function generalroutinesfolder() {
   
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'General Routines Folders';
        $data['active_class'] = 'exercise';
        $data['isgeneral'] = true;
        
        

        //add all existing videos of therapist
        $getAllfolders = new Exercise_folder();
        if (!empty($_POST['folder_name'])) {
            $getAllfolders->like("folder_name", $_POST['folder_name']);
            $data['folder_name'] = $_POST['folder_name'];
        }
        $getAllfolders->where('folder_type', 0);
        $getAllfolders->where('company_id', $this->session->userdata('companyid'));
        $getAllfolders->order_by('folder_name', 'asc');
      
        $getAllfolders->get();
         foreach ($getAllfolders as $gtv) {
                 $folderdetail=$gtv->show_result();
                 $routinesinfolder= new Exercisefolder_exercise();
                 $routinesinfolder->where('exercisefolder_id', $gtv->id);
                 $folderdetail['routinecount']=$routinesinfolder->count(); 
                $data['general_folders'][] = $folderdetail;
            }
            ///echo "<pre>";
           /// print_r($data);exit;
         $this->load->view('admin/panel/exercise_general_folder', $data);
         
     }
     
    
     
     
     public function clientroutinesfolder() {
         
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Client Routines Folders';
        $data['active_class'] = 'exercise';
        $data['isgeneral'] = false;
        
       $getAllfolders = new Exercise_folder();
        if (!empty($_POST['folder_name'])) {
            $getAllfolders->like("folder_name", $_POST['folder_name']);
            $data['folder_name'] = $_POST['folder_name'];
        }
        $getAllfolders->where('folder_type', 1);
        $getAllfolders->where('client_id !=', 0);
        $getAllfolders->where('company_id', $this->session->userdata('companyid'));
        $getAllfolders->order_by('folder_name', 'asc');
        $getAllfolders->get();
        $folderdetail=$data['folder_remained']=array();
         foreach ($getAllfolders as $gtv) {
                 $folderdetail= $gtv->show_result();
                 $routinesinfolder= new Exercisefolder_exercise();
                 $routinesinfolder->where('exercisefolder_id', $gtv->id);
                 $folderdetail['routinecount']=$routinesinfolder->count();                 
                  $data['general_folders'][]=$folderdetail; 
                  $folderids[]=$folderdetail['id'];
            }
        
         $listPatients = new Patient();
       
        $listPatients->where('roles_id', 3);
        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->where('isdeleted', 0);

        $listPatients->get();
        foreach($listPatients as $Patients)
        {
            $patriendetail=$Patients->show_result(); 
             
            if(!in_array($patriendetail['id'], $folderdetail))
            {$data['folder_remained'][] = $patriendetail;}
        }
         
        

            ///echo "<pre>";
           /// print_r($data);exit;
         $this->load->view('admin/panel/exercise_general_folder', $data);
         
     }
     
     
     
   

  public function addgeneralfolder() {
        if (!empty($_POST)) {
            
          
              $name = $_POST['foldername'];  
              $folder= new Exercise_folder();
              $folder->company_id = $this->session->userdata('companyid');
              $folder->folder_name = $name;
              $folder->folder_type = 0;
              if($folder->save())
              {
                  my_alert_message("success", "Routine Folder added successfully");
                  redirect('admin/exercisefolders/generalroutinesfolder');
                  
              }else{my_alert_message("danger", "Oops, we apologize for this error. Please contact us at Tiziano@synergyptpilates.com for assistance.");}
              redirect('admin/exercisefolders/generalroutinesfolder');
           
        } else {
            my_alert_message("danger", "Oops, we apologize for this error. Please contact us at Tiziano@synergyptpilates.com for assistance.");
            redirect('admin/exercisefolders/generalroutinesfolder');
        }
    }

    public function addclientfolder() {
        if (!empty($_POST)) {
            
          
        $listPatients = new Patient();$listPatients->get_by_id($_POST['foldername']);
        if(!empty($listPatients))
        {
            $name = $listPatients->firstname.' '.$listPatients->lastname;
        } 
              $folder= new Exercise_folder();
              $folder->company_id = $this->session->userdata('companyid');
              $folder->folder_name = $name;
              $folder->folder_type = 1;
              $folder->client_id = $_POST['foldername'];
              if($folder->save())
              {
                  my_alert_message("success", "Routine Folder added successfully");
                  redirect('admin/exercisefolders/clientroutinesfolder');
                  
              }else{my_alert_message("danger", "Oops, we apologize for this error. Please contact us at Tiziano@synergyptpilates.com for assistance.");}
              redirect('admin/exercisefolders/clientroutinesfolder');
           
        } else {
            my_alert_message("danger", "Oops, we apologize for this error. Please contact us at Tiziano@synergyptpilates.com for assistance.");
            redirect('admin/exercisefolders/clientroutinesfolder');
        }
    }
    
    public function deletegeneralfolder($folderid = "") {
        //echo 11;exit;

        if (!empty($folderid)) {
            //delete patient
            $deletefolder = new Exercise_folder();
            $deletefolder->where('company_id', $this->session->userdata('companyid'));
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
    public function deleteclientfolder($folderid = "") {
        //echo 11;exit;

        if (!empty($folderid)) {
            //delete patient
            $deletefolder = new Exercise_folder();
            $deletefolder->where('company_id', $this->session->userdata('companyid'));
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
    
    
    public function detail($folderid='')
    {
        
       // echo ($this->uri->segment(4));exit;
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Public Routines Library';
        $data['active_class'] = 'exercise';
        $folder = new Exercise_folder();
            $folder->where('company_id', $this->session->userdata('companyid'));
            $folder->where('id', $folderid);
            $folder->get();
         if ($folder->exists()) {
              foreach ($folder as $gtv) {
                $data['folderdetails'] = $gtv->show_result();
            }
          }
          else {
                my_alert_message("danger", "Oops, we apologize for this error. Please contact us at Tiziano@synergyptpilates.com for assistance.");
                redirect($_SERVER['HTTP_REFERER']);
            }
          $data['isgeneral']=(isset($data['folderdetails']['folder_type'])&&$data['folderdetails']['folder_type']==0)?true:false;

        //add all existing videos of therapist
        
      
           
             $this->db->select('exercise.*,exercisefolder_exercise.insert_at as insertdate');
                $this->db->from('exercisefolder_exercise');
                $this->db->join('exercise', 'exercise.id=exercisefolder_exercise.exercise_id', 'left');
                $this->db->join('exercise_folder', 'exercise_folder.id=exercisefolder_exercise.exercisefolder_id', 'left');                
                $this->db->where('exercisefolder_exercise.company_id', $this->session->userdata('companyid'));
                $this->db->where('exercisefolder_exercise.exercisefolder_id', $folderid);
                if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
                $this->db->where("(exercise.name LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
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
         
      
        
      //  $data['totalresult']=$totalresult;
        $data['folderid']=$folderid;

       // $data['userdetailurl']='admin/patients/index/1/'.$data['folderdetails']['id'];

        //print_r($data);exit;
  
        $this->load->view('admin/panel/folder_routine_library', $data);
                  
        
    }

    
}
