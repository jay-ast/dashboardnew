<?php include_once 'header.php'; ?>
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href='<?php echo base_url(); ?>assets/css/fullcalendar.css' rel='stylesheet' />
<!-- <link href='<?php echo base_url(); ?>assets/css/main.css' rel='stylesheet' /> -->
<link href="<?php echo base_url(); ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" />
<script src='<?php echo base_url(); ?>assets/js/moment.min.js'></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fullcalendar.min.js?v=1"></script>
<script src='<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js'></script>
<script src='<?php echo base_url(); ?>assets/js/main.js?v=1.1'></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div id="content">
    <h1 class="bg-white content-heading border-bottom">Home</h1>
    <div class="innerAll spacing-x2">
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none">
                <div class="row">
                    <?php if ($this->session->userdata('roleid') == '1') { ?>
                        <div class="form-group">
                            <div class="col-md-5">
                                <div class="col-md-4">
                                    <select class="form-control provider_data" id="provider_data" name="provider_data">
                                        <option value="">All Staff</option>
                                        <?php
                                        foreach ($providerlist as $clientfolder) {
                                            echo '<option value="' . $clientfolder['id'] . '" data-name="' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] . '">' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h3 class="provider_name"></h3>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="alert"></div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="event-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="error"></div>
                    <form class="form-horizontal" id="crud-form">
                        <div class="form-group event-group">
                            <label class="col-md-4 control-label" for="client_id">Select Group</label>
                            <div class="col-md-4" class="group_client">
                                <label for="single_client">Single</label>
                                <input type="radio" name="single" id="single_client" value="single_client" checked />
                                <label for="group_client">Group</label>
                                <input type="radio" name="single" id="group_client" value="group_client" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="client_id">Client Name</label>
                            <div class="col-md-4 clientSelect">
                                <select class="form-control selectpicker client_id" id="client_id" name="client_id[]">
                                </select>
                            </div>

                            <div class="col-md-4" id="update-client-info">
                                <a class="btn btn-primary btnUpdateClient hide" data-toggle="modal" href="#client-modal" id="btnUpdateClient" style="max-width: 130px"> <i class="fa fa-edit"></i>Update Client</a>
                            </div>
                        </div>

                        <!-- <div class="client-details"> -->
                        <!-- <div class="form-group">
                            <label class="col-md-4 control-label" for="schedule_date">Client Name</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control client_name" id="client_name" name="client_name" readonly>
                            </div>
                        </div> -->

                        <div class="form-group email_div">
                            <label class="col-md-4 control-label" for="client_email">Client Email</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control client_email" id="client_email" name="client_email" readonly>
                            </div>
                        </div>

                        <div class="form-group phone_div">
                            <label class="col-md-4 control-label" for="client_phone">Client Phone</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control client_phone" id="client_phone" name="client_phone" readonly>
                            </div>
                        </div>
                        <!-- </div> -->

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="schedule_date">Schedule Date</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control schedule_date" id="schedule_date" name="schedule_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="start_time">Start Time</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control start_time" id="start_time" name="start_time">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="meeting_duration">Meeting Duration</label>
                            <div class="col-md-2">
                                <lable>Hours </lable>
                                <select class="form-control meeting_duration_hours" id="meeting_duration_hours" name="meeting_duration_hours">
                                    <?php
                                    $total_hours = range(0, 8);
                                    foreach ($total_hours as $key => $hours) {
                                    ?>
                                        <option value="<?php echo $hours ?>">
                                            <?php echo $hours ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <lable>Minutes </lable>
                                <select class="form-control meeting_duration_minutes" id="meeting_duration_minutes" name="meeting_duration_minutes">
                                    <?php
                                    $total_minutes = range(0, 55, 5);
                                    foreach ($total_minutes as $key => $minutes) {
                                    ?>
                                        <option value="<?php echo $minutes ?>">
                                            <?php echo $minutes ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="end_time">End Time</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control end_time" id="end_time" name="end_time" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="appointment_type">Appointment type</label>
                            <div class="col-md-4">
                                <select class="form-control appointment_type" id="appointment_type" name="appointment_type">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($appointment_type as $types) {
                                    ?>
                                        <option value="<?php echo $types->id ?>"><?php echo $types->appointment_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="client_email">Appointment Price</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control appointment_price" id="appointment_price" name="appointment_price" readonly>
                            </div>
                        </div>

                        <div class="form-group recurrence_group">
                            <label class="col-md-4 control-label" for="recurrence">Recurrence</label>
                            <div class="col-md-4">
                                <select class="form-control recurrence" id="recurrence" name="recurrence">
                                    <option value="days" selected>Daily</option>
                                    <option value="week">Weekly</option>
                                    <option value="months">Monthly</option>
                                    <option value="none">None</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group repeating_weeks_group">
                            <label class="col-md-4 control-label" for="repeating_weeks">Number Of Repetition</label>
                            <div class="col-md-4">
                                <select class="form-control repeating_weeks" id="repeating_weeks" name="repeating_weeks">
                                    <?php
                                    foreach (range(1, 15) as $key => $repeat_count) {
                                    ?>
                                        <option value="<?php echo $repeat_count; ?>">
                                            <?php echo $repeat_count; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="brief_note">Brief Details</label>
                            <div class="col-md-4">
                                <textarea autocomplete="off" type="textarea" class="form-control brief_note" id="brief_note" name="brief_note">
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="brief_note">Notify With Mail</label>
                            <div class="col-md-4 notify_selected_mail">
                                <!-- <input type="checkbox" class="notify_mail" id="notify_mail" name="notify_mail" /> -->
                            </div>
                        </div>
                    </form>
                    <!-- <div class="col-md-8">
                        <a data-toggle="modal" href="<?php echo base_url('admin/patients'); ?>" class="btnClientDetails">Return to Clients</a>
                        
                    </div> -->
                </div>

                <div class="modal-footer">
                    <a class="btn btn-success btnAddUser col-sm-4" data-toggle="modal" href="#client-modal" style="max-width: 110px"> <i class="fa fa-plus"></i> Add Client</a>
                    <a class="btn btn-success createNoteForm col-sm-4" id="createNoteForm" data-toggle="modal" href="#createNote" style="max-width: 110px">Create Note</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div id="client-modal" class="modal fade" tabindex="-1" aria-hidden="true">
    </div>

    <div id="appointment-confirmation-modal" class="modal fade">
    </div>

    <div id="past_appointment-confirmation-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-header modal-header-confirm">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
                <h4 class="modal-title">You can not add an appointment for past time.</h4>
            </div>
        </div>
    </div>

    <div id="eventDelete" class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Event</h4>
                </div>
                <div class="modal-body alert-message">
                    <p style="margin: 10px 0px; font-size: 15px;"></p>
                </div>
                <div style="margin: 10px;">
                    <button type="button" class="btn btn-success     modeldeleteyes" data-action="" data-patientid data-dismiss="modal" value="Yes">Yes</button>
                    <button type="button" class="btn btn-danger no" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div id="createNote" class="modal fade">
    </div>

    <?php include_once 'footer.php'; ?>
</div>
<script>
    $(document).ready(function() {
        var base_url = '<?php echo base_url(); ?>';
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();
        $('.selectpicker').select2({
            multiple: false
        });

        $('.start_time').datetimepicker({
            format: 'hh:mm A',
            // minDate:new Date(),
        });

        $('.meeting_duration').datetimepicker({
            format: 'hh:mm',
            // minDate:new Date(),
        });

        $('.schedule_date').datetimepicker({
            // format: 'YYYY-MM-DD',
            format: 'DD-MM-YYYY',
            minDate: new Date(),
            // minDate: new Date(currentDate, currentMonth, currentYear),
        });

        $(document).on('click', '.btnAddUser', function() {
            $('#event-modal').modal('hide');
            $('#client-modal').find('.modal-title').html('Add Client')
            $('.error').html('');

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/loadCreateUserView',
                success: function(result) {
                    $('#client-modal').html(result);
                    $('#client-modal').find('.btnSaveClient').hide();
                },
                complete: function() {},
                error: function(data) {
                    console.log(data);
                }
            })

            //reset field values
            $('.patientid').val("");
            $('.firstname').val("");
            $('.lastname').val("");
            $('.email').val("");
            $('.phone').val("");
            $('.password').val("");
            $('.confirmpassword').val("");
            $('.dateofbirth').val("");
            $('.physicaladdress').val("");
            $('.street').val("");
            $('.city').val("");
            $('.postal_code').val("");
            $('.country').val("");
            $('.emergencycontactname').val("");
            $('.emergencycontact').val("");

            $('.assignes_ex_div').html("");
            $('#exgeneral_list_to').find('option').remove();
        });

        // $('#appointment-confirmation-modal').find("#btnCheckout").click(function(item) {
        //     $('#appointment-confirmation-modal').modal('hide');
        //     var event_id = currentEvent.id;
        //     $.ajax({
        //         type: 'POST',
        //         url: base_url + 'admin/appointment/checkOutAppointment',
        //         data: {
        //             event_id: event_id,
        //         },
        //         success: function(actionResponse) {
        //             $('#calendar').fullCalendar('destroy');
        //             fullCalendar($apiUrl = 'admin/home/getEvents');
        //         },
        //         error: function(data) {
        //             console.log(data);
        //         }
        //     });
        // });

        $(document).on('click', '#btnUpdateClient', function() {
            $('#event-modal').modal('hide');
            $('#client-modal').find('.modal-title').html('Update Client')
            $('.error').html('');
            // $('#client-modal').find('.btnsaveuser').hide();
            // $('#client-modal').find('.btnSaveClient').show();
            var selectedClientId = $('#client_id').val();

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/loadCreateUserView',
                success: function(result) {
                    $('#client-modal').html(result);
                    $('#client-modal').find('.btnsaveuser').hide();
                    $('#client-modal').find('.btnsaveclientuser').hide();
                },
                complete: function() {},
                error: function(data) {
                    console.log(data);
                }
            })

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/getPatientDetails/' + selectedClientId,
                success: function(actionResponse) {
                    var clientData = JSON.parse(actionResponse);
                    $('.patientid').val(selectedClientId);
                    $('.firstname').val(clientData['data']['firstname']);
                    $('.lastname').val(clientData['data']['lastname']);
                    $('.email').val(clientData['data']['email']);
                    $('.phone').val(clientData['data']['phone']);
                    $('.password').val(clientData['data']['password']);
                    $('.confirmpassword').val(clientData['data']['password']);
                    $('.dateofbirth').val(clientData['data']['date_of_birth']);
                    $('.physicaladdress').val(clientData['data']['physical_address']);
                    $('.emergencycontact ').val(clientData['data']['emergency_contact']);
                    $('.street').val(clientData['data']['street']);
                    $('.city').val(clientData['data']['city']);
                    $('.postal_code').val(clientData['data']['postal_code']);
                    $('.country').val(clientData['data']['country']);
                    $('.emergencycontactname').val(clientData['data']['emergency_contact_name']);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(".clientSelect").change(function (item) {
            var data = $(this).find('#client_id').val();
            $('.notify_selected_mail').html('');
            if(data){
                $.each(data, function (index, val) {
                    var selectedClientData = $('option[value="'+val+'"]').data();
                    var name_cust = selectedClientData['clientname'];
                $('.notify_selected_mail').append("<lable style='padding:3px;'>" + name_cust +  "</lable><input type='checkbox' class='notify_client_mail' id='notify_client_mail' name='notify_client_mail' value='" + val + "'/>");                
            })
            }            
        });
    });
</script>
<style type="text/css">
    .modal-header-confirm {
        border-radius: 25px;
    }

    .badge {
        background-color: #0395E2;
        margin: 2px;
    }

    .client-portal-button {
        line-height: 1.50;
        border: 1px solid;
        border-radius: 5px;
        padding: 0px 25px;
        text-decoration: none;
        font-size: 20px;
        margin-top: 15px;
        background-color: #0395E2;
        color: white;
    }

    .save-client {
        line-height: 1.75;
        border-radius: 5px;
        padding: 0px 20px;
        text-decoration: none;
        font-size: 20px;
        margin-top: 20px;
        margin-left: 10px
    }
</style>