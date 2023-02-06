<div>
    <h4>Gentile <?php echo ' '.$client_msg_data['client_data']->firstname . ' ' . $client_msg_data['client_data']->lastname . ',' ?></h4>
    <br/>
    <p> Il suo appuntamento di <?php echo ' '. ucwords(str_replace('_', ' ',$client_msg_data['details']['appointment_type'])). ' ' ?>
        é confermato con <?php echo ' ' . $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') ?>
        <br/><br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Appointment Date : <?php echo $client_msg_data['details']['schedule_date'] ?>
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time : <?php echo $client_msg_data['details']['start_time'] ?>
        <br/>
        Per favore ci contatti con 24 ore di anticipo per eventuali cambiamenti o per disdire l’appuntamento senza incorrere in pagamenti.
        <br/>
        
        Svizzera: Golf Gerry Losone, via aloe Gerry 5, 6616 Losone <br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;numero di telefono/messaggio/WhatsApp: +41 (0) 78 422 71 25 or 
            Email :<a href="mailto:zeina@synergyptpilates.com">zeina@synergyptpilates.com</a><br/><br/>

        In California: 704 Mission Avenue, San Rafael CA 94901.<br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone/text/WhatsApp: 415.924.2228 or Email : <a href="mailto:synergy@synergyptpilates.com">synergy@synergyptpilates.com</a><br/>        

        <br/>Grazie e siamo lieti di vedervi presto!/ Vi aspettiamo presto! <br/><br/>
        In salute e forza, <br/>
        Zeina e Synergy+
    </p>
</div>