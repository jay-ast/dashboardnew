<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html> <![endif]-->
<!--[if !IE]><!--><html><!-- <![endif]-->
    <head>
        <title>Login</title>
             <link rel="icon" 
              type="image/png" 
              href="<?php echo base_url('assets/fav.ico'); ?>">
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin/module.admin.page.login.min.cs'); ?>s" />
        <!--validator-->
        <script src="<?php echo base_url('assets/components/library/jquery/jquery.min.js?v=v1.2.3'); ?>"></script>
        <script src="<?php echo base_url('assets/custom/jquery.validate.js'); ?>"></script>
        <script src="<?php echo base_url('assets/custom/form-validator.init.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.2.3'); ?>"></script>
    </head>
    <body class=" loginWrapper">

        <div id="content"><h4 class="innerAll margin-none border-bottom text-center"><i class="fa fa-lock"></i> Login to your Account</h4>
            <div class="login spacing-x2">
                <div class="placeholder text-center "><i class="fa fa-lock fa-2x"></i></div>
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default">                       
                        <div class="panel-body innerAll">
                            <?php echo form_open('auth/login/verifyLogin', array('class' => 'login-panel')); ?>                            

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" name = "email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name= "password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                            
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <?php if ($this->session->flashdata('message') != '') { ?>
                        <div class="alert alert-<?php echo $this->session->flashdata('message')['classname']; ?>">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo $this->session->flashdata('message')['data']; ?> 
                        </div> 
                    <?php } ?> 
                </div>

            </div>
        </div>
    </body>
</html>