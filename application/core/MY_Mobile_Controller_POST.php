<?php

class MY_Mobile_Controller_POST extends CI_Controller {

    public function __construct() {      
        parent::__construct();
    }

    public function error($error) {
        $this->result['status'] = "0";
        if (is_array($error)) {
            $this->result['msg'] = implode($error, "\n");
        } else {
            $this->result['msg'] = $error;
        }

        $this->show_result();
    }

    public function success($msg = "", $result = "") {
        $this->result['status'] = "1";

        if ($msg != '')
            $this->result['msg'] = $msg;
        if (is_array($result))
            $this->result['result'] = $result;

        $this->show_result();
    }

    public function show_result() {

        echo json_encode($this->result);
        exit(0);
    }

}
