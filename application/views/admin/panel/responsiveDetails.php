<div id="responsiveUserdetails" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <?php echo form_open(base_url('admin/patients/updatePatient'), array("class" => "patientForm")); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 class="modal-title">Client Details</h3>
                </div>
                <div class="modal-body modelform ">
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control patientid" name="patientid" value="">
                            </div>
                        </div>
                        <div class="col-md-6 userdetail">
                            <div class="row margin-top-10 ">
                                <div class="form-group col-md-3">
                                    <label>First Name</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="firstname form-control firstname" name="firstname" placeholder="First Name"/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Last Name</label>
                                </div>
                                <div class="form-group col-md-9">                                          
                                    <input type="text" class="lastname form-control lastname" name="lastname" placeholder="Last Name"/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Email</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="form-control email" name="email" placeholder="Email"/>
                                </div>
                            </div>
                            <div class="row margin-top-10 hidden">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" id="patientpassword" class="form-control  password" name="password" placeholder="Password"/>
                                </div>
                            </div>
                            
                            <div class="row margin-top-10 hidden">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" class="form-control confirmpassword " name="confirmpassword" placeholder="Confirm Password"/>
                                </div>
                            </div>
                            
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Phone</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="form-control phone" name="phone" placeholder="Phone"/>
                                </div>
                            </div>
                        </div>
                       
                    
                        <div class="routinelist">
                        <div class="col-md-3">
                            <div class="row margin-top-10">
                                <div class="form-group col-md-12">
                                    <label>Saved General Routines</label> 
                                    <input type="text" id="generalvideosearch" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                    <select multiple class="form-control ex_list_to" id="exgeneral_list_to">                                      

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row margin-top-10">
                                <div class="form-group col-md-12">
                                    <label>Saved Client Routines</label> 
                                    <input type="text" id="clientvideosearch" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                    <select multiple class="form-control ex_list_to" id="exclient_list_to">                                      

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row margin-top-10">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success btnaddselectex" data-toggle="tooltip" data-title="Assign selected Exercise"><i class="fa fa-arrow-circle-o-down"></i></button>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label>Assigned Routines</label>
                                <div class="assignes_ex_div">

                                </div>

                            </div>
                        </div>   
                        </div>
                    </div>
                    <a class="pull-right" id="mailto" href="#" target="_top"><i class="fa fa-envelope" data-toggle="tooltip" title="" data-original-title="Send e-mail"></i></a>
                    <div class="modal-footer">                    
                        <button  type="submit" class="btn btn-success btnsaveuser" name="btnsaveuser" formaction="<?php echo base_url('admin/patients/addNewPatient'); ?>">Add Client</button>
                    </div>
                    
                    <div class="modal-footer">                    
                        <a  type="submit" class="btn btn-success btnupdateclientuser" href="">Create New Routine</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">                    
                        <button  type="submit" class="btn btn-success btnsaveclientuser" name="btnsaveclientuser" formaction="<?php echo base_url('admin/patients/addNewPatient'); ?>">Add and create new routine</button>
                        <button  type="submit" class="btn btn-success btnupdateuser" formaction="<?php echo base_url('admin/patients/updatePatient'); ?>">Update</button>                                                            
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>
                    
                  
                    <?php echo form_close(); ?>
                </div>
                <!-- /.modal-content --> 
            </div>                   

        </div>
    </div>