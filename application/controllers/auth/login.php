<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct() { 
        
        parent::__construct(FALSE);
    }

    public function index() {
        $user_data = $this->session->userdata('userid');
        if ($user_data) {
            //if user is already logged in..            
            // redirect('admin/patients');
            redirect('admin/home');
        } else {
            $this->load->view('admin/login');
        }
    }

    public function verifyLogin() {
      //var_dump("verify login");exit;
       $email = default_value($this->input->post('email'), '');
        $password = default_value($this->input->post('password'), '');
        if ($email != '' || $password != '') {
            $auth = new Authentication();
            if ($auth->validateEmail($email)) {
                if ($auth->checkVerfied('email', $email) != false) {
                    $credentials = $auth->validateCredential('email', $email, $password);
                    if ($credentials) {
                        //session set here
                        $this->session->set_userdata($credentials);
                        if ($credentials['roleid'] == 1 && $credentials['companyid'] == 0) {
                            redirect('admin/companies');
                        } elseif ($credentials['roleid'] == 1 && $credentials['companyid'] != 0) {
                            redirect('admin/home');
                        } else {
                            redirect('admin/home');
                        }
                    } else {
                        my_alert_message('danger', 'Invalid Password');
                        redirect('auth/login');
                    }
                } else {
                    my_alert_message('danger', 'Permission not granted');
                    redirect('auth/login');
                }
            } else {
                my_alert_message('danger', 'Email is not registered');
                redirect('auth/login');
            }
        } else {
            my_alert_message('danger', 'Email or Password should not be blank');
            redirect('auth/login');
        }
    }

    public function logout() {
        $session_data = $this->session->all_userdata();
        $redirect_to = "auth/login";
        foreach ($session_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' &&
                    $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
        $this->session->sess_destroy();
        redirect($redirect_to);
    }

    public function forgot() {
        $data['page_title'] = 'Forgot Password';
        $this->load->view('admin/auth/forgot', $data);
    }

    public function sendForgotPasswordMail() {
        $email = $this->input->post('email');
        if ($email != '') {
            $forgotObj = new Authentication();
            if ($forgotObj->validateEmail($email)) {
                $from = 'admin@renospeedlab.com';
                $subject = 'Forgot Password of Car Service App Portal ';

                $rand = md5(random_string('alnum', 10));
                $data['link'] = base_url('auth/login/setNewPassword') . '/' . $rand;

                $userDetails = new Authentication();
                $userDetails->where('email', $email);
                $userDetails->update(array('unique_string' => $rand));


                if (my_email_send($email, SITE_TITLE , 'forgotPassword', $data, 'support@pperfect-forms.net', 'Team '.SITE_TITLE)) {
                    my_alert_message('success', 'Password recovery link has been sent to your Email ID');
                    redirect('auth/login');
                } else {
                    my_alert_message('danger', 'Error in sending Password recovery link.');
                    redirect('auth/login/forgot');
                }
            } else {
                my_alert_message('danger', 'Email is not registered');
                redirect('auth/login/forgot');
            }
        } else {
            my_alert_message('danger', 'Enter registred Email');
            redirect('auth/login/forgot');
        }
    }

    public function setNewPassword($token) {
        $userobj = new Authentication();
        $userobj->select('email');
        $userobj->where('unique_string', $token);
        $userobj->get();
        if ($userobj->result_count()) {
            $data['page_title'] = 'Set New Password';
            $data['setpassword'] = 'yes';
            $data['email'] = $userobj->email;
            $this->load->view('admin/auth/forgot', $data);
        } else {
            my_alert_message('danger', 'Forgot Password Link expired');
            redirect('auth/login');
        }
    }

    public function saveNewPassword() {
        $emailvalidate = new Authentication();
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        if ($emailvalidate->validateEmail($email)) {
            $newPassword = md5($password);
            $setuserObj = new Authentication();
            $setuserObj->where('email', $email);
            $setuserObj->get();
            if ($setuserObj->exists()) {
                $setuserObj->password = $newPassword;
                $setuserObj->unique_string = NULL;
                $setuserObj->update_at = my_datenow();
                if ($setuserObj->save()) {
                    my_alert_message('success', 'Your new password has been set successfully');
                    redirect('auth/login');
                } else {
                    my_alert_message('danger', 'Error in setting new Password');
                    redirect('auth/login');
                }
            }
        } else {
            my_alert_message('danger', 'Email is not registered');
            redirect('auth/login');
        }
    }

}
