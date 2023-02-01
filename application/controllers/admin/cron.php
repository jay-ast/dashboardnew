<?php
class Cron extends CI_Controller
{

   function __construct()
   {
      parent::__construct();
      $this->load->library('session');
      $this->load->helper('form');
   }

   public function index()
   {

      // $this->load->helper('form'); 
      // $this->load->view('email_form'); 
   }

   public function sendMail()
   {
        $start_date = date('Y-m-d H:i:s');
		$end_date = date('Y-m-d', strtotime(' +24 hours', strtotime($start_date)));

		$query = "SELECT `events`.`id`, `events`.`client_id`, `events`.`schedule_date`, `events`.`start_time`, `events`.`end_time`,`events`.`appointment_type`,`users`.`id`, `users`.`email`, 
                  `users`.`firstname`, `users`.`lastname` FROM (`events`) 
                  LEFT JOIN `users` ON `users`.`id`=`events`.`client_id`
                  WHERE schedule_date BETWEEN '" . $start_date . "' AND '" . $end_date . "'";

		$data = $this->db->query($query)->result();
		$msg_data = null;
		$subject = "Notify For Schedule Meeting";
		foreach ($data as $lip) {
		    
			$msg_data = 'Hello ' . $lip->firstname . ' ' . $lip->lastname . ", <br/>";
			$msg_data .= '<br/>';
			$msg_data .= 'Your ' . ucwords(str_replace('_', ' ', $lip->appointment_type)) . ' appointment is scheduled with ' . $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') .
				' on ' . $lip->schedule_date . ' from ' . $lip->start_time . ' to ' . $lip->end_time . '.' . '<br/><br/>';

		
			$from_email = "support@perfect-forms.net";
			$to_email = $lip->email;
			$to = $to_email;
			$body = $msg_data;

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			$headers .= 'From: <' . $from_email . '>' . "\r\n";
			$result = my_email_send($to, $subject, "cron_view", array('msg_data' => $body), 'support@perfect-forms.net');
		}

		$from_email = "support@perfect-forms.net";
		$to_email = "zeina@synergyptpilates.com";
		$to = $to_email;
		$body = $msg_data;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: <' . $from_email . '>' . "\r\n";
		$result = my_email_send($to, $subject, "cron_view", array('msg_data' => $body), 'support@perfect-forms.net');
		// return $result;
   }
}
