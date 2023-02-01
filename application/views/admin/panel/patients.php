<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Clients</h1>
    <div class="innerAll spacing-x2">
        <!-- Widget -->
        <div class="extraCustomMessage">
            <?php if ($this->session->flashdata('message') != '') { ?>
                <div class="alert alert-<?php echo $this->session->flashdata('message')['classname']; ?>">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $this->session->flashdata('message')['data']; ?>
                </div>
            <?php } ?>
        </div>
        <div class="alert alert-info displaymessage hidden">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p></p>
        </div>
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none">
                <div class="row">
                    <?php echo form_open(base_url('admin/patients')); ?>
                    <div class="col-md-5"><input id="nameSearch" type="text" class="form-control" placeholder="<?php
                                                                                                                if (isset($fullname)) {
                                                                                                                    echo $fullname;
                                                                                                                } else {
                                                                                                                    echo 'Name';
                                                                                                                }
                                                                                                                ?>" name="fullname" />
                    </div>

                    <div class="col-md-5">
                        <input id="emailSearch" type="text" class="form-control" placeholder="<?php
                                                                                                if (isset($email)) {
                                                                                                    echo $email;
                                                                                                } else {
                                                                                                    echo 'Login Information';
                                                                                                }
                                                                                                ?>" name="email" />
                    </div>


                    <div class="col-md-2">
                        <a class="btn btn-success btnAddUser col-sm-12" data-toggle="modal" href="#responsiveUserdetails"> <i class="fa fa-plus"></i> Add</a>
                    </div>

                    <?php echo form_close(); ?>
                    <table class="dynamicTable tableTools table table-striped checkboxs">
                        <!-- Table heading -->
                        <thead>
                            <tr class=" text-center">
                                <th>Name</th>
                                <th>Login Information</th>
                                <th>Phone</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <!-- // Table heading END -->
                        <!-- Table body -->
                        <tbody id="myTable">
                            <?php
                            if (isset($patientlist)) {
                                foreach ($patientlist as $userdatalist) {
                                    $patient_name = $userdatalist['firstname'] . " " . $userdatalist['lastname'];
                            ?>
                                    <tr class="gradeX " data-id="333333" id="patient-<?php echo $userdatalist['id']; ?>">

                                        <!-- <td><a data-toggle="modal" href="#responsiveUserdetails" data-patientid="<?php echo $userdatalist['id']; ?>" class="btnPatientDetails">
                                                <?php echo $patient_name; ?>
                                            </a>
                                        </td> -->

                                        <td><a data-toggle="modal" href="#clientPortal" data-patientid="<?php echo $userdatalist['id']; ?>" class="clientPortalDetails">
                                                <?php echo $patient_name; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $userdatalist['email'] . " (" . $userdatalist['password'] . ")"; ?></td>
                                        <td><?php echo $userdatalist['phone']; ?></td>
                                        <td class="center">


                                            <a href="mailto:<?php echo $userdatalist['email']; ?>?Subject=Your%20Video%20Routine%20From%20Perfect%20Forms&body=To%20view%20your%20videos%3A%0A%0A1-%20Download%20our%20Perfect%20Forms%20app%20from%20App%20Store(IOS)%3A%20<?php echo APP_ITUNES_LINK ?>%20or%0A2-%20Download%20our%20Perfect%20Forms%20app%20from%20Google%20Play%20Store(Android)%3A%20<?php echo APP_PLAYSTORE_LINK ?>%20%0A3-%20Log%20into%20<?php echo APP_WEBAPP_LINK ?>%20from%20any%20device%20or%20computer.%0A%0AYour%20username%20and%20password%20are%3A%0AUsername%3A%20<?php echo urlencode($userdatalist['email']) ?>%0APassword%3A%20<?php echo urlencode($userdatalist['password']) ?>" target="_top">





                                                <i class="fa fa-envelope" data-toggle="tooltip" title="Send Mail"></i></a>
                                            <a class="deleteBtn" data-patientid="<?php echo $userdatalist['id']; ?>" data-patientname="<?php echo $patient_name; ?>" data-action="delete" data-toggle="modal" href="#deleteWarning">
                                                <i class="glyphicon glyphicon-trash " data-toggle="tooltip" title="Delete User"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr class="gradeX"><td colspan="5" class="text-center">No Clients available.</td></tr>';
                            }
                            ?>
                        </tbody>
                        <!-- // Table body END -->
                    </table>
                    <!-- // Table END -->
                    <div class="jquery-bootpag-pagination pull-right">
                        <ul id="myLinks" class="bootpag pagination">

                            <!-- Show pagination links -->
                            <?php
                            foreach ($links as $link) {
                                echo "<li>" . $link . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--Model user details-->
    <div id="responsiveUserdetails" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <?php echo form_open(base_url('admin/patients/updatePatient'), array("class" => "patientForm")); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
                    <h3 class="modal-title">Client Details</h3>
                </div>

                <!-- <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12" style="display: flex;justify-content: center;">
                            <button style="margin-right: 3px;" type="button" class="btn btn-success btnaddselectex"><i class="fa fa-arrow-circle-o-down"></i> Assigned Selected Exercise</button>
                                <a style="margin-left: 3px;" type="submit" class="btn btn-success btnupdateclientuser" href="">Create New Routine</a>                                                      
                        </div>
                    </div>
                </div> -->

                <div class="modal-body modelform ">
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control patientid" name="patientid" value="">
                            </div>
                        </div>
                        <div class="col-md-12 userdetail">
                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>First Name</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="firstname form-control firstname" name="firstname" placeholder="First Name" />
                                </div>
                            </div>
                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Last Name</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="lastname form-control lastname" name="lastname" placeholder="Last Name" />
                                </div>
                            </div>
                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Email</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input id="email" type="text" class="form-control email" name="email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="row margin-top-10 hidden userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="password" id="patientpassword" class="form-control  password" name="password" placeholder="Password" />
                                </div>
                            </div>

                            <div class="row margin-top-10 hidden userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="password" class="form-control confirmpassword " name="confirmpassword" placeholder="Confirm Password" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Phone</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control phone" name="phone" placeholder="Phone" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Date Of Birth</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="date" class="form-control dateofbirth" name="date_of_birth" maxlength="15" value="" placeholder="DOB" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Physical Address</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control physicaladdress" name="physical_address" value="" placeholder="Physical Address" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Street</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control street" id="street" name="street" placeholder="Street" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>City</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control city" id="city" name="city" placeholder="City" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Postal Code</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control postal_code" id="postal_code" name="postal_code" placeholder="Postal Code" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Country</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control country" id="country" name="country" placeholder="Country" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Emergency Contact Name</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control emergencycontactname" id="emergencycontactname" name="emergency_contact_name" value="" placeholder="Emergency Contact Name" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Emergency Contact</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control emergencycontact" name="emergency_contact" maxlength="15" value="" placeholder="Emergency Contact" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-6">
                                <div class="form-group col-md-3">
                                    <label>Total Appointments</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control appointment_count" name="appointment_count" maxlength="15" value="" placeholder="Total Appointments" readonly />
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group col-md-6">
                            <label class="col-md-4 control-label" for="client_id">Client Name</label>
                            <div class="col-md-4">
                                <select class="form-control selectpicker client_id" id="client_id" name="client_id">
                                </select>
                            </div>
                        </div> -->

                        <!-- <div v-if="activeItem.fullname" class="routinelist">
                            <div class="col-md-6">
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-12">
                                        <label>Saved General Routines</label>
                                        <input type="text" v-model="generalvideosearch" id="search_general_routine" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                        <select multiple class="form-control ex_list_to" id="exgeneral_list_to">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-12">
                                        <label>Saved Client Routines</label>
                                        <input type="text" id="clientvideosearch" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                        <select multiple class="form-control ex_list_to" id="exclient_list_to">
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row margin-top-10">
                                    <div class="col-md-12" style="display: flex;justify-content: center;">
                                        <button style="margin-right: 3px;" type="button" class="btn btn-success btnaddselectex"><i class="fa fa-arrow-circle-o-down"></i> Assigne Selected Exercise</button>
                                        <a style="margin-left: 3px;" type="submit" class="btn btn-success btnupdateclientuser" href="">Create New Routine</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label>Assigned Routines</label>
                                    <div class="assignes_ex_div">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-md-12" style="display: flex; justify-content: center;">                        
                        <button type="submit" class="btn btn-success btnsaveclientuser new-routine" name="btnsaveclientuser" formaction="<?php echo base_url('admin/patients/addNewPatient'); ?>">Add and create new routine</button>                        
                        <button type="submit" class="btn btn-success btnsaveuser save-client" name="btnsaveuser" formaction="patients/addNewPatient">Add Client</button>
                    </div>

                    <div class="clearfix"></div>
                    <div class="modal-footer">                        
                        <a class="send-mail" id="mailto" href="#" style="float: left;" target="_top">Send e-mail</a>
                        <button type="submit" class="btn btn-success btnupdateuser" formaction="<?php echo base_url('admin/patients/updatePatient'); ?>">Update</button>
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>


                    <?php echo form_close(); ?>
                </div>
                <!-- /.modal-content -->
            </div>

        </div>
    </div>
    <!-- /.modal-dialog -->
    <div id="deleteWarning" class="modal fade">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger modeldeleteyes" data-action="" data-patientid data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div id="clientPortal" class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body modelform">
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control patientid" name="patientid" value="">
                            </div>
                        </div>
                        <div class="col-md-12 userdetail">
                            <div class="row margin-top-10 userdetails col-md-12">
                                <div class="form-group col-md-4">
                                    <label>Email Address</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control client_portal_email" name="client_portal_email" placeholder="First Name" readonly />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-12">
                                <div class="form-group col-md-4">
                                    <label>Phone Number</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control client_portal_phone_number" name="client_portal_phone_number" placeholder="Phone Number" readonly />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-12">
                                <a data-toggle="modal" class="client-detail-button btnPatientDetails" style="float: right;" href="#responsiveUserdetails" target="_top">Client Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <button type="button" class="client-portal-button" data-toggle="modal" target="_top" href="#schedulePortal" id="scheduleDetails">Schedule</button>
                                <button type="button" class="client-portal-button" data-toggle="modal" target="_top" href="#accountPortal" id="accountDetails">Account</button>
                                <button type="button" class="client-portal-button" data-toggle="modal" target="_top" href="#notePortal" id="noteDetails">Note</button>
                                <button type="button" class="client-portal-button routineDetails" data-toggle="modal" target="_top" href="#routinePortal" id="routineDetails">Routine</button>
                                <a class="btn btn-mail client-portal-button" data-toggle="modal" href="#" target="_top" id="client_protal_mailto">Send e-mail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="schedulePortal" class="modal fade">
    </div>

    <div id="notePortal" class="modal fade">
    </div>

    <div id="editNotesDetails" class="modal fade">
    </div>

    <div id="deleteNote" class="modal fade">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger deleteNotesDetails" data-action="" data-noteid data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div id="accountPortal" class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <?php echo form_open(base_url('admin/patients/addNewNotes')); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <a style="float: right; margin-right: 20px;" href="<?php echo base_url('admin/patients'); ?>">Return to client portal</a>
                    <h4 class="modal-title">Client Name: </h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 notesDetail">
                            <table class="dynamicTable tableTools table table-striped checkboxs">
                                <thead>
                                    <tr class=" text-center">
                                        <th>Visit number</th>
                                        <th>Date</th>
                                        <th>Service</th>
                                        <th>Price</th>
                                        <th>Payment received Amount &date</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <div id="createNote" class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create New Note</h4>
                </div>

                <div class="modal-body modelform">
                    <div class="error"></div>
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control patientid" name="patientid" value="">
                            </div>
                        </div>
                        <div class="col-md-12 userdetail">
                            <div class="row margin-top-10 userdetails col-md-12">
                                <div class="form-group col-md-4">
                                    <label>Subjective</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <textarea type="text" class="form-control subjective" rows="6" id="subjective" name="subjective" placeholder="Subjective"></textarea>
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-12">
                                <div class="form-group col-md-4">
                                    <label>Objective</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control objective" id="objective" name="objective" placeholder="Objective" />
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-12">
                                <div class="form-group col-md-4">
                                    <label>Assessment</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <textarea type="text" class="form-control assessment" rows="6" id="assessment" name="assessment" placeholder="Assessment"></textarea>
                                </div>
                            </div>

                            <div class="row margin-top-10 userdetails col-md-12">
                                <div class="form-group col-md-4">
                                    <label>Plan</label>
                                </div>
                                <div class="form-group col-md-8">
                                    <textarea type="text" class="form-control plan" id="plan" rows="6" name="plan" placeholder="Plan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <button type="button" class="client-portal-button" data-toggle="modal" target="_top" href="#" id="addNoteDetails">Add Note</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="routinePortal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <?php echo form_open(base_url('admin/patients/updateRoutine'), array("class" => "routineForm")); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
                    <a style="float: right; margin-right: 20px;" href="<?php echo base_url('admin/patients'); ?>">Return to client portal</a>
                    <h3 class="modal-title"></h3>
                </div>
                <div class="modal-body modelform ">
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control patientid" name="patientid" value="">
                            </div>
                        </div>
                        <div v-if="activeItem.fullname" class="routinelist">
                            <div class="col-md-6">
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-12">
                                        <label>Saved General Routines</label>
                                        <input type="text" v-model="generalvideosearch" id="search_general_routine" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                        <select multiple class="form-control ex_list_to" id="exgeneral_list_to">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-12">
                                        <label>Saved Client Routines</label>
                                        <input type="text" id="clientvideosearch" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                        <select multiple class="form-control ex_list_to" id="exclient_list_to">
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row margin-top-10">
                                    <div class="col-md-12" style="display: flex;justify-content: center;">
                                        <button style="margin-right: 3px;" type="button" class="btn btn-success btnaddselectex"><i class="fa fa-arrow-circle-o-down"></i> Assigne Selected Exercise</button>
                                        <a style="margin-left: 3px;" type="submit" class="btn btn-success btnupdateclientuser" href="">Create New Routine</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label>Assigned Routines</label>
                                    <div class="assignes_ex_div">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btnupdateroutine" formaction="<?php echo base_url('admin/patients/updateRoutine'); ?>">Update</button>
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>


                    <?php echo form_close(); ?>
                </div>
                <!-- /.modal-content -->
            </div>

        </div>
    </div>

    <div id="ExerciseWarning" class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times-circle-o"></i></button>
                    <h3 class="modal-title">Alert!!</h3>
                </div>
                <div class="modal-body alert-message">
                    <p></p>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger deleteroutine" data-action="" data-patientid>Delete?</button>
                    <a href="#" class="btn btn-success no editroutine" role="button">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<script>
    $(document).ready(function() {
        var base_url = '<?php echo base_url(); ?>';
        var clientexercies = [];
        var generalexercies = [];
        var exerciesvideos = [];
        var generalexerc;
        $('#exgeneral_list_to').html('')
        createClientUser = function(me) {
            var formaction = $(me).attr("formaction")
            /*
            	
            	$.ajax({ 
                type: 'POST', 
                url: formaction, 
                data: { action: "getNewReQuest", medtype: "1"}, 
                dataType: 'json',
                success: function (data) { 
                   console.info(data)
            	});

            	alert(formaction)
            	}
            */
        }
        // $('[data-toggle="tooltip"]').popover()

        $("#email").keyup(function() {
            $("#email").removeClass("error")
        })
        <?php foreach ($generalexercies as $exdata) { ?>
            var id = <?php echo $exdata['id']; ?>;
            var text = "<?php echo $exdata['name']; ?>";
            var folderid = "<?php echo $exdata['folderid']; ?>";
            generalexercies.push({
                'id': id,
                'name': text,
                'folderid': folderid
            });
            $('#exgeneral_list_to').append("<option data-test='AAAAAAAA' value='" + id + "' title='" + text + "' data-folderid=" + folderid + "'>" + text + "</option>");
        <?php } ?>
        $("#generalvideosearch").on('input', function(e) {
            var value = this.value.toLowerCase().trim();
            var assignedexe = new Array();

            $('.assignes_ex_div').find('input').each(function() {
                assignedexe.push($(this).val());
            });
            $('#exgeneral_list_to').html('')
            for (var key in generalexercies) {
                var id = generalexercies[key]['id'];
                var text = generalexercies[key]['name'];
                var folderid = generalexercies[key]['folderid'];
                //console.log($.inArray(id, assignedexe) == -1)

                if (jQuery.inArray(id.toString(), assignedexe) == '-1') {
                    if (value == '') {
                        $('#exgeneral_list_to').append('<option value="' + id + '"  title="' + text + '" data-test="111111111" data-folderid="' + folderid + '">' + text + '</option>');
                    } else {


                        $val = text.toLowerCase().trim();
                        var not_found = ($val.indexOf(value) == -1);

                        if (!not_found) {
                            $('#exgeneral_list_to').append('<option value="' + id + '" title="' + text + '">' + text + '</option>');
                        }

                    }
                }


            }

        });

        $("#emailSearch").keyup(function() {
            $("#nameSearch").keyup()
        })
        $("#nameSearch").keyup(function() {
            $.ajax({
                type: 'POST',
                url: '/admin/patients/index_search',
                data: {
                    fullname: $("#nameSearch").val(),
                    email: $("#emailSearch").val()
                },
                dataType: 'json',
                success: function(data) {
                    console.info(data)
                    $("#myTable").html("");
                    var patients = data.patientlist;
                    var links = data.links;
                    console.info(patients)
                    $("#myLinks").html('')
                    links.forEach(function(link) {
                        $("#myLinks").append("<li>" + link + "</li>");
                    })


                    patients.forEach(function(patient) {
                        $("#myTable").append(`<tr class="gradeX testing" id="patient-` + patient.id + `">      

                                        <td><a data-toggle="modal" href="#clientPortal" 
                                               data-patientid="` + patient.id + `"                                                           
                                               class="clientPortalDetails">
                                                   ` + patient.myfullname + `
                                            </a>  
                                        </td>
                                        <td>` + patient.logininformation + `</td>
                                        <td>` + patient.phone + `</td>                                       
                                        <td class="center">
                                         
	                                            
	                                             <a href="mailto:` + patient.email + `?Subject=Your%20Video%20Routine%20From%20Perfect%20Forms&body=To%20view%20your%20videos%3A%0A%0A1-%20Download%20our%20Perfect%20Forms%20app%20from%20App%20Store(IOS)%3A%20<?php echo APP_ITUNES_LINK ?>%20or%0A2-%20Download%20our%20Perfect%20Forms%20app%20from%20Google%20Play%20Store(Android)%3A%20<?php echo APP_PLAYSTORE_LINK ?>%20%0A3-%20Log%20into%20<?php echo APP_WEBAPP_LINK ?>%20from%20any%20device%20or%20computer.%0A%0AYour%20username%20and%20password%20are%3A%0AUsername%3A%20` + patient.email + `%0APassword%3A%20` + patient.password + `" target="_top">
		                                             
	                                            
	                                            
	                                            
	                                            
                                                <i class="fa fa-envelope" data-toggle="tooltip" title="Send e-mail"></i></a>  
                                            <a class="deleteBtn" data-patientid="` + patient.id + `" 
                                               data-patientname="` + patient.myfullname + `"
                                               data-action="delete" data-toggle="modal" href="#deleteWarning" >
                                                <i class="glyphicon glyphicon-trash " data-toggle="tooltip" title="Delete User"></i></a></td>
                                    </tr>`)
                    });

                }
            });
        })


        $("#clientvideosearch").on('input', function(e) {
            var value = this.value.toLowerCase().trim();
            var assignedexe = new Array();

            $('.assignes_ex_div').find('input').each(function() {
                assignedexe.push($(this).val());
            });
            $('#exclient_list_to').html('')
            for (var key in clientexercies) {
                var id = clientexercies[key]['id'];
                var text = clientexercies[key]['name'];
                var folderid = clientexercies[key]['folderid'];
                //console.log($.inArray(id, assignedexe) == -1)

                if (jQuery.inArray(id.toString(), assignedexe) == '-1') {
                    if (value == '') {
                        $('#exclient_list_to').append('<option value="' + id + '" title="' + text + '" data-test="222222" data-folderid="' + folderid + '">' + text + '</option>');
                    } else {


                        $val = text.toLowerCase().trim();
                        var not_found = ($val.indexOf(value) == -1);

                        if (!not_found) {
                            $('#exclient_list_to').append('<option value="' + id + '" title="' + text + '">' + text + '</option>');
                        }

                    }
                }


            }

        });

        // delete warning model
        $(document).on('click', '.deleteBtn', function() {
            var patientid = $(this).attr('data-patientid');
            var patient_name = $(this).attr('data-patientname');
            var action = $(this).data('action');
            $(".modeldeleteyes").attr('data-patientid', patientid);
            $(".modeldeleteyes").attr('data-patientname', patient_name);
            $(".modeldeleteyes").attr('data-action', action);
            $("#deleteWarning p").html("Do you realy want to delete this Client <strong>" + patient_name + "</strong>?");
            $("#deleteWarning").modal('show');
            return false;
        });

        //if user accept to delete park from model then process request
        $(document).on('click', '.modeldeleteyes', function() {
            var patientid = $('.modeldeleteyes').attr('data-patientid');
            var patient_name = $('.modeldeleteyes').attr('data-patientname');
            var action = $('.modeldeleteyes').attr('data-action');

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/deletePatient/' + patientid,
                success: function(deleteAction) {
                    var deleteuserdata = JSON.parse(deleteAction);
                    var extraMessageHtml = "";
                    if (deleteuserdata['status'] == true) {
                        extraMessageHtml = '<div class="alert alert-success">User <strong>' + patient_name + '</strong> deleted successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    } else {
                        extraMessageHtml = '<div class="alert alert-danger">Error while deleting Client <strong>' + patient_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    }
                    $('.extraCustomMessage').html(extraMessageHtml);
                    $('#patient-' + patientid).fadeOut(1500);
                    return false;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '.btnsaveclientuser', function() {
            $(this).val('save');
            $('.patientForm').attr('action', $(this).attr('formaction'))
        });
        $(document).on('click', '.btnsaveuser', function(e) {
            $(this).val('save');
            //return false;
        })

        $(document).on('click', '.btnupdateuser', function(e) {
            $('.btnsaveclientuser').val('save');
            $('.patientForm').attr('action', $(this).attr('formaction'))
            //return false;
        })

        $(document).on('click', '.btnupdateroutine', function(e) {
            $('.btnsaveclientuser').val('save');
            $('.routineForm').attr('action', $(this).attr('formaction'))
            //return false;
        })

        $(document).on('click', '.btnAddUser', function() {
            $('#responsiveUserdetails').find('.modal-dialog').css('width', '50%');
            $('#responsiveUserdetails').find('.userdetail').removeClass('col-md-12');
            $('#responsiveUserdetails').find('.userdetail').addClass('col-md-12');
            $('#responsiveUserdetails').find('.userdetails').removeClass('col-md-6');
            $('#responsiveUserdetails').find('.userdetails').addClass('col-md-12');
            $('.btnsaveuser').removeClass('hidden');
            $('.btnsaveclientuser').removeClass('hidden');
            $('.btnupdateuser').addClass('hidden');
            $('.btnupdateclientuser').addClass('hidden');
            $('.userdetail').removeClass('hidden');
            $('.routinelist').addClass('hidden');
            $('.fa-envelope').addClass('hidden');

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
            $('.emergencycontact').val("");
            $('.street').val("");
            $('.city').val("");
            $('.postal_code').val("");
            $('.country').val("");
            $('.emergencycontactname').val("");

            $('.assignes_ex_div').html("");
            $('#exgeneral_list_to').find('option').remove();

            //generalexercies.push({'id':optionValue, 'name': optionText,'folderid':Folderid});
            for (var key in generalexercies) {
                var id = generalexercies[key]['id'];
                var text = generalexercies[key]['name'];
                var Folderid = generalexercies[key]['folderid'];
                $('#exgeneral_list_to').append('<option data-test="333333" value="' + id + '" data-folderid="' + Folderid + '" title="' + text + '" >' + text + '</option>');
            }
        });


        $(document).on('click', '.routineDetails', function() {
            $('#clientPortal').modal('toggle');
            var patientid = $('#clientPortal').find('.patientid').val();
            $('.btnupdateclientuser').attr('href', base_url + 'admin/exercises/addclientexercise/' + patientid)
            $('.assignes_ex_div').html("");
            $('#ex_list_to').find('option').remove();

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/getPatientDetails/' + patientid,
                success: function(actionResponse) {
                    var patientData = JSON.parse(actionResponse);
                    $('#routinePortal').find('.modal-title').html(patientData['data']['firstname'] + ' ' + patientData['data']['lastname']);
                    $('#exclient_list_to').html('')
                    $('.routinelist').removeClass('hidden');
                    //append exercies and remove from list
                    var exerc = patientData['data']['clientexercies'];
                    var exerclength = exerc.length;
                    for (var i = 0; i < exerclength; i++) {
                        var optionValue = exerc[i]['id'];
                        var optionText = exerc[i]['name'];
                        var Folderid = exerc[i]['folderid'];

                        $('#exclient_list_to').append('<option data-test="444444" value="' + optionValue + '" data-folderid="' + Folderid + '" title="' + optionText + '" >' + optionText + '</option>');
                        clientexercies.push({
                            'id': optionValue,
                            'name': optionText,
                            'folderid': Folderid
                        });
                    }
                    //append exercies and remove from list                    
                    $('#exgeneral_list_to').html('')
                    generalexerc = patientData['data']['generalexercies'];
                    var execvideos = patientData['data']['exerciesvideos'];

                    // $.each(execvideos, function (key, val) {                    
                    gexerclength = generalexerc.length;
                    for (var i = 0; i < gexerclength; i++) {
                        var optionValue = generalexerc[i]['id'];
                        var optionText = generalexerc[i]['name'];
                        var Folderid = generalexerc[i]['folderid'];
                        if (execvideos[optionValue] != undefined) {
                            let titleValue = execvideos[optionValue]["videos"];
                            $('#exgeneral_list_to').append('<option title="' + titleValue + '" data-title="' + titleValue + '" data-toggle="tooltip1" data-test="5555555" value="' + optionValue + '" data-folderid="' + Folderid + '" data-placement="top">' + optionText + '</option>');
                        }
                        generalexercies.push({
                            'id': optionValue,
                            'name': optionText,
                            'folderid': Folderid
                        });
                        // $('[data-toggle="tooltip"]').popover()

                        //remove from list
                        //$('#ex_list_to option[value=' + optionValue + ']').remove();
                    }

                    var assigned = patientData['data']['assingedexercies'];
                    var assignedlength = assigned.length;
                    for (var i = 0; i < assignedlength; i++) {
                        var optionValue = assigned[i]['id'];
                        var optionText = assigned[i]['name'];
                        var Folderid = assigned[i]['folderid'];
                        var Type = assigned[i]['type'];
                        var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                            '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-test="DDDDDDDDD" data-id="' + optionValue + '" data-folderid="' + Folderid + '" data-text="' + optionText + '" data-type="' + Type + '">&times;</button>' +
                            '<span style="line-height: 30px;">' + optionText + '</span>' +
                            '<input type="hidden" name="exercises[]" class="exercises" value="' + optionValue + '"/>' +
                            '</label>';
                        $('.assignes_ex_div').prepend(appen_html);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        //btn get patient details
        $(document).on('click', '.btnPatientDetails', function() {
            $('#clientPortal').modal('toggle');
            $('#responsiveUserdetails').find('.modal-dialog').css('width', '70%');
            $('#responsiveUserdetails').find('.userdetail').removeClass('col-md-12');
            $('#responsiveUserdetails').find('.userdetail').addClass('col-md-12');
            $('#responsiveUserdetails').find('.userdetails').removeClass('col-md-12');
            $('#responsiveUserdetails').find('.userdetails').addClass('col-md-6');
            // var patientid = $(this).attr('data-patientid');
            var patientid = $('#clientPortal').find('.patientid').val();
            $('.btnsaveuser').addClass('hidden');
            $('.btnsaveclientuser').addClass('hidden');
            $('.btnupdateuser').removeClass('hidden');
            $('.btnupdateclientuser').removeClass('hidden');
            $('.btnupdateclientuser').attr('href', base_url + 'admin/exercises/addclientexercise/' + patientid)
            //reset assigned exercise
            $('.assignes_ex_div').html("");
            $('#ex_list_to').find('option').remove();


            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/getPatientDetails/' + patientid,
                success: function(actionResponse) {
                    var patientData = JSON.parse(actionResponse);
                    $('.patientid').val(patientid);
                    $('.firstname').val(patientData['data']['firstname']);
                    $('.lastname').val(patientData['data']['lastname']);
                    $('.email').val(patientData['data']['email']);
                    $('.phone').val(patientData['data']['phone']);
                    $('.password').val(patientData['data']['password']);
                    $('.confirmpassword').val(patientData['data']['password']);
                    $('.dateofbirth').val(patientData['data']['date_of_birth']);
                    $('.physicaladdress').val(patientData['data']['physical_address']);
                    $('.emergencycontact').val(patientData['data']['emergency_contact']);
                    $('.appointment_count').val(patientData['data']['appointment_count'] ?? 0);

                    $('.street').val(patientData['data']['street']);
                    $('.city').val(patientData['data']['city']);
                    $('.postal_code').val(patientData['data']['postal_code']);
                    $('.country').val(patientData['data']['country']);
                    $('.emergencycontactname').val(patientData['data']['emergency_contact_name']);

                    $('#mailto').attr('href', 'mailto:' + patientData['data']['email'] + '?' + encodeURI('Subject=Your Video Routine From Perfect Forms') + '&body=' + 'To%20view%20your%20videos%3A%0D%0A%0D%0A1-%20Download%20our%20Perfect%20Forms%20app%20from%20App%20Store(IOS)%3A%20' + encodeURI('<?php echo APP_ITUNES_LINK ?>') + '%0A2-%20Download%20our%20Perfect%20Forms%20app%20from%20Google%20Play%20Store(Android)%3A%20' + encodeURI('<?PHP echo APP_PLAYSTORE_LINK ?>') + '%20-%20or%20%0D%0A3-%20Log%20into%20' + encodeURI('<?php echo APP_WEBAPP_LINK ?>') + '%20from%20any%20device%20or%20computer.%0D%0A%0D%0AYour%20username%20and%20password%20are%3A%0D%0AUsername%3A%20' + patientData['data']['email'] + '%0D%0APassword%3A%20' + patientData['data']['password']);
                    $('#exclient_list_to').html('')
                    $('.routinelist').removeClass('hidden');
                    //append exercies and remove from list
                    var exerc = patientData['data']['clientexercies'];
                    var exerclength = exerc.length;
                    for (var i = 0; i < exerclength; i++) {
                        var optionValue = exerc[i]['id'];
                        var optionText = exerc[i]['name'];
                        var Folderid = exerc[i]['folderid'];

                        $('#exclient_list_to').append('<option data-test="444444" value="' + optionValue + '" data-folderid="' + Folderid + '" title="' + optionText + '" >' + optionText + '</option>');
                        clientexercies.push({
                            'id': optionValue,
                            'name': optionText,
                            'folderid': Folderid
                        });
                    }
                    //append exercies and remove from list                    
                    $('#exgeneral_list_to').html('')
                    generalexerc = patientData['data']['generalexercies'];
                    var execvideos = patientData['data']['exerciesvideos'];

                    // $.each(execvideos, function (key, val) {                    
                    gexerclength = generalexerc.length;
                    for (var i = 0; i < gexerclength; i++) {
                        var optionValue = generalexerc[i]['id'];
                        var optionText = generalexerc[i]['name'];
                        var Folderid = generalexerc[i]['folderid'];
                        if (execvideos[optionValue] != undefined) {
                            let titleValue = execvideos[optionValue]["videos"];
                            $('#exgeneral_list_to').append('<option title="' + titleValue + '" data-title="' + titleValue + '" data-toggle="tooltip1" data-test="5555555" value="' + optionValue + '" data-folderid="' + Folderid + '" data-placement="top">' + optionText + '</option>');
                        }
                        generalexercies.push({
                            'id': optionValue,
                            'name': optionText,
                            'folderid': Folderid
                        });
                        // $('[data-toggle="tooltip"]').popover()

                        //remove from list
                        //$('#ex_list_to option[value=' + optionValue + ']').remove();
                    }

                    var assigned = patientData['data']['assingedexercies'];
                    var assignedlength = assigned.length;
                    for (var i = 0; i < assignedlength; i++) {
                        var optionValue = assigned[i]['id'];
                        var optionText = assigned[i]['name'];
                        var Folderid = assigned[i]['folderid'];
                        var Type = assigned[i]['type'];
                        console.info(assigned[i])
                        var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                            '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-test="DDDDDDDDD" data-id="' + optionValue + '" data-folderid="' + Folderid + '" data-text="' + optionText + '" data-type="' + Type + '">&times;</button>' +
                            '<span style="line-height: 30px;">' + optionText + '</span>' +
                            '<input type="hidden" name="exercises[]" class="exercises" value="' + optionValue + '"/>' +
                            '</label>';
                        $('.assignes_ex_div').prepend(appen_html);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $('#responsiveUserdetails').on('hidden.bs.modal', function() {
            $('.has-error').children('p').remove('p');
            $('.has-error').removeClass('has-error');
        });
        $(document).on('click', '.btnaddselectex', function() {
            //get selected items
            $(".ex_list_to option:selected").each(function() {
                var optionValue = $(this).val();
                var optionText = $(this).text();

                //alert($(this).parent().attr('id'))
                if ($(this).parent().attr('id') == 'exclient_list_to') {
                    $type = 'client';
                } else {
                    $type = 'general';
                }
                // collect all values
                var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                    '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-test="777777" data-type="' + $type + '" data-id="' + optionValue + '" data-folderid="' + Folderid + '" data-text="' + optionText + '">&times;</button>' +
                    '<span style="line-height: 30px;">' + optionText + '</span>' +
                    '<input type="hidden" name="exercises[]" class="exercises" value="' + optionValue + '"/>' +
                    '</label></div>';
                $('.assignes_ex_div').prepend(appen_html);
                var Folderid = $(this).attr('data-folderid');
                //remove this option
                $(this).remove();
            });

        });
        $(document).on('click', '.btnRemoveExc', function() {
            $patientid = $('.patientid').val();
            $this = $(this);
            var id = $(this).attr('data-id');
            var folderid = $(this).attr('data-folderid');
            var dataTest = $(this).attr('data-test');
            var text = $(this).attr('data-text');
            var type = $(this).attr('data-type');
            //$patientid= $(this).attr('data-folderid');
            $("#ExerciseWarning p").html("Which action you want to perform for <strong>" + text + "</strong>?");
            $('#ExerciseWarning').find('.deleteroutine').attr('data-folderid', $patientid)
            $('#ExerciseWarning').find('.deleteroutine').attr('data-exerciseid', id)
            $('#ExerciseWarning').find('.deleteroutine').attr('data-type', type)
            $('#ExerciseWarning').find('.deleteroutine').attr('data-text', text)
            $('#ExerciseWarning').find('.editroutine').attr('href', base_url + 'admin/exercises/detail/' + id + '/' + folderid + '/')
            $('#ExerciseWarning').modal('show');

        });

        $(document).on('click', '.deleteroutine', function() {

            $this = $(this);
            var objectid = $this.attr('data-exerciseid');
            var folderid = $this.attr('data-folderid');
            var optionText = $this.attr('data-text');
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/deleteassignedExrecise/' + objectid,
                data: {
                    'clientid': folderid
                },
                success: function(deleteAction) {
                    $('.btnRemoveExc').each(function() {
                        if ($(this).attr('data-id') == objectid)
                            $(this).parent('.label').remove()
                    });


                    if ($this.attr('data-type') == 'client') {
                        $('#exclient_list_to').append('<option data-test="8888888" value="' + objectid + '" data-folderid="' + folderid + '" title="' + optionText + '" >' + optionText + '</option>');
                    } else {
                        $('#exgeneral_list_to').append('<option data-test="999999" value="' + objectid + '" data-folderid="' + folderid + '"  title="' + optionText + '" >' + optionText + '</option>');
                    }

                    $('#ExerciseWarning').modal('hide');
                },
                error: function(data) {
                    console.log(data);
                }
            });

        });


        $('#myModal').on('hidden.bs.modal', function(e) {
            // do something...
        });

        $('#search_general_routine').on('keyup', function(e) {
            var search_data = $(this).val();
            $('#exgeneral_list_to').html('');
            generalexerc.filter(function(v, i) {
                let optionValue = v.id;
                let optionText = v.name;
                let Folderid = v.folderid;
                if (v.name.includes(search_data)) {
                    $('#exgeneral_list_to').append('<option data-toggle="tooltip1" data-test="5555555" value="' + optionValue + '" data-folderid="' + Folderid + '" data-placement="top">' + optionText + '</option>');
                }
            })
        });


        $(document).on('click', '.clientPortalDetails', function() {
            var patientid = $(this).attr('data-patientid');

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/getPatientDetails/' + patientid,
                success: function(actionResponse) {
                    var patientData = JSON.parse(actionResponse);
                    var client__portal_name = "Client Portal : " + patientData['data']['firstname'] + ' ' + patientData['data']['lastname'];
                    $('.patientid').val(patientid);
                    $('#clientPortal').find('.modal-title').html(client__portal_name)
                    $('.lastname').val(patientData['data']['lastname']);
                    $('.client_portal_email').val(patientData['data']['email']);
                    $('.client_portal_phone_number').val(patientData['data']['phone']);
                    $('#client_protal_mailto').attr('href', 'mailto:' + patientData['data']['email'] + '?' + encodeURI('Subject=Your Video Routine From Perfect Forms') + '&body=' + 'To%20view%20your%20videos%3A%0D%0A%0D%0A1-%20Download%20our%20Perfect%20Forms%20app%20from%20App%20Store(IOS)%3A%20' + encodeURI('<?php echo APP_ITUNES_LINK ?>') + '%0A2-%20Download%20our%20Perfect%20Forms%20app%20from%20Google%20Play%20Store(Android)%3A%20' + encodeURI('<?PHP echo APP_PLAYSTORE_LINK ?>') + '%20-%20or%20%0D%0A3-%20Log%20into%20' + encodeURI('<?php echo APP_WEBAPP_LINK ?>') + '%20from%20any%20device%20or%20computer.%0D%0A%0D%0AYour%20username%20and%20password%20are%3A%0D%0AUsername%3A%20' + patientData['data']['email'] + '%0D%0APassword%3A%20' + patientData['data']['password']);

                    //append exercies and remove from list

                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '#scheduleDetails', function() {
            $('#clientPortal').modal('toggle');
            var client_id = $('#clientPortal').find('.patientid').val();
            console.log('scheduleDetails', client_id);

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/getScheduleDetails/' + client_id,
                success: function(actionResponse) {
                    $('#schedulePortal').html(actionResponse);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '#noteDetails', function() {	
            $('#clientPortal').modal('toggle');            
            var client_id = $('#clientPortal').find('.patientid').val();            

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/getNotesDetails/' + client_id,
                success: function(actionResponse) {
                    $('#notePortal').html(actionResponse);
                },
                error: function(data) {
                    console.log(data);
                }
            });
            
        });

        $(document).on('click', '#editNotesData', function() {	
            $('#notePortal').modal('toggle');            
            var note_id = $(this).attr('data-noteid');
            console.log('asx', note_id);            
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/editNotesDetails/' + note_id,
                success: function(actionResponse) {
                    $('#editNotesDetails').html(actionResponse);
                },
                error: function(data) {
                    console.log(data);
                }
            });
            
        });

        $(document).on('click', '#updateNoteDetails', function(e) {
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/updateNotesDetails',
                data: {
                    note_id: $('.noteUpdateform').find('#noteid').val(),
                    subjective: $('.noteUpdateform').find('#subjective').val(),
                    objective: $('.noteUpdateform').find('#objective').val(),
                    assessment: $('.noteUpdateform').find('#assessment').val(),
                    plan: $('.noteUpdateform').find('#plan').val(),                    
                },
                success: function(result) {
                    var notesdata = JSON.parse(result);                    
                    var extraMessageHtml = "";
                    $('#editNotesDetails').modal('toggle');
                    if (notesdata['success'] == true) {
                        extraMessageHtml = '<div class="alert alert-success">' + notesdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';                        
                    } else {
                        extraMessageHtml = '<div class="alert alert-danger">' + notesdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    }
                    $('.extraCustomMessage').html(extraMessageHtml);
                },
                complete: function() {},
                error: function(data) {
                    console.log(data);
                }
            })
        });

        $(document).on('click', '.deleteNotesWarning', function() {
            var noteid = $(this).attr('data-noteid');                      
            $(".deleteNotesDetails").attr('data-noteid', noteid);
            $("#deleteNote p").html("Do you realy want to delete this Notes?");
            $("#deleteNote").modal('show');
            return false;
        });

        $(document).on('click', '.deleteNotesDetails', function() {
            var noteid = $('.deleteNotesDetails').attr('data-noteid');

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/deleteNotes/' + noteid,
                success: function(deleteAction) {
                    $('#notePortal').modal('toggle');
                    var deleteuserdata = JSON.parse(deleteAction);
                    var extraMessageHtml = "";
                    if (deleteuserdata['success'] == true) {
                        extraMessageHtml = '<div class="alert alert-success">' + deleteuserdata['message'] +  '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    } else {
                        extraMessageHtml = '<div class="alert alert-danger">' + deleteuserdata['message'] +  '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    }
                    $('.extraCustomMessage').html(extraMessageHtml);
                    $('#patient-' + patientid).fadeOut(1500);
                    return false;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '#accountDetails', function() {
            $('#clientPortal').modal('toggle');
            var client_id = $('#clientPortal').find('.patientid').val();
        });

        $(document).on('click', '#newNotes', function() {
            $('.error').html('');
            $('#subjective').val('');
            $('#objective').val('');
            $('#assessment').val('');
            $('#plan').val('');
            $('#notePortal').modal('toggle');
            $('#notePortal').modal('toggle');
        });

        $(document).on('click', '#addNoteDetails', function() {
            if ($('#subjective').val() && $('#objective').val() && $('#assessment').val() && $('#plan').val()) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'admin/patients/addNewNotes',
                    data: {
                        subjective: $('#subjective').val(),
                        objective: $('#objective').val(),
                        assessment: $('#assessment').val(),
                        plan: $('#plan').val(),
                        client_id: $('#clientPortal').find('.patientid').val(),
                    },
                    success: function(result) {
                        var notesdata = JSON.parse(result);
                        $('#createNote').modal('toggle');
                        var extraMessageHtml = "";
                        if (notesdata['success'] == true) {
                            extraMessageHtml = '<div class="alert alert-success">' + notesdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        } else {
                            extraMessageHtml = '<div class="alert alert-danger">' + notesdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        }
                        $('.extraCustomMessage').html(extraMessageHtml);
                    },
                    complete: function() {},
                    error: function(data) {
                        console.log(data);
                    }
                })
            } else {
                $('.error').html('Please provide all data for Notes.');
                return false;
            }
        });

        // $(".toggle-sidebar").click()

        <?php
        if ($userid != '') { ?>
            $userid = '#<?php echo "patient-" . $userid ?>';
            $($userid).find('.btnPatientDetails').trigger('click');
        <?php
        }
        ?>
    });
</script>
<style type="text/css">
    .modal-dialog {
        overflow-y: initial !important
    }

    .imagestyle {
        width: 100px;
        height: 100px;
        margin-right: 20px;
    }

    .ml10 {
        margin-left: 10px;
    }

    .modal-body {
        padding: 0px 20px;
    }

    .modal-header .close {
        margin-top: 0px;
        font-size: 28px;
        font-weight: 300;
        text-shadow: unset;
        opacity: .7;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    .send-mail {
        line-height: 1.50;
        border: 2px solid;
        border-radius: 5px;
        padding: 0px 20px;
        text-decoration: none;
        font-size: 17px;
        margin-top: 15px;
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

    .send-mail:hover {
        background-color: #f3f3f3;
        text-decoration: none;
    }

    .new-routine {
        line-height: 1.75;
        border: 1px solid;
        border-radius: 5px;
        padding: 0px 15px;
        text-decoration: none;
        font-size: 20px;
        margin-top: 20px;
        margin-right: 5px;
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

    .client-detail-button {
        margin-top: 20px;
        font-size: 18px;
    }

    .appointment-card {
        background-color: #fafafa;
        border: #e3e3e3 solid 1px;
        border-radius: 5px;
        padding: 15px 10px;
        margin: 10px;
    }

    .btn-mail {
        margin-right: 5px;
    }
    
    .error {
        color: #a94442;
    }
</style>