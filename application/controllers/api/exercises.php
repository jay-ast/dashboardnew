<?php

require APPPATH . "core/MY_Mobile_Controller.php";

class Exercises extends MY_Mobile_Controller {

    //deal with POST data
    public function __construct() {
        parent::__construct();
    }

    public function listExercise() {
        if (!empty($_POST)) {
            $data = array();
            $this->form_validation->set_rules('userid', 'User ID', 'required|integer');

            if ($this->form_validation->run() == FALSE) {
                $this->error("Please provide required valid parameter");
            } else {
                $userid = $_POST['userid'];               
                $getEx = new Users_exercise();
                $getEx->where('isdeleted', 0);
                $getEx->get_by_users_id($userid);
                if ($getEx->exists()) {
                    foreach ($getEx as $ge) {
                        $eid = $ge->exercise_id;
                        $getEDetail = new Exercise();
                        $getEDetail->get_by_id($eid);
                      
                        $data['exercies'][] = $getEDetail->show_result();
                    }
                    $this->success("List of your exercies", $data);
                } else {
                    $this->error("Sorry No Exercise assigned by Therapist");
                }
            }
        } else {
            $this->error("Not valid request");
        }
    }
    
     

    

}
