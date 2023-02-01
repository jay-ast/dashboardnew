<?php

require APPPATH . "core/MY_Mobile_Controller.php";

class Videos extends MY_Mobile_Controller {

    //deal with POST data
    public function __construct() {
        parent::__construct();
    }

    public function listVideos() {
        if (!empty($_POST)) {
            $data = array();
            $this->form_validation->set_rules('exerciseid', 'Exercise ID', 'required|integer');

            if ($this->form_validation->run() == FALSE) {
                $this->error("Please provide required valid parameter");
            } else {
                $exerciseid = $_POST['exerciseid'];
                $getVidoes = new Exercise_videos();
                $getVidoes->where('isdeleted', 0);
                $getVidoes->order_by('order', 'ASC');
                $getVidoes->get_by_exercise_id($exerciseid);
                //echo $this->db->last_query();
                if ($getVidoes->exists()) {
                    $order = 0;
                    foreach ($getVidoes as $gv) {
                        $video_id = $gv->videos_id;
                        $vDetaile = new Video();
                        $vDetaile->get_by_id($video_id);
                        if ($vDetaile->exists()) {
                            $temp = array(
                                'id' => $vDetaile->id,
                                'title' => $vDetaile->title,
                                'name' => base_url('assets/uploads/exercises') . "/" . $vDetaile->name,
                                'thumbnail' => base_url('assets/uploads/exercises/thumbnails') . "/" . $vDetaile->thumbnail,
                                'exercise_id' => $exerciseid,
                                'order' => ++$order
                            );
                            $data['videos'][] = $temp;
                        }
                    }
                    $this->success("List of exercie videos", $data);
                } else {
                    $this->error("Sorry No Exercise assigned by Therapist");
                }
            }
        } else {
            $this->error("Not valid request");
        }
    }



    public function uploadfiles() {

        //print_r($_FILES);exit;
       // echo json_encode(array('status' => false, 'data' => $_POST));exit;
        $data = array();
        $this->form_validation->set_rules('userid', 'User ID', 'required');

        $this->form_validation->set_rules('uploaduserid', 'Upload User ID', 'required');

        $this->form_validation->set_rules('title', 'Video Title', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->error("Please provide required valid parameter");
            exit;
        }

        $target_dir = 'assets/uploads/exercises/';
        $fileName = uniqid("file_");
        $target_file = $target_dir . basename( $_FILES["fileToUpload"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        $target_file = $target_dir . $fileName.'.mp4';
        $uploadOk = 1;



// Check if file already exists
        if (file_exists($target_file)) {
           // echo "Sorry, file already exists.";
            $uploadOk = 0;
            echo json_encode(array('status' => false, 'data' => "1"));
           // echo json_encode(array('status' => false));
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 2000000000) {
           // echo "Sorry, your file is too large.";
            $uploadOk = 0;
            echo json_encode(array('status' => false, 'data' => "2"));
           // echo json_encode(array('status' => false));
        }
// Allow certain file formats
        //echo $imageFileType;exit;
        /*if($imageFileType != "webm" && $imageFileType != "mp4" && $imageFileType != "mov") {
            echo json_encode(array('status' => false, 'data' => "3"));
            //echo "Sorry, only webm, mp4 files are allowed.";
            $uploadOk = 0;
            //echo json_encode(array('status' => false));
        } */
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo json_encode(array('status' => false));
            exit;
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";



                $user= new User();
                //$userdetail=$user->get_by_id($_POST['userid']);
                $userdetail=$user->get_by_id($_POST['userid'])->all_to_array();
                $companyvideofolder = new Company_video_folder();

                if(!empty($userdetail)){
                    $companyid= $userdetail[0]['company_id'];
                    $companyvideofolder->where('company_id',$companyid);
                    $companyvideofolder->where('client_id',$_POST['uploaduserid']);
                    $companyfolder=$companyvideofolder->get()->all_to_array();

                    $folderid=$companyfolder[0]['id'];

                }else{
                    echo json_encode(array('status' => false));
                }

                $name = $fileName.'.'.$imageFileType;
                $title = $_POST['title'];

                $addNewVideo = new Video();
                $addNewVideo->title = $title;
                $addNewVideo->name = $name;

                $thumbnail = $this->live_ffmpeg($name);
                $addNewVideo->thumbnail = $thumbnail;
                $addNewVideo->therapist_id = $_POST['userid'];
                $addNewVideo->company_id = $companyid;
                $addNewVideo->ispublic = 0;
                $addNewVideo->save();

                $companyvideo = new Company_video();
                $companyvideo->video_id=$addNewVideo->id;
                $companyvideo->company_id =  $companyid;
                $companyvideo->folder_id = $folderid;
                $companyvideo->save();
                $done=true;
                $dataarr[]=array('id' => $addNewVideo->id);
                if ($done) {
                    echo json_encode(array('status' => true, 'data' => $dataarr));
                } else {
                    echo json_encode(array('status' => false));
                }



            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
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
