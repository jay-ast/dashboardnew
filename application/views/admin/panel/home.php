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
                                    echo '<option value="' . $clientfolder['id'] . '" data-name="' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] .'">' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] . '</option>';
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
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="client_id">Client Name</label>
                            <div class="col-md-4">
                                <select class="form-control selectpicker client_id" id="client_id" name="client_id">
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

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="client_email">Client Email</label>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" class="form-control client_email" id="client_email" name="client_email" readonly>
                            </div>
                        </div>

                        <div class="form-group">
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

                        <!-- <div class="form-group">
                            <label class="col-md-4 control-label" for="meeting_duration">Meeting Duration</label>
                            <div class="col-md-4">
                            <input autocomplete="off" type="text" class="form-control meeting_duration" id="meeting_duration" name="meeting_duration">                                
                            </div>
                        </div>   -->
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
                                    <option value="pilates">Pilates</option>
                                    <option value="physical_therapy">Physical therapy</option>
                                    <option value="fitness">Fitness</option>
                                    <option value="consultation">Consultation</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group recurrence_group">
                            <label class="col-md-4 control-label" for="recurrence">Recurrence</label>
                            <div class="col-md-4">
                                <select class="form-control recurrence" id="recurrence" name="recurrence">
                                    <option value="daily" selected>Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="no_fixed_time">None</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group repeating_weeks_group">
                            <label class="col-md-4 control-label" for="repeating_weeks">Number Of Repetition</label>
                            <div class="col-md-4">
                                <select class="form-control repeating_weeks" id="repeating_weeks" name="repeating_weeks">
                                    <?php
                                    $total_days = range(0, 15);
                                    foreach ($total_days as $key => $minutes) {
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
                            <label class="col-md-4 control-label" for="brief_note">Brief Details</label>
                            <div class="col-md-4">
                                <textarea autocomplete="off" type="textarea" class="form-control brief_note" id="brief_note" name="brief_note">
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="brief_note">Notify With Mail</label>
                            <div class="col-md-4">
                                <input type="checkbox" class="notify_mail" id="notify_mail" name="notify_mail" />
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

    <div id="client-modal" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <?php echo form_open(base_url('admin/patients/updatePatient'), array("class" => "patientForm")); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
                    <h3 class="modal-title">Client Details</h3>
                </div>

                <div class="modal-body modelform ">
                    <div class="error"></div>
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control patientid" name="patientid" value="">
                            </div>
                        </div>
                        <div class="col-md-12 userdetail">
                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>First Name</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="firstname form-control firstname" id="firstname" name="firstname" placeholder="First Name" />
                                </div>
                            </div>
                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="lastname form-control lastname" id="lastname" name="lastname" placeholder="Last Name" />
                                </div>
                            </div>
                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Email</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input id="email" type="text" class="form-control email" id="email" name="email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="row margin-top-10 hidden userdetails">
                                <div class="form-group col-md-4">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="password" id="patientpassword" class="form-control  password" name="password" placeholder="Password" />
                                </div>
                            </div>

                            <div class="row margin-top-10 hidden userdetails">
                                <div class="form-group col-md-4">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="password" class="form-control confirmpassword " name="confirmpassword" placeholder="Confirm Password" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Phone</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="number" class="form-control phone" id="phone" name="phone" maxlength="15" placeholder="Phone" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Date Of Birth</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="date" class="form-control dateofbirth" id="dateofbirth" name="date_of_birth" maxlength="15" value="" placeholder="DOB" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Physical Address</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control physicaladdress" id="physicaladdress" name="physical_address" value="" placeholder="Physical Address" />
                                </div>
                            </div>


                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Street</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control street" id="street" name="street" placeholder="Street" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>City</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control city" id="city" name="city" placeholder="City" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Postal Code</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control postal_code" id="postal_code" name="postal_code" placeholder="Postal Code" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Country</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control country" id="country" name="country" placeholder="Country" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Emergency Contact Name</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control emergencycontactname" id="emergencycontactname" name="emergency_contact_name" value="" placeholder="Emergency Contact Name" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails">
                                <div class="form-group col-md-4">
                                    <label>Emergency Contact</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="number" class="form-control emergencycontact" id="emergencycontact" name="emergency_contact" maxlength="15" value="" placeholder="Emergency Contact" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12" style="display: flex; justify-content: center;">
                        <button type="button" class="btn btn-success btnsaveuser save-client" name="btnsaveuser" formaction="<?php echo base_url('admin/patients/addNewPatient'); ?>">Add Client</button>
                        <button type="button" class="btn btn-success btnSaveClient update-client" name="btnSaveClient" formaction="<?php echo base_url('admin/patients/updatePatient'); ?>">Update Client</button>
                    </div>
                    <div id="loader" class="lds-dual-ring hidden overlay"></div>
                    <div class="clearfix"></div>

                    <?php echo form_close(); ?>
                </div>
                <!-- /.modal-content -->
            </div>

        </div>
    </div>

    <div id="appointment-confirmation-modal" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
                    <h3 class="modal-title">Please Confirm</h3>
                </div>

                <div class="modal-body modelform ">
                    <div class="col-md-12" style="display: flex; justify-content: center;">
                        <button type="button" class="btn btn-primary btnEditAppointment edit-appointment-confirmation" style="margin: 4px;" id="btnEditAppointment" name="btnEditAppointment">Edit Existing Appointment</button>
                        <button type="button" class="btn btn-success btnCreateAppointment edit-appointment-confirmation" style="margin: 4px;" id="btnCreateAppointment" name="btnCreateAppointment">Create New Appointment</button>
                    </div>
                    <!-- <div id="loader" class="lds-dual-ring hidden overlay"></div> -->
                    <div class="clearfix"></div>

                    <!-- <?php echo form_close(); ?> -->
                </div>
                <!-- /.modal-content -->
            </div>

        </div>
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
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert!!</h4>
                </div>
                <div class="modal-body alert-message">
                    <p style="margin: 10px 0px; font-size: 15px;"></p>
                </div>
                <!-- dialog buttons -->
                <div style="margin: 10px;">
                    <button type="button" class="btn btn-danger modeldeleteyes" data-action="" data-patientid data-dismiss="modal" value="Yes">Yes</button>
                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
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
        $('.selectpicker').select2();

        $('.start_time').datetimepicker({
            format: 'hh:mm A',
            // minDate:new Date(),
        });

        $('.meeting_duration').datetimepicker({
            format: 'hh:mm',
            // minDate:new Date(),
        });

        $('.schedule_date').datetimepicker({
            format: 'YYYY-MM-DD',
            // minDate: new Date(),
            minDate: new Date(currentYear, currentMonth, currentDate),
        });

        $(document).on('click', '.btnAddUser', function() {
            $('#event-modal').modal('hide');
            $('#client-modal').find('.modal-title').html('Add Client')
            $('.error').html('');
            $('#client-modal').find('.btnsaveuser').show();
            $('#client-modal').find('.btnSaveClient').hide();

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

        $(document).on('click', '#btnUpdateClient', function() {
            $('#event-modal').modal('hide');
            $('#client-modal').find('.modal-title').html('Update Client')
            $('.error').html('');
            $('#client-modal').find('.btnsaveuser').hide();
            $('#client-modal').find('.btnSaveClient').show();
            var selectedClientId = $('#client_id').val();

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
</style>