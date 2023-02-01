<?php include 'header.php'; ?>
<style>
    video::-webkit-media-controls-fullscreen-button {
        display: none;
    }
    video::-webkit-media-controls-play-button {}
    video::-webkit-media-controls-timeline {}
    video::-webkit-media-controls-current-time-display{}
    video::-webkit-media-controls-time-remaining-display {}
    video::-webkit-media-controls-mute-button {}
    video::-webkit-media-controls-toggle-closed-captions-button {}
    video::-webkit-media-controls-volume-slider {}
    .overflowhiddentext {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Routines</h1>
    
    <div class="tabsbar">
			<ul>
				<li class="glyphicons building <?php echo ($isgeneral==true)?'active':'' ?>"><a  href="<?php echo base_url('admin/exercisefolders/generalroutinesfolder'); ?>"><i></i> General Routines</a></li>
                                <li class="glyphicons parents <?php echo ($isgeneral==false)?'active':'' ?> "><a  href="<?php echo base_url('admin/exercisefolders/clientroutinesfolder'); ?>"><i></i> Client Routines</a></li> 
		
			</ul>
		</div>
<h1 class="bg-white content-heading border-bottom"><?php echo $folderdetails['folder_name']; ?></h1>
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
         <div class="widget widget-inverse">
            <div class="widget-body" style="padding: 10px;">                
                <div class="row margin-bottom-10">
                    <div class="col-md-12">
                        <?php echo form_open((base_url('admin/exercisefolders/detail/'.$folderdetails['id'])), array('class' => 'crud_ex_video')); ?>                 
                        <div class="col-md-9" style="display: flex; padding: 5px;">
	                        <input type="text" class="form-control" name="video_name" placeholder="<?php
                            if (isset($video_name)) {
                                echo $video_name;
                            } else {
                                echo 'Routine Name';
                            }
                            ?>" name="Routine name" />
                            <button class="btn btn-info btn-stroke">Search</button> 
                        </div>

                        <div class="col-md-3" style="justify-content: center; display: flex;">
                           <a style="margin: 5px" class="btn btn-success btnLoadAddVideo" href="<?php echo ($isgeneral==false)?base_url('admin/exercises/addclientexercise/'.$folderdetails['client_id']):base_url('admin/exercises/addgeneralexercise/'.$folderdetails['id']) ?>"> <i class="fa fa-plus"></i> Add</a>                      
                        <?php echo form_close(); if($isgeneral==false) { ?>   
                         <a style="margin: 5px" class="btn btn-danger"  href="<?php echo ($isgeneral==false)?base_url('admin/patients/index/1/'.$folderdetails['client_id']):''?>">
	                         <i class="fa fa-info"></i> Client detail
	                     </a>   
						 <?php } ?>
                        </div>  
                    </div>
                </div> 
<!--                 <div class="clearfix"><br></div> -->

            </div>

        </div> 
       <table class="dynamicTable tableTools table table-striped checkboxs">
                        <!-- Table heading -->
                        <thead>
                            <tr class=" text-center">                              
                                <th>Name</th>
                                <th>Number of videos</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <!-- // Table heading END -->
                        <!-- Table body -->
                        <tbody> 
                            <?php
                            if (isset($exercise_name)) {
                                //echo "<pre>";
                              //  print_r($complist);exit;
                                foreach ($exercise_name as $exercisedata) {
                                    //print_r($exercisedata)
                                    
                                    
                                    ?>
                                    <tr class="gradeX " data-id="77777" id="folder-<?php echo $exercisedata['id']; ?>">      

                                        
                                        <td><a href="<?php echo base_url('admin/exercises/detail').'/'.$exercisedata['id'].'/'.$folderdetails['id'] ?>"><?php echo $exercisedata['name'];?> (<?php echo $exercisedata['insertdate'];?>)</td> 
                                        <td><?php echo $exercisedata['numberofvideo'];?></td> 
                                       
                                        <td class="center">
                                            <a data-objectid="<?php echo $exercisedata['id']; ?>" 
                                               data-objectname="<?php echo $exercisedata['name']; ?>"
                                               data-folderid="<?php echo $folderdetails['id']; ?>"
                                               data-action="active"  class="deleteBtn danger"> <i class="glyphicon glyphicon-trash " data-toggle="tooltip" title="" data-original-title="Delete Routine"></i> </a>
                                             
                                            </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr class="gradeX"><td colspan="5" class="text-center">No Folders available.</td></tr>';
                            }
                            ?>
                        </tbody>
                        <!-- // Table body END -->
                    </table>  
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
                    <button type="button" class="btn btn-danger modeldeleteyes" data-action="" data-objectid data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
                </div>                  
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>   
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var base_url_Plimageupload = '<?php echo base_url('admin/exercises/Pluploader'); ?>';

        // delete warning model
        $(document).on('click', '.deleteBtn', function () {
            var objectid = $(this).attr('data-objectid');
            var object_name = $(this).attr('data-objectname');
            var folderid = $(this).attr('data-folderid');
            var action = $(this).data('action');
            $(".modeldeleteyes").attr('data-objectid', objectid);
            $(".modeldeleteyes").attr('data-objectname', object_name);
            $(".modeldeleteyes").attr('data-action', action);
            $(".modeldeleteyes").attr('data-folderid', folderid);
            $("#deleteWarning p").html("Do you realy want to delete this Routine <strong>" + object_name + "</strong>?");
            $("#deleteWarning").modal('show');
            return false;
        });

        //if user accept to delete park from model then process request
        $(document).on('click', '.modeldeleteyes', function () {
            var objectid = $('.modeldeleteyes').attr('data-objectid');
            var object_name = $('.modeldeleteyes').attr('data-objectname');
            var action = $('.modeldeleteyes').attr('data-action');
            var folderid = $('.modeldeleteyes').attr('data-folderid');
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/exercises/deleteExrecisebyFolder/' + objectid,
                data:{'folderid':folderid},
                success: function (deleteAction) {
                    var deleteuserdata = JSON.parse(deleteAction);
                    var extraMessageHtml = "";
                    if (deleteuserdata['status'] == true) {
                        extraMessageHtml = '<div class="alert alert-success">Video <strong>' + object_name + '</strong> deleted successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    } else {
                        extraMessageHtml = '<div class="alert alert-danger">Error while deleting Video <strong>' + object_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    }
                    $('.extraCustomMessage').html(extraMessageHtml);
                    $('#folder-' + objectid).fadeOut(1500);
                    return false;
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    
        $('#videoUploadModal').on('shown.bs.modal', function () {
            $('.has-error').children('p').remove('p');
            $('.has-error').removeClass('has-error');
            uploadedVideo='';
            $('.temp_video_display').html(uploadedVideo);
        });

        //Exercise Video Upload
        $(function () {

            var pluploader = new plupload.Uploader({
                runtimes: 'html5',
                browse_button: 'btnUploadVideo',
                url: base_url_Plimageupload,
                unique_names: true,
                multi_selection: true,
                chunk_size: '2mb',
                multipart_params: {
                    "folder": "exercises",
                    "names": "exercises"
                },
                filters: {
                    mime_types: [
                        {title: "Audio files", extensions: "mp4,mov,3gp,avi,divx,mpeg"},
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
                obj.originalname=file.name.replace(/\.[^/.]+$/, "")
                $('.modal_videoUploadProgres').addClass('hidden');
                
                $('.fullscreendiv').addClass('hidden');
                console.log(uploadedVideo);
                uploadedVideo += '<div class="col-md-12 m-b-15 margin-top-10 videotitlediv">' +'<input type="text" placeholder="Video Title" name="title[]" maxlength="100" class="form-control modal_video_title" value="' + file.name+ '"><input type="hidden" class="modal_video_name" name="modal_video_name[]" value="'+obj.name+'"/></div>'+'<div class="col-md-12 m-b-15 margin-top-10">'+
                        '<iframe src="' + base_url + 'assets/uploads/exercises/' + obj.name + '?autoPlay=false" frameborder="0" allowfullscreen class="previewIVideo"></iframe>' +
                        '<input type="hidden" name="temp_video_name[]" class="temp_video_name" value="' + obj.name + '">' +
                        '</div>';
                $('.temp_video_display').html(uploadedVideo);
            });
        });
       
        $(document).on('click', '.btnLoadAddVideo', function () {
            $('.modal_video_title').val('');
            $('.temp_video_display').html('');
            $('.modal_video_name').val('');
            $('.has-error').children('p').remove('p');
            $('.has-error').removeClass('has-error');
        });


        $('.crud_add_video').validate({
            rules: {
                title: "required"
            }, messages: {
                title: "Video Title should not be blank"
            }
        });

        $(document).on('click', '.btnAddNewVideo', function () {
            $validate=true;
            
            
           $( ".modal_video_name" ).each(function( index ) {
             var name = $(this).val();
         
            if (name == ""&&$validate==true) {
                 $('.selectNewVideo').parent('div').removeClass('has-error');
                $('.selectNewVideo').parent('div').children('p').remove('p');
                $('.selectNewVideo').parent('.form-group').addClass('has-error').append('<p class="has-error help-block">Please select exercise video</p>');
                $validate=false;
            }
            });
          $( ".modal_video_title" ).each(function( index ) {
             var name = $(this).val();
            if (name == ""&&$validate==true) {                
                
                $('.temp_video_display').children('.videotitlediv').removeClass('has-error');
                $('.temp_video_display').children('.videotitlediv').children('p').remove('p');
                $('.temp_video_display').children('.videotitlediv').addClass('has-error').append('<p class="has-error help-block">Please Enter Name of video</p>');
                $validate=false;
            }
    });
    var video_title=$(".modal_video_title").serializeArray();
    var name=$(".modal_video_name").serializeArray();
    var folderid=$(".folderid").val();
    
            if ($validate != false) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'admin/videos/addNewVideo',
                    data: {'title': video_title,'folderid': folderid, 'name': name},
                    success: function (actionResponse) {
                        var response = JSON.parse(actionResponse);
                        var id = response['data']['id'];
                        console.log(id);

                        /*var uploadedVideo = '<div class=" col-md-3" id="video-' + id + '">' +
                                '<div class="widget widget-inverse">' +
                                '<div class="widget-head">' +
                                '<h4 class="heading">' + video_title + ' </h4>' +
                                '<a class="deleteBtn" data-objectid="' + id + '"' +
                                'data-objectname="' + video_title + '"' +
                                'data-action="delete" data-toggle="modal" href="#deleteWarning" >' +
                                '<i class="glyphicon glyphicon-trash "></i>' +
                                '</a>' +
                                '</div>' +
                                '<div class="widget-body padding-none text-center">' +
                                '<video width="210" height="200" controls preload="none"  allowfullscreen="false">' +
                                '<source src="' + base_url + 'assets/uploads/exercises/' + name + '" type="video/mp4">' +
                                'Your browser does not support the video tag.' +
                                '</video>' +
                                '</div>' +
                                '</div>' +
                                '</div>  '; */
                        location.reload();
                        //$('#videos-container').prepend(uploadedVideo);
                    },
                    error: function (errorLog) {
                        console.log(errorLog);
                    }
                });
                //add video to Videos table
                $('#videoUploadModal').modal('hide');
                return false;
            }
            else {
                return false;
            }

        });
    </script>
