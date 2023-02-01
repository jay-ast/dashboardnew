<?php

class MY_Mobile_Controller extends CI_Controller {

    public function __construct() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        //$_POST = json_decode(file_get_contents("php://input"), true);   
        // We should use our custom function to handle errors.
        set_error_handler(array($this, 'custom_error'));
        parent::__construct();
    }

    // Our custom error handler
    function custom_error($number, $message, $file, $line, $vars) {
        //$email = $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // Email the error to someone...
        $email_param['title'] = SITE_TITLE . "Error-Report";
        //error_log($email, 1, 'chintan7027@gmail.com', $headers);
        $email_param['content'] = "<h4>Hello Chintan,</h4>"
                . "<p>We have received a error report in <b>" . SITE_TITLE . "</b> Project. "
                . "<br> Here is detail report</p>"
                . "<hr>"
                . "<strong>Error #:</strong> $number<br> "
                . "<strong>Line:  </strong>$line<br>"
                . "<strong>File: </strong> $file <br>"
                . "<strong>Request URI: </strong>" . $_SERVER['REQUEST_URI'] . " <br>"
                . "<p><strong>Details:</strong><i> $message </i></p>";
        if ($number != 2048) {
           // my_email_send(ERROR_REPORT_EMAIL, SITE_TITLE . "Error-Report", 'customErrorEmail', $email_param, SITE_EMAIL, 'Team ' . SITE_TITLE);
        }
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
    
    public function success2($msg = "", $result = "") {
        $this->result['status'] = "1";

        if ($msg != '')
            $this->result['msg'] = $msg;
        if (is_array($result))
            $this->result['result'] = $result;

        $this->show_result2();
    }

    

    public function show_result() {
//        header('Content-Type: application/json');       
//        echo json_encode($this->result);

        return $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        exit(0);
    }
 
    public function show_result2() {
      // header('Content-Type: application/json');       
       echo json_encode($this->result);

       // return "rey";
        exit(0);
    }

}
