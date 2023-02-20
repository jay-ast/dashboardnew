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
		// $logged_user_id = $this->session->userdata('userid');
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
			// $result['color'] = $types[$res->appointment_type];
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
		if ($logged_user_id) {
			$sql = "SELECT `events`.`id` as `id_event`,
    				`events`.`client_id`,
    				`events`.`schedule_date`,
     				`events`.`start_time`,
					`events`.`end_time`,
					`events`.`appointment_type`,
					`events`.`weekly_repeating_options`,
					`events`.`brief_note`,		
					`events`.`meeting_duration`,
					`events`.`recurrence`,
					`events`.`created_by`,
					`events`.`parent_event_id`,
    				`users`.`id` as `user_id`,
    				`users`.`email`,
    				`users`.`firstname`,
    				`users`.`lastname`,
					`provider_user`.`firstname` as `provider_first_name`,
                	`provider_user`.`lastname` as `provider_last_name`,
					`appointment_type`.`id` as `appointment_type_id`,
					`appointment_type`.`appointment_name`,
					`appointment_type`.`color_code`,
					`price_details`.`id` as `price_details_id`,
					`price_details`.`event_id`,
					`price_details`.`payment_status`,
					`price_details`.`price`
				FROM (`events`)				
				LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
				LEFT JOIN `users` as `provider_user` ON `provider_user`.`id` = `events`.`created_by`
				LEFT JOIN `appointment_type` ON `appointment_type`.`id` = `events`.`appointment_type`
				LEFT JOIN `price_details` ON `price_details`.`event_id` = `events`.`id`
				WHERE `events`.`created_by` = $logged_user_id
				GROUP BY `events`.`parent_event_id`";
			// $data = $this->db->query($sql)->result();
		} else {
			$sql = "SELECT `events`.`id` as `id_event`,
    				`events`.`client_id`,
    				`events`.`schedule_date`,
     				`events`.`start_time`,
					`events`.`end_time`,
					`events`.`appointment_type`,
					`events`.`weekly_repeating_options`,
					`events`.`brief_note`,		
					`events`.`meeting_duration`,
					`events`.`recurrence`,
					`events`.`created_by`,
					`events`.`parent_event_id`,
    				`users`.`id`,
    				`users`.`email`,
    				`users`.`firstname`,
    				`users`.`lastname`,
					`provider_user`.`firstname` as `provider_first_name`,
                	`provider_user`.`lastname` as `provider_last_name`,
					`appointment_type`.`id`,
					`appointment_type`.`appointment_name`,
					`appointment_type`.`color_code`,
					`price_details`.`id` as `price_details_id`,
					`price_details`.`event_id`,
					`price_details`.`payment_status`,
					`price_details`.`price`
				FROM (`events`)
				LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
				LEFT JOIN `users` as `provider_user` ON `provider_user`.`id` = `events`.`created_by`
				LEFT JOIN `appointment_type` ON `appointment_type`.`id` = `events`.`appointment_type`
				LEFT JOIN `price_details` ON `price_details`.`event_id` = `events`.`id`
				GROUP BY `events`.`parent_event_id`";

			// $data = $this->db->query($sql)->result();
		}
		$data = $this->db->query($sql)->result();
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
		// if  recurrence is set, get all the dates for the events
		// Loop through all the selected-clients, and store the event information and pricing-details				
		$event_parent_ids = [];
		
			foreach ($_POST['client_id'] as $client_id) {				
				$event_dates = getAppointmentDates($_POST['schedule_date'], $_POST['repeating_weeks'], $_POST['recurrence']);					
				foreach ($event_dates as $event_date) {
					$sql = "INSERT INTO events (client_id,schedule_date,start_time,end_time,appointment_type,weekly_repeating_options, brief_note, meeting_duration, recurrence, created_by) VALUES (?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sql, array($client_id, $event_date, $start_time, $end_time, $_POST['appointment_type'], $_POST['repeating_weeks'], $_POST['brief_note'], $_POST['meeting_duration'], $_POST['recurrence'], $logged_user_id));
					$parent_event_id = $this->db->insert_id();
					if (!isset($event_parent_ids[$event_date])) {
						$event_parent_ids[$event_date] = $parent_event_id;
					}
					$query = "INSERT INTO price_details (event_id, client_id, appointment_id, provider_id, price, payment_status) VALUES (?,?,?,?,?,?)";
					$this->db->query($query, array($parent_event_id, $client_id, $_POST['appointment_type'], $logged_user_id, $_POST['price'], $payment_status));
					$subject = 'Your' . ' ' . ucwords(str_replace('_', ' ', $_POST['appointment_type'])) . ' appointment has been scheduled on' . ' ' . $event_date . '.';
					if ($_POST['notify_mail'] == 'true') {
						$this->notifyWithMail($client_id, $_POST, $subject);
					}
				}
			}
			foreach ($event_parent_ids as $event_date => $parent_event_id) {
				$sql = "UPDATE events SET parent_event_id = ? WHERE schedule_date = ?";
				$this->db->query($sql, array($parent_event_id, formatDate($event_date, "Y-m-d")));
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

		$query = "UPDATE price_details SET client_id = ?, appointment_id = ?, provider_id = ?, price = ? WHERE event_id = ?";
		$this->db->query($query, array($_POST['client_id'], $_POST['appointment_type'], $logged_user_id, $_POST['price'], $_POST['id']));
		// $subject = 'Your scheduled meeting has been updated on'. ' ' . $schedule_date. '.';
		$subject = 'Your' . ' ' . ucwords(str_replace('_', ' ', $_POST['appointment_type'])) . ' appointment has been scheduled on' . ' ' . $schedule_date . '.';

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

	public function sendMail()
	{
		$start_date = date('Y-m-d H:i:s');
		// $start_date = date('2022-11-30 10:36:00');
		$end_date = date('Y-m-d H:i:s', strtotime($start_date) + (60 * 30));
		// var_dump($start_date, $end_date);die;

		$query = "SELECT `events`.`id`, `events`.`client_id`, `events`.`schedule_date`,`users`.`id`, `users`.`email`, 
					`users`.`firstname`, `users`.`lastname` FROM (`events`) 
					LEFT JOIN `users` ON `users`.`id`=`events`.`client_id`
					WHERE schedule_date BETWEEN '" . $start_date . "' AND '" . $end_date . "'";

		$data = $this->db->query($query)->result();
		$msg_data = null;
		if (!empty($data)) {
			foreach ($data as $client_data) {
				$msg_data .= 'Client Name : ' . $client_data->firstname . ' ' . $client_data->lastname . ' Date and Time : ' . $client_data->schedule_date . '<br/>';

				$from_email = "developers.shabbir+1@arsenaltech.com";
				$to_email = $client_data->email;

				//Load email library 
				$this->load->library('email');

				$this->email->from($from_email, 'Test mail');
				$this->email->to($to_email);
				$this->email->subject('Notify For Schedule Meeting');
				$this->email->message('Your meeting have schedule at ' . $client_data->schedule_date . ' With ' . $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname'));

				//Send mail
				if ($this->email->send()) {
					$this->session->set_flashdata("email_sent", "Email sent successfully.");
				} else {
					$this->session->set_flashdata("email_sent", "Error in sending Email.");
					//    $this->load->view('email_form'); 
				}
			}

			$from_email = "developers.shabbir+1@arsenaltech.com";
			$to_email = "zeina@synergyptpilates.com";

			//Load email library 
			$this->load->library('email');

			$this->email->from($from_email, 'Test mail');
			$this->email->to($to_email);
			$this->email->subject('Notify For Schedule Meeting with Client');
			$this->email->message('Your meeting have schedule with ' . $msg_data);

			//Send mail
			if ($this->email->send()) {
				$this->session->set_flashdata("email_sent", "Email sent successfully.");
			} else {
				$this->session->set_flashdata("email_sent", "Error in sending Email.");
				//    $this->load->view('email_form'); 
			}
		}
	}

	public function notifyWithMail($client_id = '', $details = '', $subject = '')
	{
		$query = "SELECT * FROM `users` WHERE `id` = '" . $client_id . "'";
		$data = $this->db->query($query)->result();
		$msg_data = null;

		foreach ($data as $client_data) {
			$client_msg_data = [];
			$client_msg_data['details'] = $details;
			$client_msg_data['client_data'] = $client_data;
			$msg_data = $this->load->view('emails/english_mail_templete', ['client_msg_data' => $client_msg_data], true);

			// Regular Language Mail Templete
			// $msg_data .= 'Dear ' . $client_data->firstname . ' ' . $client_data->lastname . ", <br/>";
			// $msg_data .= '<br/>';
			// $msg_data .= 'Your ' . ucwords(str_replace('_', ' ', $details['appointment_type'])) . ' appointment is scheduled with ' 
			// 			. $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') . '<br/><br/>';
			// // ' on ' . $details['schedule_date'] . ' from ' . $details['start_time'] . ' to ' . $details['end_time'] . '.' . '<br/><br/>';
			// $msg_data .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Appointment date : ' . $details['schedule_date'] . '<br/>';
			// $msg_data .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time : ' . $details['start_time'] . '<br/>';

			// $msg_data .= '<p>Please contact us at for appointment changes or cancellations 24 hours in advance to avoid being charged the cost of the session.</p>';			

			// $msg_data .= '<p>In California: 704 Mission Avenue, San Rafael CA 94901.<br/>
			// 						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;415-924-2228 or <a href="mailto:synergy@synergyptpilates.com">synergy@synergyptpilates.com</a><br/>

			//                          Switzerland: Golf Gerry Losone, via aloe Gerry 5, 6616 Losone <br/>
			// 						 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+41 (0) 78 422 71 25 or <a href="mailto:zeina@synergyptpilates.com">zeina@synergyptpilates.com</a><br/><br/>
			//                     </p>';
			// $msg_data .= ' <br/>Thanks you and we look forward to seeing you very soon! <br/><br/>';

			// Italian Mail Templete
			// $msg_data .= ' In health and strength, <br/>
			//                        Synergy+ team... <br/><br/>';

			// $msg_data .= '<br/><br/>Gentile ' . $client_data->firstname . ' ' . $client_data->lastname . ", <br/>";
			// $msg_data .= '<br/>';
			// $msg_data .= 'Il suo appuntamento di ' . ucwords(str_replace('_', ' ', $details['appointment_type'])) . ' é confermato con ' 
			// 								   . $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') . '<br/><br/>';

			// $msg_data .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Appointment date : ' . $details['schedule_date'] . '<br/>';
			// $msg_data .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time : ' . $details['start_time'] . '<br/>';

			// $msg_data .= '<p>Per favore ci contatti con 24 ore di anticipo per eventuali cambiamenti o per disdire l’appuntamento senza incorrere in pagamenti.</p>';
			// 					   // $msg_data .= '<br/>';

			// $msg_data .='<p>
			// 				Svizzera: Golf Gerry Losone, via aloe Gerry 5, 6616 Losone <br/>
			// 					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;numero di telefono/messaggio/WhatsApp: +41 (0) 78 422 71 25 or 
			// 					Email : <a href="mailto:zeina@synergyptpilates.com">zeina@synergyptpilates.com</a><br/><br/>
			// 				In California: 704 Mission Avenue, San Rafael CA 94901.<br/>
			// 					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone/text/WhatsApp: 415.924.2228 or Email :<a href="mailto:synergy@synergyptpilates.com">synergy@synergyptpilates.com</a><br/>
			// 			</p>';
			// $msg_data .= '<br/>Grazie e siamo lieti di vedervi presto!/ Vi aspettiamo presto! <br/><br/>';
			// $msg_data .= 'In salute e forza, <br/>
			// 			Zeina e Synergy+';

			// }

			$from_email = $this->session->userdata('email');
			$to_email = $client_data->email;
			$to = $to_email;
			$body = $msg_data;
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers
			$headers .= 'From: <' . $from_email . '>' . "\r\n";
			$result = my_email_send($to, $subject, "event", array('msg_data' => $body), 'support@perfect-forms.net');
			return $result;
		}
	}
}