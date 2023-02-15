<div class="modal-dialog">
    <div class="modal-content">
        <?php echo form_open(base_url('admin/patients/updatePatient'), array("class" => "patientForm")); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
            <h3 class="modal-title">Client Details</h3>
        </div>

        <div class="modal-body modelform ">
            <div class="form-body clearfix col-md-12">
            <div class="error"></div>
                <div class="row margin-top-10">
                    <div class="form-group col-md-6">
                        <input type="hidden" class="form-control patientid" name="patientid" value="">
                    </div>
                </div>
                <div class="col-md-12 userdetail">
                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>First Name</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="firstname form-control firstname" id="firstname" name="firstname" placeholder="First Name" />
                        </div>
                    </div>
                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Last Name</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="lastname form-control lastname" id="lastname" name="lastname" placeholder="Last Name" />
                        </div>
                    </div>
                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Email</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input id="email" type="text" class="form-control email" name="email" placeholder="Email" />
                        </div>
                    </div>
                    <div class="row margin-top-10 hidden userdetails">
                        <div class="form-group col-md-3">
                            <label>Password</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="password" id="patientpassword" class="form-control  password" name="password" placeholder="Password" />
                        </div>
                    </div>

                    <div class="row margin-top-10 hidden userdetails">
                        <div class="form-group col-md-3">
                            <label>Password</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="password" class="form-control confirmpassword " name="confirmpassword" placeholder="Confirm Password" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Phone</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="number" class="form-control phone" name="phone" id="phone" placeholder="Phone" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Date Of Birth</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="date" class="form-control dateofbirth" name="date_of_birth" id="dateofbirth" maxlength="15" value="" placeholder="DOB" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Physical Address</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control physicaladdress" name="physical_address" id="physicaladdress" value="" placeholder="Physical Address" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Street</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control street" id="street" name="street" placeholder="Street" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>City</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control city" id="city" name="city" placeholder="City" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Postal Code</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control postal_code" id="postal_code" name="postal_code" placeholder="Postal Code" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Country</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control country" id="country" name="country" placeholder="Country" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Emergency Contact Name</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control emergencycontactname" id="emergencycontactname" name="emergency_contact_name" value="" placeholder="Emergency Contact Name" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Emergency Contact</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="number" class="form-control emergencycontact" name="emergency_contact" id="emergencycontact" maxlength="15" value="" placeholder="Emergency Contact" />
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails">
                        <div class="form-group col-md-3">
                            <label>Total Appointments</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control appointment_count" name="appointment_count" id="emergencycontactname" maxlength="15" value="" placeholder="Total Appointments" readonly />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="display: flex; justify-content: center;">
                <button type="submit" class="btn btn-success btnsaveclientuser new-routine" name="btnsaveclientuser" formaction="<?php echo base_url('admin/patients/addNewPatient'); ?>">Add and create new routine</button>
                <!-- <button type="submit" class="btn btn-success btnsaveuser save-client" name="btnsaveuser" formaction="patients/addNewPatient">Add Client</button> -->
                <button type="button" class="btn btn-success btnsaveuser save-client" name="btnsaveuser" formaction="<?php echo base_url('admin/patients/addNewPatient'); ?>">Add Client</button>
            </div>

            <div class="clearfix"></div>
            <div class="modal-footer">
                <a class="send-mail pull-left" id="mailto" href="#" target="_top">Send e-mail</a>
                <!-- <button type="submit" class="btn btn-success btnupdateuser" formaction="<?php echo base_url('admin/patients/updatePatient'); ?>">Update</button> -->
                <button type="button" class="btn btn-success btnSaveClient update-client" name="btnSaveClient" formaction="<?php echo base_url('admin/patients/updatePatient'); ?>">Update Client</button>
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
            </div>


            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>

</div>