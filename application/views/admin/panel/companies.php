<?php 

include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Companies</h1>
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
                    <?php echo form_open(base_url('admin/companies')); ?>                   
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
                            <a class="btn btn-success btnAddCompany col-sm-12" data-toggle="modal" href="#responsiveUserdetails"> <i class="fa fa-plus"></i> Add</a>
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                    <table class="dynamicTable tableTools table table-striped checkboxs">
                        <!-- Table heading -->
                        <thead>
                            <tr class=" text-center">                              
                                <th>Name</th>
                                <th>Login Information</th>
                                <th>Number of Therapist</th>
                               <th>Videos</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <!-- // Table heading END -->
                        <!-- Table body -->
                        <tbody> 
                            <?php
                            if (isset($complist)) {
                                //echo "<pre>";
                              //  print_r($complist);exit;
                                foreach ($complist as $compdata) {
                                    
                                    ?>
                                    <tr class="gradeX " data-id="66666" id="companies-<?php echo $compdata['companydata']['id']; ?>">      

                                        <td><a data-toggle="modal" href="#"                                               
                                               data-companyid="<?php echo $compdata['companydata']['id']; ?>"                                                           
                                               class="btnCompnayDetails">
                                                   <?php echo $compdata['companydata']['company_name']; ?>
                                            </a>  
                                        </td>
                                        <?php if(isset($compdata['admindata'])) { ?>
                                        <td><?php echo $compdata['admindata']['email'] . " (" . $compdata['admindata']['password'] . ")"; ?></td>
                                        <?php } else { echo '<td> </td>'; } ?>                                       
                                        
                                        <td><?php echo $compdata['totalthr'] ?></td> 
                                       <td><a data-toggle="modal" href="#responsivevideodetails"                                               
                                               data-companyid="<?php echo $compdata['companydata']['id']; ?>"                                                           
                                               class="btnCompnayvideoDetails">Assign Videos
                                                   
                                            </a>  
                                        </td>
                                        <td class="center">
                                             <?php
                                            // echo $compdata['companydata']['isdeleted'];
                                             if($compdata['companydata']['isdeleted']==0){?>
                                            <a data-companyid="<?php echo $compdata['companydata']['id']; ?>" 
                                               data-companyname="<?php echo $compdata['companydata']['company_name']; ?>"
                                               data-action="delete"  class="deleteBtn danger">  <i title="" data-toggle="tooltip" class="glyphicon glyphicon-trash " data-original-title="Delete Comapany?"></i></a>
                                             <?php }else{ ?>
                                             <a data-companyid="<?php echo $compdata['companydata']['id']; ?>" 
                                               data-companyname="<?php echo $compdata['companydata']['company_name']; ?>"
                                               data-action="active"  class="deleteBtn success"> <i title="" data-toggle="tooltip" class="glyphicon glyphicon-check " data-original-title="Active Company?"></i> </a>
                                             <?php } ?>
                                            </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr class="gradeX"><td colspan="5" class="text-center">No Comapnies available.</td></tr>';
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
                <?php echo form_open(base_url('admin/companies/updateCompany'), array("class" => "companyForm")); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 class="modal-title">Company Details</h3>
                </div>
                <div class="modal-body modelform ">
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control comapnyid" name="companyid" value="">
                            </div>
                        </div>
                      <div class="row">
                            
                        <div class="col-md-6">
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Company Name</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="form-control companyname" name="companyname" placeholder="Company Name"/>
                                </div>
                            </div>
                             <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>First Name</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="form-control fname" name="fname" placeholder="First Name"/>
                                </div>
                            </div>
                             <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Last Name</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="form-control lname" name="lname" placeholder="Last Name"/>
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
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" id="password" class="form-control password" name="password" placeholder="Password"/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Confirm Password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" class="form-control confirmpassword" name="confirmpassword" placeholder="Confirm Password"/>
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
                                                
                                                <img class="img-rounded newcompanylogo"  src="" />
                                                    <input type="hidden" name="companylogo" class="file_menu_change companylogo" value="" />
                                              
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
                                    <input type="text" class="form-control phone" name="phone" placeholder="Contact Number"/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Address</label>
                                </div>
                                <div class="form-group col-md-9">  
                                    <textarea placeholder="Address" class="form-control companyaddress col-md-9" rows="2" name="companyaddress">                                        
                                    </textarea>
                                  
                                </div>
                            </div>
                           
                            </div>
                        </div>
                        
                            
                        </div>
                                         
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">                    
                        <button  type="submit" class="btn btn-success btnsavecompany" formaction="<?php echo base_url('admin/companies/addNewCompany'); ?>">Add</button>
                        <button  type="submit" class="btn btn-success btnupdatecompany" formaction="<?php echo base_url('admin/companies/updateCompany'); ?>">Update</button>                                                            
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
                    <button type="button" class="btn btn-danger modeldeleteyes" data-action="" data-companyid data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
                </div>                  
            </div>
        </div>
    </div>
    
       <!--Model user details-->
    <div id="responsivevideodetails" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <?php echo form_open(base_url('admin/company/updatevideos'), array("class" => "videoForm")); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 class="modal-title">Assigned Details</h3>
                </div>
                <input type="hidden" value="" class="videocompany">
                <div class="modal-body modelform ">
                    <div class="form-body clearfix col-md-12">
                        <div class="col-md-12">
                            
                            
                            <div class="row margin-top-10">
                                <div class="form-group col-md-2 field">
                                    <label>Public Videos</label>
                                    <br>or<br>
                                    <a class="link" href="<?php echo base_url('admin/publicvideos'); ?>"> <i class="fa fa-plus"></i> Add Videos</a>
                                </div>
                                <div class="form-group col-md-10 field">
                                    <div class="form-group col-md-4">
                                        <label>Assign Videos</label>                                                                        
                                        <select multiple class="form-control ex_list_to" id="ex_list_to">                                     

                                        </select>                                        
                                    </div>   
                                    <div class="col-md-1">
                                        <div class="row margin-top-10">
                                            <br><br><br>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-success btnaddselectex" data-toggle="tooltip" data-title="Assign selected Videos"><i class="fa fa-arrow-circle-o-right"></i></button>                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="col-md-12">
                                            <label>Assigned Videos</label>
                                            <div class="assignes_ex_div">

                                            </div>

                                        </div>
                                    </div> 
                                </div>                 

                            </div>                        
                        </div>                   
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">  
                        <button  type="submit" class="btn btn-success btnupdatevideos" formaction="<?php echo base_url('admin/company/updateassignedvideo'); ?>">Update</button>                                                            
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!-- /.modal-content --> 
            </div>                   

        </div>

    </div>
    <!-- /.modal-dialog --> 
   
<?php include_once 'footer.php'; ?>
<script>
    $public_videos = [];
<?php
if (!empty($public_videos)) {
    foreach ($public_videos as $exc) {
        $exc['title']= preg_replace("/'/", '&#39;', $exc['title']);
        ?>
            $('.ex_list_to').append('<option value="<?php echo $exc['id']; ?>"><?php echo $exc['title']; ?></option>');
            $public_videos.push({'id':<?php echo $exc['id']; ?>, 'name': '<?php echo $exc['title'] ?>', 'title': '<?php echo $exc['title']?>'});
        <?php
    }
}
?>

    var base_url = '<?php echo base_url(); ?>';
   

    // delete warning model
    $(document).on('click', '.deleteBtn', function () {
        var comapnyid = $(this).attr('data-companyid');
        var company_name = $(this).attr('data-companyname');
        var action = $(this).attr('data-action');
        $(".modeldeleteyes").attr('data-companyid', comapnyid);
        $(".modeldeleteyes").attr('data-companyname', company_name);
        $(".modeldeleteyes").attr('data-action', action);
        
        $("#deleteWarning p").html("Do you realy want to "+action+" this Comapny <strong>" + company_name + "</strong>?");
        $("#deleteWarning").modal('show');
        return false;
    });

    //if user accept to delete park from model then process request
    $(document).on('click', '.modeldeleteyes', function () {
        var companyid = $('.modeldeleteyes').attr('data-companyid');
        var company_name = $('.modeldeleteyes').attr('data-companyname');
        var action = $('.modeldeleteyes').attr('data-action');

        $.ajax({
            type: 'POST',
            url: base_url + 'admin/companies/deleteCompany/' + companyid,
            success: function (deleteAction) {
                var deleteuserdata = JSON.parse(deleteAction);
                var extraMessageHtml = "";
                if (deleteuserdata['status'] == true) {
                    if(deleteuserdata['state']==0){
                        console.log( $('#companies-'+companyid).html());
                        $('#companies-'+companyid).find('.deleteBtn').removeClass('success');
                        $('#companies-'+companyid).find('.deleteBtn').attr('data-action','delete');
                        $('#companies-'+companyid).find('.deleteBtn').addClass('danger');
                        $('#companies-'+companyid).find('.deleteBtn').html('<i title="" data-toggle="tooltip" class="glyphicon glyphicon-trash " data-original-title="Delete Company?"></i>');
                    }else{ 
                        $('#companies-'+companyid).find('.deleteBtn').removeClass('danger');
                        $('#companies-'+companyid).find('.deleteBtn').attr('data-action','active');
                        $('#companies-'+companyid).find('.deleteBtn').addClass('success');
                        $('#companies-'+companyid).find('.deleteBtn').html('<i title="" data-toggle="tooltip" class="glyphicon glyphicon-check " data-original-title="Active Company?"></i>');
                    }
                    extraMessageHtml = '<div class="alert alert-success">Company <strong>' + company_name + '</strong> '+action+'d successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                } else {
                    extraMessageHtml = '<div class="alert alert-danger">Error while '+action+' Company <strong>' + company_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                }
                $('.extraCustomMessage').html(extraMessageHtml);
                $('#comapny-' + companyid).fadeOut(1500);
                return false;
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $(document).on('click', '.btnAddCompany', function () {
        $('.btnsavecompany').removeClass('hidden');
        $('.btnupdatecompany').addClass('hidden');

        //reset field values
        $('.companyForm').find('input').val("");
         $('.companyForm').find('textarea').val("");
        $('.newcompanylogo').attr('src','');
        $('.companylogo').val('');
        
        
    });

    //btn get company details
    $(document).on('click', '.btnCompnayDetails', function () {
        var comapnyid = $(this).attr('data-companyid');
        $('.btnsavecompany').addClass('hidden');
        $('.btnupdatecompany').removeClass('hidden');
        $('.fullscreendiv').removeClass('hidden');       

        $.ajax({
            type: 'POST',
            url: base_url + 'admin/companies/getCompanyDetails/' + comapnyid,
            success: function (actionResponse) {
                var companyData = JSON.parse(actionResponse);
                if(companyData.status==true)
                {
                    $('.comapnyid').val(comapnyid);
                    $('.companyname').val(companyData.data.admindata.name);
                    $('.email').val(companyData.data.admindata.email);
                    $('.password').val(companyData.data.admindata.password);
                    $('.confirmpassword').val(companyData.data.admindata.password);
                    
                    $('.fname').val(companyData.data.admindata.fname);
                    $('.lname').val(companyData.data.admindata.lname);
                    $('.phone').val(companyData.data.admindata.contact);
                    $('.companyaddress').val(companyData.data.admindata.address);
                    $('.newcompanylogo').attr('src','<?php echo base_url() ?>'+companyData.data.admindata.logo);
                    $('.companylogo').val(companyData.data.admindata.logo);
                 }
                
              $('.fullscreendiv').addClass('hidden');
              $('#responsiveUserdetails').modal('show');
           
            },
            error: function (data) {
                
            }
        });
    });
    $('#responsiveUserdetails').on('hidden.bs.modal', function () {
        $('.has-error').children('p').remove('p');
        $('.has-error').removeClass('has-error');
        $('.error').children('p').remove('p');
        $('.error').removeClass('error');        
    });
    
     $(document).on('click', '.btnCompnayvideoDetails', function () {
          $('#ex_list_to').find('option').remove();
        for (var key in $public_videos) {
            var id = $public_videos[key]['id'];
            var text = $public_videos[key]['name'];
            $('#ex_list_to').append('<option value="' + id + '">' + text + '</option>');
        }
        $('.assignes_ex_div').html('');
        $('.fullscreendiv').removeClass('hidden');
        var objectid = $(this).attr('data-companyid');
       
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/companies/getAssignedVideos/' + objectid,
            success: function (actionResponse) {
               
                var exerciseData = JSON.parse(actionResponse);
                $('.videocompany').val(objectid);
                 if(exerciseData.status==true)
                 {
                var ex_videos = exerciseData['data']['videos'];
                var ex_videos_len = ex_videos.length;             
                
                for (var i = 0; i < ex_videos_len; i++) {
                    var id = ex_videos[i]['id'];
                    //var name = ex_videos[i]['name'];
                    var title = ex_videos[i]['title'];

                    var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                            '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-id="' + id + '" data-text="' + title + '">&times;</button>' +
                            '<span style="line-height: 30px;">' + title + '</span>' +
                            '<input type="hidden" name="assigned_video[]" class="assigned_video" value="' + id + '"/>' +
                            '</label></div>';
                    $('.assignes_ex_div').append(appen_html);

                    $('#ex_list_to option[value=' + id + ']').remove();
                 }
                  $('.fullscreendiv').addClass('hidden');
                 }else{
                   $('.fullscreendiv').addClass('hidden');}               
                $('#responsivevideodetails').modal('show');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    
     $(document).on('click', '.btnupdatevideos', function (e) {
     e.preventDefault();
     
     var assigned_video = new Array();
        $(".assigned_video").each(function() {
           assigned_video.push($(this).val()); 
        });

        $('.fullscreendiv').removeClass('hidden');
        var objectid = $('.videocompany').val();
        $data={}
        $data.id=objectid;
        $data.assignedvideos=assigned_video;
       
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/companies/updateassignedvideo/',
            data:$data,
            success: function (actionResponse) {
               
                var exerciseData = JSON.parse(actionResponse);
                 if(exerciseData.status==true)
                 {
                     $('.fullscreendiv').addClass('hidden'); 
                     
                 }else{
                   $('.fullscreendiv').addClass('hidden');}
                $('#responsivevideodetails').modal('hide');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    
    
    
    $(document).on('click', '.btnaddselectex', function () {
        $(".ex_list_to option:selected").each(function () {
            var optionValue = $(this).val();
            var optionText = $(this).text();
            console.log("optionText", optionText);
            // collect all values
            var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                    '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-id="' + optionValue + '" data-text="' + optionText + '">&times;</button>' +
                    '<span style="line-height: 30px;">' + optionText + '</span>' +
                    '<input type="hidden" name="assigned_video[]" class="assigned_video" value="' + optionValue + '"/>' +
                    '</label></div>';
            $('.assignes_ex_div').append(appen_html);
            
            //remove this option
            $(this).remove();
        });

    });
     $(document).on('click', '.btnRemoveExc', function () {
        $(this).parent('label').remove();
        //append this value and caption to list box
        var id = $(this).attr('data-id');
        var text = $(this).attr('data-text');
        $('.ex_list_to').append('<option value="' + id + '">' + text + '</option>');

    });
    
    
    
    //Logo Upload
     var base_url_Plimageupload = '<?php echo base_url('admin/companies/Pluploader'); ?>';

        $(function () {

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
                    mime_types: [
                        {title: "Image files", extensions: "png,jpg,jpeg,gif"},
                    ],
                    max_file_size: "2024mb",
                }
            });
            pluploader.bind('Init', function (up, params) {
                //console.log("Current runtime environment: " + params.runtime);
            });
            pluploader.init();
            pluploader.bind('FilesAdded', function (up, files) {
                //console.log("Starting upload.");
                up.refresh();
                up.start();
            });
            pluploader.bind('UploadProgress', function (up, file) {
                $('.fullscreendiv').removeClass('hidden');
                //console.log("Progress: " + file.name + " -> " + file.percent);
            });
            pluploader.bind('Error', function (up, err) {

                alert(err.message);
            });
            pluploader.bind('FileUploaded', function (up, file, response) {
                
                
                //console.log("File uploaded, File: " + file.name + ", Response: " + response.response);
                var obj = eval("(" + response.response + ")");
               
                $fileurl='<?php echo base_url()?>'+obj.pathname;
                $('.companylogo').val(obj.pathname)
                $('.newcompanylogo').attr('src',$fileurl)
                $('.fullscreendiv').addClass('hidden');
                $('.error').children('p').remove('p');
               $('.error').removeClass('error');   
                
            });
        });
  
   

</script>
<style type="text/css">
    .modal-dialog{
        overflow-y: initial !important;
       
    }
    .imagestyle{
        width: 100px; 
        height: 100px; 
        margin-right: 20px;
    }
    .ml10{
        margin-left: 10px;
    }
    .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.img-sctn > img {
    width: 100px;
    height:100px;
    margin-bottom: 10px;
}

   
</style>


