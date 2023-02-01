<?php

class Folders extends My_Controller {

    public function __construct() {
        parent::__construct();
         if($this->session->userdata('roleid')!=2)
        {
            
            //if($this->session->userdata('companyid')>0){redirect('/admin/therapist');}
            if($this->session->userdata('companyid')==0){redirect('/admin/companies');}
        }
    }

    
     public function generalvideosfolder() {
         
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'General Videos Folders';
        $data['active_class'] = 'videos';
        $data['isgeneral'] = true;
        

        //add all existing videos of therapist
        $getAllfolders = new Company_video_folder();
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
                 $videoinfolder= new Company_video();
                 $videoinfolder->where('folder_id', $gtv->id);
                 $folderdetail['numberofvideo']=$videoinfolder->count(); 
                $data['general_folders'][] = $folderdetail;
            }
            ///echo "<pre>";
           /// print_r($data);exit;
         $this->load->view('admin/panel/general_folder', $data);
         
     }
     
     
     
     public function clientvideosfolder() {
         
        $data['global'] = MY_Controller::globalVariables();
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
        $getAllfolders->where('company_id', $this->session->userdata('companyid'));
        $getAllfolders->order_by('folder_name', 'asc');
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
         $this->load->view('admin/panel/general_folder', $data);
         
     }
     
     
     
   

  public function addgeneralfolder() {
        if (!empty($_POST)) {
            
          
              $name = $_POST['foldername'];  
              $folder= new Company_video_folder();
              $folder->company_id = $this->session->userdata('companyid');
              $folder->folder_name = $name;
              $folder->folder_type = 0;
              if($folder->save())
              {
                  my_alert_message("success", "Folder added successfully");
                  redirect('admin/folders/generalvideosfolder');
                  
              }else{my_alert_message("danger", "Opps there is some error please try again later");}
              redirect('admin/folders/generalvideosfolder');
           
        } else {
            my_alert_message("danger", "Opps there is some error please try again later");
            redirect('admin/folders/generalvideosfolder');
        }
    }

    public function addclientfolder() {
        if (!empty($_POST)) {
            
          
        $listPatients = new Patient();$listPatients->get_by_id($_POST['foldername']);
        if(!empty($listPatients))
        {
            $name = $listPatients->firstname.' '.$listPatients->lastname;
        } 
              $folder= new Company_video_folder();
              $folder->company_id = $this->session->userdata('companyid');
              $folder->folder_name = $name;
              $folder->folder_type = 1;
              $folder->client_id = $_POST['foldername'];
              if($folder->save())
              {
                  my_alert_message("success", "Folder added successfully");
                  redirect('admin/folders/clientvideosfolder');
                  
              }else{my_alert_message("danger", "Opps there is some error please try again later");}
              redirect('admin/folders/clientvideosfolder');
           
        } else {
            my_alert_message("danger", "Opps there is some error please try again later");
            redirect('admin/folders/clientvideosfolder');
        }
    }
    
    public function deletegeneralfolder($folderid = "") {
        //echo 11;exit;

        if (!empty($folderid)) {
            //delete patient
            $deletefolder = new Company_video_folder();
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
            $deletefolder = new Company_video_folder();
            $deletefolder->where('company_id', $this->session->userdata('companyid'));
            $deletefolder->where('id', $folderid); 
            $deletefolder->where('folder_type', 1);
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




    public function addgeneralfolderajax() {
        if (!empty($_POST)) {
            
          
             
              $name = $_POST['foldername'];  
              $folder= new Exercise_folder();
              $folder->company_id = $this->session->userdata('companyid');
              $folder->folder_name = $name;
              $folder->folder_type = 0;
              if($folder->save())
              {
                $response['folder_id']=$folder->id;
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
         my_alert_message("success", "Folder added successfully");
        exit;
    
  }
    
    
    public function detail($folderid='', $exerId='')
    {
        
       // echo ($this->uri->segment(4));exit;
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Public Video Library';
        $data['active_class'] = 'videos';
        $folder = new Company_video_folder();
            $folder->where('company_id', $this->session->userdata('companyid'));
            $folder->where('id', $folderid);
            $folder->get();
         if ($folder->exists()) {
              foreach ($folder as $gtv) {
                $data['folderdetails'] = $gtv->show_result();
            }
          }
          else {
                my_alert_message("danger", "Opps there is some error please try again later");
                redirect($_SERVER['HTTP_REFERER']);
            }
          $data['isgeneral']=(isset($data['folderdetails']['folder_type'])&&$data['folderdetails']['folder_type']==0)?true:false;

        //add all existing videos of therapist
        
         $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $this->session->userdata('companyid'));
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
            $per_page = 8;
            $data["links"] = $this->paginationInit("admin/folders/detail/".$folderid, $totalresult, $numlinks, $per_page, 5);
            if ($this->uri->segment(5)) {
               $page = ($this->uri->segment(5));
            } else {
                $page = 1;
            }

           
             $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $this->session->userdata('companyid'));
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
        
        $data['totalresult']=$totalresult;
        $data['folderid']=$folderid;
		$data['exerId']=$exerId;
       
        //echo "<pre>";
        //print_r($data);exit;
        $this->load->view('admin/panel/folder_videos_library', $data);
        /*
            $folder = new Company_video_folder();
            $folder->where('company_id', $this->session->userdata('companyid'));
            $folder->where('id', $folderid);
            $folder->get();
            if ($folder->exists()) {
                
                
                
                my_alert_message("danger", "Opps there is some error please try again later");
                redirect('admin/folders/clientvideosfolder');
            } else {
                my_alert_message("danger", "Opps there is some error please try again later");
                redirect('admin/folders/clientvideosfolder');
            } */
            
        
    }

    
}
