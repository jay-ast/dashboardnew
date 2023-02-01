<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct($init = true) {
        parent::__construct();
        // We should use our custom function to handle errors.
        set_error_handler(array($this, 'custom_error'));

        if ($init == true) {
            $this->load->library('pagination');
            if ($this->session->userdata('userid') == '') {

                //redirect to login page
                redirect('auth/login');
            }
        }
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

    public function globalVariables() {
        //setting up global varible for local use
        if ($this->session->userdata('userid') != '') {
            $data['userid'] = $this->session->userdata('userid');
            $data['email'] = $this->session->userdata('email');
            $data['companyid'] = $this->session->userdata('companyid');
            $data['firstname'] = $this->session->userdata('firstname');
            $data['lastname'] = $this->session->userdata('lastname');
            $data['usrername'] = $this->session->userdata('usrername');
            return $data;
        }
    }

    public function paginationInit($url, $totalresult, $numlinks, $per_page, $url_segment = 4) {
        $config["base_url"] = base_url() . $url;
        $config["total_rows"] = $totalresult;
        $config["per_page"] = $per_page;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = $url_segment;
        $config['num_links'] = $numlinks;
        $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        $str_links = $this->pagination->create_links();
        $links = explode('&nbsp;', $str_links);
        return $links;
    }

}
