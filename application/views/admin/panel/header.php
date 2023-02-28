<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title; ?></title>
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/fav.ico'); ?>">
        <!-- Meta -->
        <meta charset="UTF-8" />
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />       
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/module.admin.page.index.min.css'); ?>" />
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/module.admin.page.gallery_video.min.css'); ?>" />-->
        <link rel="stylesheet" type="text/css"  href="<?php echo base_url('assets/custom/custom.css'); ?>" /> 
        <script src="<?php echo base_url('assets/components/library/jquery/jquery.min.js?v=v1.2.3'); ?>"></script>
        <script src="<?php echo base_url('assets/components/library/modernizr/modernizr.js?v=v1.2.3'); ?>"></script>
        <script src="<?php echo base_url('assets/components/library/jquery-ui/js/jquery-ui.min.js?v=v1.2.3'); ?>"></script>
        <script src="<?php echo base_url('assets/components/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js?v=v1.2.3'); ?>"></script>	
        <script src="<?php echo base_url('assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.2.3'); ?>"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    </head>
    <body class="" id='test'>
    <?php if ($this->session->userdata('roleid') == '2') { ?>
        <div class="navbar navbar-fixed-top navbar-primary main" role="navigation">

            <div class="navbar-header pull-left">
                <div class="navbar-brand">
                    <div class="pull-left">
                        <a href="" class="toggle-button toggle-sidebar btn-navbar"><i class="fa fa-bars"></i></a>
                    </div>

                    <a href="<?php echo base_url('admin/patients/'); ?>" class="appbrand innerL">
                        <span class="header text-primary"><?php echo $this->session->userdata('companyname'); ?></span>
                    </a>
                </div>
                </head>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle user" data-toggle="dropdown"> <span class="hidden-xs hidden-sm"> &nbsp;
                            <?php echo $this->session->userdata('firstname') . " " . $this->session->userdata('lastname'); ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu list pull-right ">
                        <li><a href="#responsiveAdminSettings" data-toggle="modal"><i class="fa fa-gears"></i> Settings </a></li>
                        <li><a href="<?php echo base_url('auth/login/logout'); ?>"><i class="fa fa-sign-out"></i> Log out </a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div id="menu" class="hidden-print hidden-xs">
            <div class="sidebar sidebar-inverse">
                <div class="sidebarMenuWrapper">
                    <ul class="list-unstyled">
                        <li <?php if ($active_class == 'calender') echo 'class="active"'; ?>>	
                            <a href="<?php echo base_url('admin/home'); ?>">	
                                <i class="fa fa-calendar-o"></i><span>Calendar</span></a>	
                        </li>
                        <li <?php if ($active_class == 'patient') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/patients'); ?>">
                                <i class="icon-group"></i><span>Clients</span></a>
                        </li>
                        <li <?php if ($active_class == 'videos') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/videos'); ?>">
                                <i class="fa fa-video-camera"></i><span>Video Library</span></a>
                        </li>
                        <li <?php if ($active_class == 'exercise') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/exercisefolders/generalroutinesfolder'); ?>">
                                <i class="fa fa-list"></i><span>Routines</span></a>
                        </li>
                        <li <?php if ($active_class == 'appointment') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/appointment'); ?>">
                                <i class="fa fa-list"></i><span>Appointment</span></a>
                        </li>
                        <li <?php if ($active_class == 'appointment_type') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/appointment/getAppointmentType'); ?>">
                                <i class="fa fa-list"></i><span>Appointment Type</span></a>
                        </li>
                        <!--<li <?php if ($active_class == 'calender') echo 'class="active"'; ?>>-->
                        <!--    <a href="<?php echo base_url('admin/calender'); ?>">-->
                        <!--        <i class="fa fa-calendar-o"></i><span>Calendar</span></a>-->
                        <!--</li>-->

                        <!--                    <li <?php if ($active_class == 'therapist') echo 'class="active"'; ?>>
                    <a href="">
                        <i class="fa fa-user"></i><span>Add Therapist</span></a></li>       -->
                    </ul>
                </div>
            </div>
        </div>
    <?php $adminaction = 'patients';
    }
    if ($this->session->userdata('roleid') == 1 && $this->session->userdata('companyid') != 0) {
    ?>
        <div class="navbar navbar-fixed-top navbar-primary main" role="navigation">

            <div class="navbar-header pull-left">
                <div class="navbar-brand">
                    <div class="pull-left">
                        <a href="" class="toggle-button toggle-sidebar btn-navbar"><i class="fa fa-bars"></i></a>
                    </div>

                    <a href="<?php echo base_url('admin/therapists/'); ?>" class="appbrand innerL">
                        <span class="header text-primary"><?php echo $this->session->userdata('companyname'); ?></span>
                    </a>
                </div>
                </head>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle user" data-toggle="dropdown"> <span class="hidden-xs hidden-sm"> &nbsp;
                            <?php echo ($this->session->userdata('firstname') != '') ? ($this->session->userdata('firstname') . " " . $this->session->userdata('lastname')) : 'Admin'; ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu list pull-right ">
                        <li><a href="#responsiveAdminSettings" data-toggle="modal"><i class="fa fa-gears"></i> Settings </a></li>
                        <li><a href="<?php echo base_url('auth/login/logout'); ?>"><i class="fa fa-sign-out"></i> Log out </a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div id="menu" class="hidden-print hidden-xs">
            <div class="sidebar sidebar-inverse">
                <div class="sidebarMenuWrapper">
                    <ul class="list-unstyled">
                        <li <?php if ($active_class == 'calender') echo 'class="active"'; ?>>	
                            <a href="<?php echo base_url('admin/home'); ?>">	
                                <i class="fa fa-calendar-o"></i><span>Calendar</span></a>	
                        </li>
                        <li <?php if ($active_class == 'therapist') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/therapists'); ?>">
                                <i class="icon-user-1"></i><span>Users</span></a>
                        </li>
                        <li <?php if ($active_class == 'patient') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/patients'); ?>">
                                <i class="icon-group"></i><span>Clients</span></a>
                        </li>
                        <li <?php if ($active_class == 'videos') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/videos'); ?>">
                                <i class="fa fa-video-camera"></i><span>Video Library</span></a>
                        </li>
                        <li <?php if ($active_class == 'exercise') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/exercisefolders/generalroutinesfolder'); ?>">
                                <i class="fa fa-list"></i><span>Routines</span></a>
                        </li>
                        <li <?php if ($active_class == 'appointment') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/appointment'); ?>">
                                <i class="fa fa-list"></i><span>Appointment</span></a>
                        </li>
                        <li <?php if ($active_class == 'appointment_type') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/appointment/getAppointmentType'); ?>">
                                <i class="fa fa-list"></i><span>Appointment Type</span></a>
                        </li>
                        <!--<li <?php if ($active_class == 'calender') echo 'class="active"'; ?>>-->
                        <!--    <a href="<?php echo base_url('admin/calender'); ?>">-->
                        <!--        <i class="fa fa-calendar-o"></i><span>Calendar</span></a>-->
                        <!--</li>-->
                    </ul>
                </div>
            </div>
        </div>
    <?php
        $adminaction = 'therapists';
    }
    if ($this->session->userdata('roleid') == 1 && $this->session->userdata('companyid') == 0) { ?>
        <div class="navbar navbar-fixed-top navbar-primary main" role="navigation">

            <div class="navbar-header pull-left">
                <div class="navbar-brand">
                    <div class="pull-left">
                        <a href="" class="toggle-button toggle-sidebar btn-navbar"><i class="fa fa-bars"></i></a>
                    </div>

                    <a href="<?php echo base_url('admin/companies/'); ?>" class="appbrand innerL">
                        <span class="header text-danger">PERFECT FORMS VIDEO APP - HOME EXERCISE PROGRAM </span>
                    </a>
                </div>
                </head>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle user" data-toggle="dropdown"> <span class="hidden-xs hidden-sm"> &nbsp;
                            <?php echo $this->session->userdata('firstname') . " " . $this->session->userdata('lastname'); ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu list pull-right ">
                        <li><a href="#responsiveAdminSettings" data-toggle="modal"><i class="fa fa-gears"></i> Settings </a></li>
                        <li><a href="<?php echo base_url('auth/login/logout'); ?>"><i class="fa fa-sign-out"></i> Log out </a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div id="menu" class="hidden-print hidden-xs">
            <div class="sidebar sidebar-inverse">
                <div class="sidebarMenuWrapper">
                    <ul class="list-unstyled">
                        <li <?php if ($active_class == 'companies') echo 'class="active"'; ?>>
                            <a href="<?php echo base_url('admin/companies'); ?>">
                                <i class="icon-building"></i><span>Companies </span></a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    <?php $adminaction = 'companies';
    } ?>

    <!--Model Admin details-->


    <?php
    if ($adminaction == 'therapists' && $this->session->userdata('roleid') == 1 && $this->session->userdata('companyid') == 0) { ?>
        <div id="responsiveAdminSettings" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content ">
                    <?php echo form_open(base_url('admin/therapists/updateCompany'), array("class" => "companyForm")); ?>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <h3 class="modal-title">Profile Details</h3>
                    </div>
                    <div class="modal-body modelform ">
                        <div class="form-body clearfix col-md-12">
                            <div class="row margin-top-10">
                                <div class="form-group col-md-6">
                                    <input type="hidden" class="form-control comapnyid" name="companyid" value="<?php echo $this->session->userdata('companyid'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Company Name</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" class="form-control companyname" name="companyname" value="<?php echo $company['name']; ?>" placeholder="Company Name" />
                                        </div>
                                    </div>

                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Email</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" class="form-control email" name="email" value="<?php echo $company['email']; ?>" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>First Name</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" class="form-control fname" name="fname" value="<?php echo $company['fname']; ?>" placeholder="First Name" />
                                        </div>
                                    </div>

                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Last Name</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" class="form-control lname" name="lname" value="<?php echo $company['lname']; ?>" placeholder="Last Name" />
                                        </div>
                                    </div>

                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Password</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="password" id="password" class="form-control password" value="<?php echo $company['password']; ?>" name="password" placeholder="Password" />
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Confirm Password</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="password" class="form-control confirmpassword" name="confirmpassword" value="<?php echo $company['password']; ?>" placeholder="Confirm Password" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">


                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Company Logo</label>
                                        </div>
                                        <div class="form-group col-md-9 text-center">
                                            <div class="img-sctn">

                                                <img class="img-rounded newcompanylogo" src="<?php echo base_url($company['logo']); ?>" />
                                                <input type="hidden" name="companylogo" class="file_menu_change companylogo" value="<?php echo $company['logo']; ?>" />

                                            </div>
                                            <div class="clearfix"></div>
                                            <a class="btn btn-sm btn-success margin-top-10 " id="company_logos" data-attr="companylogos" href="javascript:;">Browse</a>

                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Contact Number</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" class="form-control phone" name="phone" value="<?php echo $company['contact']; ?>" placeholder="Contact Number" />
                                        </div>
                                    </div>
                                    <div class="row margin-top-10">
                                        <div class="form-group col-md-3">
                                            <label>Address</label>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" class="form-control input-lg companyaddress" value="<?php echo $company['address']; ?>" name="companyaddress" placeholder="Address">
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btnupdatecompany" formaction="<?php echo base_url('admin/therapists/updateCompany'); ?>">Update</button>
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!-- /.modal-content -->
            </div>

        </div>

        <script>
            //Logo Upload
            var base_url_Plimageupload = '<?php echo base_url('admin/therapists/Pluploader'); ?>';

            $(function() {

                var pluploader = new plupload.Uploader({
                    runtimes: 'html5',
                    browse_button: 'company_logos',
                    url: base_url_Plimageupload,
                    unique_names: true,
                    multi_selection: false,
                    chunk_size: '2mb',
                    multipart_params: {
                        "folder": "companylogos"
                    },
                    filters: {
                        mime_types: [{
                            title: "Image files",
                            extensions: "png,jpg,jpeg,gif"
                        }, ],
                        max_file_size: "2024mb",
                    }
                });
                pluploader.bind('Init', function(up, params) {
                    //console.log("Current runtime environment: " + params.runtime);
                });
                pluploader.init();
                pluploader.bind('FilesAdded', function(up, files) {
                    //console.log("Starting upload.");
                    up.refresh();
                    up.start();
                });
                pluploader.bind('UploadProgress', function(up, file) {
                    $('.fullscreendiv').removeClass('hidden');
                    //console.log("Progress: " + file.name + " -> " + file.percent);
                });
                pluploader.bind('Error', function(up, err) {

                    alert(err.message);
                });
                pluploader.bind('FileUploaded', function(up, file, response) {

                    //console.log("File uploaded, File: " + file.name + ", Response: " + response.response);
                    var obj = eval("(" + response.response + ")");
                    console.log(obj);
                    $fileurl = '<?php echo base_url() ?>' + obj.pathname;
                    $('.companylogo').val(obj.pathname)
                    $('.newcompanylogo').attr('src', $fileurl)
                    $('.fullscreendiv').addClass('hidden');

                });
            });
        </script>
        <style>
            .img-sctn>img {
                width: 100px;
                height: 100px;
                margin-bottom: 10px;
            }
        </style>


    <?php } else { ?>
        <div id="responsiveAdminSettings" class="modal fade" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog new-modal-dialog">

                <div class="modal-content ">
                    <form action="<?php echo base_url("admin/" . $adminaction . "/adminOperation"); ?>" class="adminDetailForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title">Settings</h4>
                        </div>
                        <div class="modal-body modelform ">
                            <div class="form-body clearfix col-md-12">
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-3">
                                        <label>First Name</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control a_firstname" name="a_firstname" placeholder="Full Name" value="<?php echo $global['firstname']; ?>" />
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-3">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control a_lastname" name="a_lastname" placeholder="Last Name" value="<?php echo $global['lastname']; ?>" />
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-3">
                                        <label>Email</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control a_email disabled" name="a_email" disabled="" placeholder="Email" value="<?php echo $global['email']; ?>" />
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-3">
                                        <label>Password</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="password" class="form-control a_password" id="a_password" name="a_password" placeholder="Password" value="" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer">
                            <a class="btn businessAction" href=""></a>
                            <button type="submit" class="btn btn-success btnsaveadmin" data-userid="<?php echo $global['userid']; ?>">Update</button>
                            <button class="btn btn-deafault" data-dismiss="modal" aria-hidden="true">Close</button>

                        </div>
                    </form>
                </div>

                <!-- /.modal-content -->
            </div>

        </div>
    <?php } ?>

    <style>
        .navbar.main .navbar-brand {
            width: auto !important;
        }
    </style>

    <script>
        $("img").error(function() {
            $(this).unbind("error").attr("src", "http://dev.matrix4capital.com/assets/admin/pages/img/no_photo_icon.jpg");
            $(this).attr("height", "89");
            $(this).attr("width", "159");
        });
    </script>