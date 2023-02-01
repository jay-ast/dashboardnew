<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authentication extends DataMapper {

    var $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    /**
     * verfiy Email for admin login
     * 
     * @param string email
     * @param string emailid values
     * 
     * @return boolean returns true/flse
     */
    public function validateEmail($email) {

        $userObj = new Authentication();
        $userObj->select('email');
        $userObj->where('email', $email);
        $userObj->where('isdeleted', 0);
        $userObj->get();

        if ($userObj->email) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * verfiy Email or username for Block or not
     * 
     * @param string username or email
     * @param string emailid/username values
     * 
     * @return boolean returns true/flse
     */
    public function checkVerfied($type, $value) {

        if ($type == 'username') {
            $userObj = new Authentication();
            $userObj->select('username');
            $userObj->where('email', $value);
            $userObj->where('roles_id !=', 3);
            $userObj->get();

            if ($userObj->username) {
                return true;
            } else {
                return false;
            }
        } else {
            $userObj = new Authentication();
            $userObj->select('email');
            $userObj->where('roles_id !=', 3);
            $userObj->where('email', $value);
            $userObj->get();

            if ($userObj->email) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * verfiy Email or username with password
     * 
     * @param string usertype username or email
     * @param string value username or email
     * @param string password for admin encrypted and user visible
     * 
     * @return boolean returns true/flse
     */
    public function validateCredential($type, $value, $password) {

        if ($type == 'username') {
            $orginalCredential = $this->getOriginalCredential($type, $value);
            if ($orginalCredential->password == $password) {
                if( $orginalCredential->company_id !=0)
                {
                 $getCompanytDetails = new Company();
                 $getCompanytDetails->get_by_id($orginalCredential->company_id);
                 $datas = $getCompanytDetails->show_result();
                 $session_array['companyname']=($datas['company_name']!=NULL)?$datas['company_name']:'';
                 $session_array['companylogo']=($datas['company_logo']!=NULL)?$datas['company_logo']:'';
                 $session_array['companyemail']=($datas['company_email']!=NULL)?$datas['company_email']:'';
                }
                
                 $session_array['userid'] = $orginalCredential->id;
                 $session_array['companyid'] = $orginalCredential->company_id;
                 $session_array['email'] = $orginalCredential->email;
                 $session_array['firstname'] = $orginalCredential->firstname;
                 $session_array['lastname'] = $orginalCredential->lastname;
                 $session_array['roleid'] = $orginalCredential->roles_id;
                return $session_array;
            } else {
                return false;
            }
        } else {
            //for admin credenitals 
            $orginalCredential = $this->getOriginalCredential($type, $value);

            if ($orginalCredential->password == $password) {
                //set session
                if( $orginalCredential->company_id !=0)
                {
                 $getCompanytDetails = new Company();
                 $getCompanytDetails->get_by_id($orginalCredential->company_id);
                 $datas = $getCompanytDetails->show_result();
                 $session_array['companyname']=($datas['company_name']!=NULL)?$datas['company_name']:'';
                 $session_array['companylogo']=($datas['company_logo']!=NULL)?$datas['company_logo']:'';
                 $session_array['companyemail']=($datas['company_email']!=NULL)?$datas['company_email']:'';
                }
                
                 $session_array['userid'] = $orginalCredential->id;
                 $session_array['companyid'] = $orginalCredential->company_id;
                 $session_array['email'] = $orginalCredential->email;
                 $session_array['firstname'] = $orginalCredential->firstname;
                 $session_array['lastname'] = $orginalCredential->lastname;
                 $session_array['roleid'] = $orginalCredential->roles_id;
                return $session_array;

                return $session_array;
            } else {
                return false;
            }
        }
    }

    /**
     * get password for  Email or username 
     * 
     * @param string usertype username or email
     * @param string value username or email
     * 
     * @return boolean returns true/flse
     */
    public function getOriginalCredential($type, $value) {
        if ($type == 'username') {
            $userObj = new Authentication();
            $userObj->where('email', $value);
            $userObj->where('roles_id', 3);
            $userObj->get();
            if ($userObj->count()) {
                return $userObj;
            } else {
                return false;
            }
        } else {
            $userObj = new Authentication();
            $userObj->where('email', $value);
            $userObj->where('isdeleted', 0);
            $userObj->get();

            if ($userObj->result_count()) {
                return $userObj;
            } else {
                return false;
            }
        }
    }
    public function update_password($data)
    {
    $this->db->set('password',$data['newpassword'])
            ->set('update_at',$data['update_at'])
            ->where('password',$data['oldpassword'])
            ->where('id',$data['userid'])
            ->update('users');
            return true;
    }

}
