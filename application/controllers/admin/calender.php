<?php

class Calender extends My_Controller {

    public function __construct() {
        parent::__construct();   
		$this->load->model('Home_Model');  
		// $this->load->library('../controllers/Kernal');   
    }

    public function index()
	{
		$data['global'] = MY_Controller::globalVariables();
		$listPatients = new User();
        $listPatients->where('roles_id', 3);
        $listPatients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }

        $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');    
        $listPatients->get();

		//echo $this->db->last_query();

        foreach ($listPatients as $lip) {
            $userdetail=$lip->show_result();
            $userlisted[]=$userdetail['id'];
            $patientlist[] = $userdetail;
        }
		$patientlist = [
			'patientlist' => $patientlist
		];
		$patientlist['page_title'] = 'Calender';
		$patientlist['active_class'] = 'calender';
		$this->load->view('admin/panel/home', $patientlist);
	}

    public function getEvents()
	{			
		$result = $this->Home_Model->getEvents();		
		echo json_encode($result);
	}

    public function addEvent()
	{		
		$result = $this->Home_Model->addEvent();
		echo $result;
	}

	/*Update Event */
	public function updateEvent()
	{
		$result=$this->Home_Model->updateEvent();
		echo $result;
	}
	/*Delete Event*/
	public function deleteEvent()
	{
		$result=$this->Home_Model->deleteEvent();
		echo $result;
	}
	public function dragUpdateEvent()
	{	
		$result=$this->Home_Model->dragUpdateEvent();
		echo $result;
	}

	public function sendMail(){
		$mail = $this->Home_Model->sendMail();
		echo $mail;
	}

	public function getClientName(){
		$data['global'] = MY_Controller::globalVariables();
		$listPatients = new User();
        $listPatients->where('roles_id', 3);
        $listPatients->where('isdeleted', 0);
        if (!empty($fullname)) {
            $listPatients->group_start();
            $listPatients->or_like('firstname', $fullname);
            $listPatients->or_like('lastname', $fullname);
            $listPatients->group_end();
        }
        if (!empty($email)) {
            $listPatients->group_start();
            $listPatients->or_like('email', $email);
            $listPatients->group_end();
        }

        // $listPatients->where('company_id', $data['global']['companyid']);
        $listPatients->order_by('firstname', 'ASC');
        $listPatients->order_by('lastname', 'ASC');    
        $listPatients->get();

		//echo $this->db->last_query();

        foreach ($listPatients as $lip) {
            $userdetail=$lip->show_result();
            $userlisted[]=$userdetail['id'];
            $patientlist[] = $userdetail;
        }
		$patientlist = [
			'patientlist' => $patientlist
		];

		echo json_encode($patientlist);
	}

}
