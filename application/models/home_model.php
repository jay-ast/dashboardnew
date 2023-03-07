<?php

use Carbon\Carbon;

class Home_Model extends CI_Model
{

	public function __construct($id = NULL)
	{
		parent::__construct($id);
		$this->load->library('session');
		//  $this->load->helper('form');
	}
	var $table = "events";
	/**
	 * <p>Returns all recoreds with all fields</p>
	 * @param no prarameters
	 * @return Object Class
	 */

	public function getEvents($id = null)
	{		
		$logged_user_role_id = $this->session->userdata('roleid');
		if ($logged_user_role_id == 1) {
			if ($id) {
				$logged_user_id = $id;
				$data = $this->queryFunction($logged_user_id);
			} else {
				$data = $this->queryFunction();
			}
		} else {
			$logged_user_id = $this->session->userdata('userid');
			$data = $this->queryFunction($logged_user_id);
		}
		$records = [];
		foreach ($data as $res) {
			$result['id'] = $res->id_event;
			$result['client_id'] = $res->client_id;
			$result['color'] = $res->color_code;			
			$result['title'] = $res->firstname . " " . $res->lastname;
			$result['start'] = $res->schedule_date . ' ' . $res->start_time;
			$result['end'] = $res->schedule_date . ' ' . $res->end_time;
			$result['start_time'] = $res->start_time;
			$result['end_time'] = $res->end_time;
			$result['appointment_type'] = $res->appointment_type;
			$result['repeating_weeks'] = $res->weekly_repeating_options;
			$result['brief_note'] = $res->brief_note;
			$result['meeting_duration'] = $res->meeting_duration;
			$result['all_day'] = false;
			$result['recurrence'] = $res->recurrence;
			$result['payment_status'] = $res->payment_status;
			$result['price'] = $res->price;
			$result['appointment_name'] = $res->appointment_name;
			$result['firstname'] = $res->firstname;
			$result['lastname'] = $res->lastname;
			$result['provider_name'] = $res->provider_first_name . " " . $res->provider_last_name;
			$result['parent_event_id']  = $res->parent_event_id;
			$records[] = $result;
		}

		return $records;
	}

	public function queryFunction($logged_user_id = '')
	{
		$this->db->select('events.id as id_event,events.client_id,events.schedule_date,events.start_time,events.end_time,events.appointment_type,events.weekly_repeating_options,
			events.brief_note,events.meeting_duration,events.recurrence,events.created_by,events.parent_event_id,users.id as user_id,users.email,users.firstname,users.lastname,
			provider_user.firstname as provider_first_name,provider_user.lastname as provider_last_name,appointment_type.id as appointment_type_id,appointment_type.appointment_name,
			appointment_type.color_code,event_transaction.id as event_transaction_id,event_transaction.event_id,event_transaction.payment_status,event_transaction.price');
		$this->db->from('events');
		$this->db->join('users', 'users.id = events.client_id', 'left');
		$this->db->join('users as provider_user', 'provider_user.id = events.created_by', 'left');
		$this->db->join('appointment_type','appointment_type.id = events.appointment_type', 'left');
		$this->db->join('event_transaction','event_transaction.event_id = events.id', 'left');
		if($logged_user_id){
			$this->db->where('events.created_by', $logged_user_id);
		}
		$this->db->group_by('events.parent_event_id');
		$data = $this->db->get();
        $data = $data->result();		
		return $data;
	}

	public function addEvent()
	{
		$logged_user_id = $this->session->userdata('userid');
		$payment_status = 'pending';
		$date = date_create($_POST['start_time']);
		$start_time = date_format($date, "H:i:s");
		$date = date_create($_POST['end_time']);
		$end_time = date_format($date, "H:i:s");				
		$event_parent_ids = [];
		$parent_event_id = '';
			foreach ($_POST['client_id'] as $client_id) {
				$event_dates = getAppointmentDates($_POST['schedule_date'], $_POST['repeating_weeks'], $_POST['recurrence']);					
				foreach ($event_dates as $event_date) {
					$sql = "INSERT INTO events (client_id,schedule_date,start_time,end_time,appointment_type,weekly_repeating_options, brief_note, meeting_duration, recurrence, created_by) VALUES (?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sql, array($client_id, $event_date, $start_time, $end_time, $_POST['appointment_type'], $_POST['repeating_weeks'], $_POST['brief_note'], $_POST['meeting_duration'], $_POST['recurrence'], $logged_user_id));
					$parent_event_id = $this->db->insert_id();
					if (!isset($event_parent_ids[$event_date])) {
						$event_parent_ids[$event_date] = $parent_event_id;
					}
					$query = "INSERT INTO event_transaction (event_id, client_id, appointment_id, provider_id, price, payment_status) VALUES (?,?,?,?,?,?)";
					$this->db->query($query, array($parent_event_id, $client_id, $_POST['appointment_type'], $logged_user_id, $_POST['price'], $payment_status));
					$subject = 'Your' . ' ' . ucwords(str_replace('_', ' ', $_POST['appointment_type'])) . ' appointment has been scheduled on' . ' ' . $event_date . '.';
				}
			}
			if ($_POST['notify_mail']) {
			    $this->notifyWithMail($_POST['notify_mail'], $_POST, $subject);
			}
			foreach ($event_parent_ids as $event_date => $parent_event_id) {
				$sql = "UPDATE events SET parent_event_id = ? WHERE schedule_date = ? AND appointment_type = ?";
				$this->db->query($sql, array($parent_event_id, formatDate($event_date, "Y-m-d"), $_POST['appointment_type']));
			}
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function updateEvent()
	{
		// var_dump($_POST);die;	
		$logged_user_id = $this->session->userdata('userid');
		$date = date_create($_POST['schedule_date']);
		$schedule_date = date_format($date, "Y/m/d");
		$date = date_create($_POST['start_time']);
		$start_time = date_format($date, "H:i:s");
		$date = date_create($_POST['end_time']);
		$end_time = date_format($date, "H:i:s");

		$sql = "UPDATE events SET client_id = ?, schedule_date = ?, start_time = ?, end_time = ? ,appointment_type = ? ,brief_note = ? ,meeting_duration = ? ,recurrence = ? WHERE id = ?";
		$this->db->query($sql, array($_POST['client_id'], $schedule_date, $start_time, $end_time, $_POST['appointment_type'], $_POST['brief_note'], $_POST['meeting_duration'], $_POST['recurrence'], $_POST['id']));

		$query = "UPDATE event_transaction SET client_id = ?, appointment_id = ?, provider_id = ?, price = ? WHERE event_id = ?";
		$this->db->query($query, array($_POST['client_id'], $_POST['appointment_type'], $logged_user_id, $_POST['price'], $_POST['id']));
		// $subject = 'Your scheduled meeting has been updated on'. ' ' . $schedule_date. '.';
		$subject = 'Your appointment has been scheduled on' . ' ' . $schedule_date . '.';

		if ($_POST['notify_mail'] == 'true') {
			$this->notifyWithMail($_POST['client_id'], $_POST, $subject);
		}

		return ($this->db->affected_rows() != 1) ? false : true;
	}

	/*Delete event */

	public function deleteEvent()
	{
		$sql = "DELETE FROM events WHERE id = ?";
		$this->db->query($sql, array($_GET['id']));
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function notifyWithMail($client_id = [], $details = '', $subject = '')
	{	
	    foreach($client_id as $c_ids){
	        $query = "SELECT * FROM `users` WHERE `id` = '" . $c_ids . "'";
			$data = $this->db->query($query)->result();
			$msg_data = null;

			$query = "SELECT * FROM `appointment_type` WHERE `id` = '" . $_POST['appointment_type'] . "' ";
			$appointment_type_data = $this->db->query($query)->result();
			$appointment_name = '';
			foreach($appointment_type_data as $appointment){
				$appointment_name = $appointment->appointment_name;				
			}
            
            foreach($data as $client_data){
                $client_msg_data = [];
				$client_msg_data['details'] = $details;
				$client_msg_data['client_data'] = $client_data;
				$client_msg_data['appointmentment_type'] = $appointment_name;
				$msg_data = $this->load->view('emails/english_mail_templete', ['client_msg_data' => $client_msg_data], true);
				$from_email = $this->session->userdata('email');
				$to_email = $client_data->email;
				$to = $to_email;
				$body = $msg_data;
				var_dump($from_email, $to, $body);
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <' . $from_email . '>' . "\r\n";
				$result = my_email_send($to, $subject, "event", array('msg_data' => $body), 'support@perfect-forms.net');
            }
	    }
	}
}