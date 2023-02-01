<?php

class Videos extends My_Controller {

    public function __construct() {
        parent::__construct();
         if($this->session->userdata('roleid')!=2)
        {
            
            //if($this->session->userdata('companyid')>0){redirect('/admin/therapist');}
            if($this->session->userdata('companyid')==0){redirect('/admin/companies');}
        }
    }

    
     public function generalvideos() {
         $this->load->view('admin/panel/general_folder', $data);
         
     }
     
     
     
    public function index() {
       
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Videos Library';
        $data['active_class'] = 'videos';
/*
        //add all existing videos of therapist
        $getAllVideos = new Video();
        if (!empty($_POST['video_name'])) {
            $getAllVideos->like("title", $_POST['video_name']);
            $data['video_name'] = $_POST['video_name'];
        }
        $getAllVideos->where('ispublic', 0);
        $getAllVideos->where('company_id', $this->session->userdata('companyid'));
        $getAllVideos->where("isdeleted", 0);
        $getAllVideos->get();
        $data['exercise_videos'] = array();
        $totalresult=0;
        if ($getAllVideos->exists()) {
            //paginition
            $totalresult = $getAllVideos->result_count();
            $numlinks = 3;
            $per_page = 8;
            $data["links"] = $this->paginationInit("admin/videos/index", $totalresult, $numlinks, $per_page, 4);
            if ($this->uri->segment(4)) {
                $page = ($this->uri->segment(4));
            } else {
                $page = 1;
            }

            $getAllVideos = new Video();
            if (!empty($_POST['video_name'])) {
                $getAllVideos->like("title", $_POST['video_name']);
                $data['video_name'] = $_POST['video_name'];
            }
            $getAllVideos->where('ispublic', 0);
            $getAllVideos->where('company_id', $this->session->userdata('companyid'));
            $getAllVideos->where("isdeleted", 0);
            if (empty($_POST['video_name']))
                $getAllVideos->limit($per_page, (($page - 1) * $per_page));
            $getAllVideos->get();
            foreach ($getAllVideos as $gtv) {
                $data['exercise_videos'][] = $gtv->show_result();
            }
            
        } */
        $data['totalresult']=$totalresult;
        $data['ispublic']=false;
        $this->load->view('admin/panel/videos_library', $data);
    }
    public function indexx() {
       
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Videos Library';
        $data['active_class'] = 'videos';

        //add all existing videos of therapist
        $getAllVideos = new Video();
        if (!empty($_POST['video_name'])) {
            $getAllVideos->like("title", $_POST['video_name']);
            $data['video_name'] = $_POST['video_name'];
        }
        $getAllVideos->where('ispublic', 0);
        $getAllVideos->where('company_id', $this->session->userdata('companyid'));
        $getAllVideos->where("isdeleted", 0);
        $getAllVideos->get();
        $data['exercise_videos'] = array();
        $totalresult=0;
        if ($getAllVideos->exists()) {
            //paginition
            $totalresult = $getAllVideos->result_count();
            $numlinks = 3;
            $per_page = 8;
            $data["links"] = $this->paginationInit("admin/videos/index", $totalresult, $numlinks, $per_page, 4);
            if ($this->uri->segment(4)) {
                $page = ($this->uri->segment(4));
            } else {
                $page = 1;
            }

            $getAllVideos = new Video();
            if (!empty($_POST['video_name'])) {
                $getAllVideos->like("title", $_POST['video_name']);
                $data['video_name'] = $_POST['video_name'];
            }
            $getAllVideos->where('ispublic', 0);
            $getAllVideos->where('company_id', $this->session->userdata('companyid'));
            $getAllVideos->where("isdeleted", 0);
            if (empty($_POST['video_name']))
                $getAllVideos->limit($per_page, (($page - 1) * $per_page));
            $getAllVideos->get();
            foreach ($getAllVideos as $gtv) {
                $data['exercise_videos'][] = $gtv->show_result();
            }
            
        }
        $data['totalresult']=$totalresult;
        $data['ispublic']=false;
        $this->load->view('admin/panel/videos_library', $data);
    }
    

     public function publicvideo() {
       
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Public Video Library';
        $data['active_class'] = 'videos';

        //add all existing videos of therapist
        
         $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $this->session->userdata('companyid'));
                if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
                $this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
                
                
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('videos.ispublic', 1);
                $this->db->where('company_video.isdeleted', 0);
                $getEXVID = $this->db->get();
        $data['exercise_videos'] = array();
        $totalresult =0;
        if ($getEXVID->num_rows() > 0) {
            //paginition
            $totalresult = $getEXVID->num_rows();
            $numlinks = 3;
            $per_page = 8;
            $data["links"] = $this->paginationInit("admin/videos/publicvideo", $totalresult, $numlinks, $per_page, 4);
            if ($this->uri->segment(4)) {
                $page = ($this->uri->segment(4));
            } else {
                $page = 1;
            }

           
             $this->db->select('videos.*');
                $this->db->from('videos');
                $this->db->join('company_video', 'company_video.video_id=videos.id', 'left');
                $this->db->where('company_video.company_id', $this->session->userdata('companyid'));
                if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
                $this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
                $this->db->where('videos.isdeleted', 0);
               $this->db->where('videos.ispublic', 1);
                
                $this->db->where('company_video.isdeleted', 0);
                $this->db->order_by('videos.id', 'desc');
                $getEXVID = $this->db->get();
                if ($getEXVID->num_rows() > 0) {
                    foreach ($getEXVID->result() as $geVID) {
                        $temp = array(
                            'id' => $geVID->id,
                            'title' => $geVID->title,                           
                            'name' => $geVID->name
                        );
                        $data['exercise_videos'][] = $temp;
                    }
                }
         
        }
        $data['totalresult']=$totalresult;
        $data['ispublic']=true;
        $this->load->view('admin/panel/videos_library', $data);
    }
   
 /* public function publicvideo() {
       
        $data['global'] = MY_Controller::globalVariables();
        $data['page_title'] = 'Public Video Library';
        $data['active_class'] = 'videos';

        //add all existing videos of therapist
        
         $this->db->select('videos.*');
             $this->db->from('videos'); 
             if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
                $this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
                
                $this->db->where('videos.isdeleted', 0);
                $this->db->where('videos.ispublic', 1);
                $getEXVID = $this->db->get();
        $data['exercise_videos'] = array();
        $totalresult =0;
        if ($getEXVID->num_rows() > 0) {
            //paginition
            $totalresult = $getEXVID->num_rows();
            $numlinks = 3;
            $per_page = 8;
            $data["links"] = $this->paginationInit("admin/videos/publicvideo", $totalresult, $numlinks, $per_page, 4);
            if ($this->uri->segment(4)) {
                $page = ($this->uri->segment(4));
            } else {
                $page = 1;
            }

           
             $this->db->select('videos.*');
             $this->db->from('videos'); 
             if (!empty($_POST['video_name'])) {
                $data['video_name'] = $_POST['video_name'];
                $this->db->where("(videos.title LIKE  '%".$data['video_name']."%') AND 1=",1);
               }
             $this->db->where('videos.isdeleted', 0);
             $this->db->where('videos.ispublic', 1);
                $this->db->order_by('videos.title', 'asc');
                $getEXVID = $this->db->get();
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
        $data['ispublic']=true;
        $this->load->view('admin/panel/videos_library', $data);
    }
   */
    public function addNewVideo() {
        if (!empty($_POST)) {
            ///print_r($_POST);exit;
            $done=false;
            foreach($_POST['name'] as $i=>$data)
            {
                $name = $data['value'];
                 $title =  $_POST['title'][$i]['value'];

            $addNewVideo = new Video();
            $addNewVideo->title = $title;
            $addNewVideo->name = $name;

            $thumbnail = $this->live_ffmpeg($name);
            $addNewVideo->thumbnail = $thumbnail;
            $addNewVideo->therapist_id = $this->session->userdata('userid');
            $addNewVideo->company_id = $this->session->userdata('companyid');
            $addNewVideo->folder_id = $_POST['folderid']; 
            $addNewVideo->ispublic = 0; 
            $addNewVideo->save();
            
            $companyvideo = new Company_video();
            $companyvideo->video_id=$addNewVideo->id;
            $companyvideo->company_id = $this->session->userdata('companyid');
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

    public function deleteVideo($video_id = "") {
        if (!empty($video_id)) {
            $Video = new Video();
            $Video->get_by_id($video_id);
            if ($Video->exists()) {
                
                $Video->isdeleted = 1;
                $Video->delete_at = my_datenow();
                 $Video->save();
                 $updated=1;
               
                    $deletecvideo = new Company_video();
                    $deletecvideo->where('company_id',$this->session->userdata('companyid'));
                    $deletecvideo->where('video_id',$video_id);
                    $deletecvideo->get();
                    if ($deletecvideo->exists()) {
                        $updated=$deletecvideo->delete_all();
                    }
                    //echo $this->db->last_query();exit;
                
               
                    //delete from exercise                    
                    $deletevideo = new Exercise_videos();
                    $deletevideo->where('company_id',$this->session->userdata('companyid'));
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

        //make same name .thumbnail file
        //when video is saved to db same as name thumbnail is saved
        echo json_encode($jsondata);
    }

    /*
     * Function to generate screenshot from video
     */

   public function ffmpeg($input_video) {
        // where ffmpeg is located, such as /usr/sbin/ffmpeg
        $ffmpeg = 'C:\\wamp\\www\\rehabvideo\\ci\\ffmpeg\\bin\\ffmpeg';

        //the input video file
        $video = "C:/wamp/www/rehabvideo/ci/assets/uploads/exercises/$input_video";

        $path_parts = pathinfo($input_video);
        $output_file_name = $path_parts['filename'] . '.png';
        // where you'll save the image
        $output = ("C:/wamp/www/rehabvideo/ci/assets/uploads/exercises/thumbnails/$output_file_name");

        // get the screenshot      
        $cmd = "$ffmpeg -i $video -ss 00:00:02.000 -vframes 1 $output";
        shell_exec($cmd);
        return $output_file_name;
    }

    public function demo_ffmpeg($input_video) {
        // where ffmpeg is located, such as /usr/sbin/ffmpeg
        $ffmpeg = 'D:\\Wamp\\www\\RehabVideoApp\\ffmpeg\\bin\\ffmpeg';

        //the input video file
        $video = "D:/Wamp/www/RehabVideoApp/assets/uploads/exercises/$input_video";

        $path_parts = pathinfo($input_video);
        $output_file_name = $path_parts['filename'] . '.png';
        // where you'll save the image
        $output = ("D:/Wamp/www/RehabVideoApp/assets/uploads/exercises/thumbnails/$output_file_name");

        // get the screenshot      
        $cmd = "$ffmpeg -i $video -ss 00:00:02.000 -vframes 1 $output";
        shell_exec($cmd);
        return $output_file_name;
    }
    
    public function live_ffmpeg($input_video) {
        $ffmpeg='C:\\ffmpeg\\bin\\ffmpeg';    
        $video = "C:/wamp/www/RVA/assets/uploads/exercises/$input_video";
        $path_parts = pathinfo($input_video);
        $output_file_name = $path_parts['filename'] . '.png';
        $output = ("C:/wamp/www/RVA/assets/uploads/exercises/thumbnails/$output_file_name");

        // get the screenshot      
        $cmd = "$ffmpeg -i $video -ss 00:00:02.000 -vframes 1 $output";
        shell_exec($cmd);
        return $output_file_name;
    }
}
