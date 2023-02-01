<?php

class Appointment extends My_Controller
{
    public function __construct()
    {
        parent::__construct();        
    }

    public function index()
    {
        $data['page_title'] = 'Appointment';
        $data['active_class'] = 'appointment';

        $event_data = "SELECT  `events`.*,
                                `users`.`id`,                                
                                `users`.`firstname`,
                                `users`.`lastname`,
                                `provider_user`.`firstname` as `provider_first_name`,
                                `provider_user`.`lastname` as `provider_last_name`
                        FROM (`events`)
                        LEFT JOIN `users` ON `users`.`id` = `events`.`client_id`
                        LEFT JOIN `users` as `provider_user` ON `provider_user`.`id` = `events`.`created_by`";
        $data['event_data'] = $this->db->query($event_data)->result();
        $total_count = count($data['event_data']);
        $numlinks = 3;
        $per_page = 10;
        $data["links"] = $this->paginationInit("admin/appointment/index", $total_count, $numlinks, $per_page, 4);

        $this->load->view('admin/panel/appointment', $data);
    }
}