<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Users</h1>
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
                <!-- Table -->
                <div class="row">                    
                    <?php echo form_open(base_url('admin/therapists')); ?>                   
                    <div class="col-md-4"><input type="text" class="form-control" placeholder="<?php
                        if (isset($fullname)) {
                            echo $fullname;
                        } else {
                            echo 'Name';
                        }
                        ?>" name="fullname"/>
                    </div>

                    <div class="col-md-5">
                        <input type="text" class="form-control"  placeholder="<?php
                        if (isset($email)) {
                            echo $email;
                        } else {
                            echo 'Login Information';
                        }
                        ?>" name="email"/>
                    </div>


                    <div class="col-md-3">
                        <div class="col-md-6">
                            <button class="btn btn-info btn-stroke col-sm-12">Search</button> 
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-success btnAddUser col-sm-12" data-toggle="modal" href="#responsiveUserdetails"> <i class="fa fa-plus"></i> Add</a>
                        </div>
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
                        <tbody> 
                            <?php
                            if (isset($therapistlist)) {
                                foreach ($therapistlist as $userdatalist) {
                                    $therapist_name = $userdatalist['firstname'] . " " . $userdatalist['lastname'];
                                    ?>
                                    <tr class="gradeX " id="therapist-<?php echo $userdatalist['id']; ?>">      

                                        <td><a data-toggle="modal" href="#responsiveUserdetails"                                               
                                               data-therapistid="<?php echo $userdatalist['id']; ?>"                                                           
                                               class="btnTherapistDetails">
                                                   <?php echo $therapist_name; ?>
                                            </a>  
                                        </td>
                                        <td><?php echo $userdatalist['email'] . " (" . $userdatalist['password'] . ")"; ?></td>
                                        <td><?php echo $userdatalist['phone']; ?></td>                                       
                                        <td class="center">
                                          <a href="mailto:<?php echo $userdatalist['email']; ?>?Subject=Your%20Video%20Routine%20From%20Perfect%20Forms&body=To%20view%20your%20videos%3A%0A%0A1-%20Download%20our%20Perfect%20Forms%20app%20from%20App%20Store(IOS)%3A%20<?php echo APP_ITUNES_LINK ?>%20or%0A2-%20Download%20our%20Perfect%20Forms%20app%20from%20Google%20Play%20Store(Android)%3A%20<?php echo APP_PLAYSTORE_LINK ?>%20%0A3-%20Log%20into%20<?php echo APP_WEBAPP_LINK ?>%20from%20any%20device%20or%20computer.%0A%0AYour%20username%20and%20password%20are%3A%0AUsername%3A%20<?php echo urlencode($userdatalist['email']) ?>%0APassword%3A%20<?php echo urlencode($userdatalist['password']) ?>" target="_top">
                                                <i class="fa fa-envelope" data-toggle="tooltip" title="Send Mail"></i></a>  
                                            <a class="deleteBtn" data-therapistid="<?php echo $userdatalist['id']; ?>" 
                                               data-therapistname="<?php echo $therapist_name; ?>"
                                               data-action="delete" data-toggle="modal" href="#deleteWarning" >
                                                <i class="glyphicon glyphicon-trash " data-toggle="tooltip" title="Delete User"></i></a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr class="gradeX"><td colspan="5" class="text-center">No Users available.</td></tr>';
                            }
                            ?>
                        </tbody>
                        <!-- // Table body END -->
                    </table>
                    <!-- // Table END -->
                    <div class="jquery-bootpag-pagination pull-right">
                        <ul class="bootpag pagination">

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
                <?php echo form_open(base_url('admin/therapist/updateTherapist'), array("class" => "therapistForm")); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 class="modal-title">User Details</h3>
                </div>
                <div class="modal-body modelform ">
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control therapistid" name="therapistid" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row margin-top-10 ">
                                <div class="form-group col-md-3">
                                    <label>First Name</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="firstname form-control firstname" name="firstname" placeholder="First Name" pattern="[A-Za-z]{1,20}" title="First name should only contain alphabets. e.g. John" required/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Last Name</label>
                                </div>
                                <div class="form-group col-md-9">                                          
                                    <input type="text" class="lastname form-control lastname" name="lastname" placeholder="Last Name" pattern="[A-Za-z]{1,20}" title="Last name should only contain alphabets. e.g. Doe" required/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Email</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="email" class="form-control email" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter valid email address." required/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" id="therapistpass" class="form-control password" name="password" placeholder="Password" pattern=".{5,}" title="Five or more characters" required/>
                                </div>
                            </div>
                            
                             <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Confirm password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" id="therapistconfpass" class="form-control confirmpassword" name="confirmpassword" placeholder="Confirm Password" pattern=".{5,}" title="Five or more characters" required/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Phone</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="tel" class="form-control phone" name="phone" placeholder="Phone" pattern="^\+?\d{10,13}" title="Phone number must be 10 digit and not more than 13." required/>
                                </div>
                            </div>
                        </div>
                                       
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">                    
                        <button  type="submit" class="btn btn-success btnsaveuser" formaction="<?php echo base_url('admin/therapists/addNewTherapist'); ?>" onclick="return Validate()">Add</button>
                        <button  type="submit" class="btn btn-success btnupdateuser" formaction="<?php echo base_url('admin/therapists/updateTherapist'); ?>">Update</button>                                                            
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!-- /.modal-content --> 
            </div>                   

        </div>
    </div>
    <!-- /.modal-dialog --> 
    <div id="deleteWarning"  class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert!!</h4>
                </div>
                <div class="modal-body alert-message">
                    <p></p>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-danger modeldeleteyes" data-action="" data-therapistid data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
                </div>                  
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<script>
    var base_url = '<?php echo base_url(); ?>';

    function Validate() {
        var password =$("#therapistpass").val();
        var confirmPassword = $("#therapistconfpass").val();
        if (password && confirmPassword) {
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }

    }
    // delete warning model
    $(document).on('click', '.deleteBtn', function () {
        var therapistid = $(this).attr('data-therapistid');
        var therapist_name = $(this).attr('data-therapistname');
        var action = $(this).data('action');
        $(".modeldeleteyes").attr('data-therapistid', therapistid);
        $(".modeldeleteyes").attr('data-therapistname', therapist_name);
        $(".modeldeleteyes").attr('data-action', action);
        $("#deleteWarning p").html("Do you realy want to delete this User <strong>" + therapist_name + "</strong>?");
        $("#deleteWarning").modal('show');
        return false;
    });

    //if user accept to delete park from model then process request
    $(document).on('click', '.modeldeleteyes', function () {
        var therapistid = $('.modeldeleteyes').attr('data-therapistid');
        var therapist_name = $('.modeldeleteyes').attr('data-therapistname');
        var action = $('.modeldeleteyes').attr('data-action');

        $.ajax({
            type: 'POST',
            url: base_url + 'admin/therapists/deleteTherapist/' + therapistid,
            success: function (deleteAction) {
                var deleteuserdata = JSON.parse(deleteAction);
                var extraMessageHtml = "";
                if (deleteuserdata['status'] == true) {
                    extraMessageHtml = '<div class="alert alert-success">User <strong>' + therapist_name + '</strong> deleted successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                } else {
                    extraMessageHtml = '<div class="alert alert-danger">Error while deleting User <strong>' + therapist_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                }
                $('.extraCustomMessage').html(extraMessageHtml);
                $('#therapist-' + therapistid).fadeOut(1500);
                return false;
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $(document).on('click', '.btnAddUser', function () {
        $('.btnsaveuser').removeClass('hidden');
        $('.btnupdateuser').addClass('hidden');
        $('.therapistForm').find("input").attr("maxlength", 50);
        //reset field values
        $('.therapistid').val("");
        $('.firstname').val("");
        $('.lastname').val("");
        $('.email').val("");
        $('.phone').val("");
        $('.password').val("");
        $('.confirmpassword').val("");
        
        
       
    });

    //btn get therapist details
    $(document).on('click', '.btnTherapistDetails', function () {
        var therapistid = $(this).attr('data-therapistid');
        $('.therapistForm').find("input").attr("maxlength", 50);
        $('.btnsaveuser').addClass('hidden');
        $('.btnupdateuser').removeClass('hidden');
        //reset assigned exercise
        
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/therapists/getTherapistDetails/' + therapistid,
            success: function (actionResponse) {
                var therapistData = JSON.parse(actionResponse);
                $('.therapistid').val(therapistid);
                $('.firstname').val(therapistData['data']['firstname']);
                $('.lastname').val(therapistData['data']['lastname']);
                $('.email').val(therapistData['data']['email']);
                $('.phone').val(therapistData['data']['phone']);
                $('.password').val(therapistData['data']['password']);
                $('.confirmpassword').val(therapistData['data']['password']);

                
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    $('#responsiveUserdetails').on('hidden.bs.modal', function () {
        $('.has-error').children('p').remove('p');
        $('.has-error').removeClass('has-error');
    });
 
   

</script>
<style type="text/css">
    .modal-dialog{
        overflow-y: initial !important
    }
    .imagestyle{
        width: 100px; 
        height: 100px; 
        margin-right: 20px;
    }
    .ml10{
        margin-left: 10px;
    }
</style>