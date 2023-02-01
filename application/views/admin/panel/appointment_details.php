<div class="modal-dialog new-modal-dialog">
    <div class="modal-content">
        <!-- dialog body -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <a style="float: right; margin-right: 20px;" href="<?php echo base_url('admin/patients'); ?>">Return to client portal</a>
            <?php
            foreach ($client_data['client_name'] as $name) {
                $client_id = $name->id;
            ?>
                <h4 class="modal-title"><b>Name: <?php echo $name->firstname . ' ' . $name->lastname ?></b></h4>
            <?php
            }
            ?>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 appointmentsDetail">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Next appointments</label>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                if ($client_data['client_data_next_event']) {
                                    foreach ($client_data['client_data_next_event'] as $data) {
                                        $month = date("F", strtotime($data->schedule_date));
                                        $day = date("j", strtotime($data->schedule_date));
                                        $year = date("Y", strtotime($data->schedule_date));
                                ?>
                                        <div class="col-md-4">
                                            <div class="card appointment-card">
                                                <div class="card-header">
                                                    <h1 class="text-center"><?php echo $day ?></h1>
                                                    <h6 class="text-center"><?php echo $month . ',' . $year ?></h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <label class="badge badge-success"> <?php echo $data->appointment_type ?></label>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p>No upcoming appointments scheduled</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Past appointments</label>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                if ($client_data['client_data_past_event']) {
                                    foreach ($client_data['client_data_past_event'] as $data) {
                                        $month = date("F", strtotime($data->schedule_date));
                                        $day = date("j", strtotime($data->schedule_date));
                                        $year = date("Y", strtotime($data->schedule_date));
                                ?>
                                        <div class="col-md-4">
                                            <div class="card appointment-card">
                                                <div class="card-header">
                                                    <h1 class="text-center"><?php echo $day ?></h1>
                                                    <h6 class="text-center"><?php echo $month . ',' . $year ?></h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <label class="badge badge-success"> <?php echo $data->appointment_type ?></label>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p>No past appointments scheduled</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-mail client-portal-button" href="<?php echo base_url("admin/home?id=".$client_id); ?>" target="_top" id="">Schedule new appointment</a>
        </div>
    </div>
</div>