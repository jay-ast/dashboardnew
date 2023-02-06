<div>
    <h4>Dear <?php echo $client_msg_data['client_data']->firstname . ' ' . $client_msg_data['client_data']->lastname . ',' ?></h4>
    <br/>
    <p> Your <?php echo ' '. ucwords(str_replace('_', ' ',$client_msg_data['details']['appointment_type'])). ' ' ?>
        appointment is scheduled with <?php echo ' ' . $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') ?>
        <br/><br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Appointment Date : <?php echo $client_msg_data['details']['schedule_date'] ?>
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time : <?php echo $client_msg_data['details']['start_time'] ?>
        <br/>
        Please contact us at for appointment changes or cancellations 24 hours in advance to avoid being charged the cost of the session.
        <br/>
        In California: 704 Mission Avenue, San Rafael CA 94901.<br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;415-924-2228 or Email: <a href="mailto:synergy@synergyptpilates.com">synergy@synergyptpilates.com</a><br/>

        Switzerland: Golf Gerry Losone, via aloe Gerry 5, 6616 Losone <br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+41 (0) 78 422 71 25 or Email: <a href="mailto:zeina@synergyptpilates.com">zeina@synergyptpilates.com</a><br/><br/>
        <br/>Thanks you and we look forward to seeing you very soon! <br/><br/>
        In health and strength, <br/>
        Synergy+ team
    </p>
</div>