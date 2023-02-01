<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
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
    <h1 class="bg-white content-heading border-bottom">Routines...</h1>
 <div class="tabsbar">
			<ul>
				<li class="glyphicons building <?php echo ($isgeneral==true)?'active':'' ?>"><a  href="<?php echo base_url('admin/exercisefolders/generalroutinesfolder/?isgen=1'); ?>"><i></i> General Routines </a></li>
				<li class="glyphicons parents <?php echo ($isgeneral==false)?'active':'' ?> "><a  href="<?php echo base_url('admin/exercisefolders/clientroutinesfolder/?isgen=0'); ?>"><i></i> Client Routines  </a></li>
		
			</ul>
		</div>

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
            <div class="widget-body padding-bottom-none">                
                <div class="row margin-bottom-10">
                    <div class="col-md-12">
                        <?php echo form_open((($isgeneral==false)?base_url('admin/exercisefolders/clientroutinesfolder'):base_url('admin/exercisefolders/generalroutinesfolder')), array('class' => 'crud_ex_video')); ?>                   
                        <div class="col-md-4">
	                        
	                        <input id="folder_name_search" type="text" class="form-control" placeholder="<?php
                            if (isset($video_name)) {
                                echo $video_name;
                            } else {
	                            if($isgeneral){
		                        echo 'Folder Name';    
	                            }else{
		                            echo 'Client Name';
	                            }
                                
                            }
                            ?>" name="folder_name" /></div>

                        <div class="col-md-3">
							<div id="searchBtn" class="btn btn-info btn-stroke">Search</div> 
                          <?php echo ($isgeneral==true)? '<a class="btn btn-success btnLoadAddVideo" data-toggle="modal" href="#foldermodal"> <i class="fa fa-plus"></i> Add</a>':''; ?>
                         
                           
                        </div>                        
                        <?php echo form_close(); ?>      
                    </div>
                    <small id="counter" style="margin-left: 21px;"></small>
                </div> 
                <div class="clearfix"><br></div>

            </div>

        </div>  
        <div id="videos-container">
           <table class="dynamicTable tableTools table table-striped checkboxs" id="routineTable">
                        <!-- Table heading -->
                        <thead>
                            <tr class=" text-center">                              
                                <th>Name</th>
                                <th>Number of Routines</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <!-- // Table heading END -->
                        <!-- Table body -->
                        <tbody id="myTable"> 
                            <?php
                            if (isset($general_folders)) {
                                //echo "<pre>";
                              //  print_r($complist);exit;
                                foreach ($general_folders as $folderdata) {
                                   // print_r($folderdata)
                                    
                                    ?>
                                    <tr class="gradeX " data-id="44444" id="folder-<?php echo $folderdata['id']; ?>">      

                                        
                                        <td><a href="<?php echo base_url('admin/exercisefolders/detail').'/'.$folderdata['id'] ?>"><?php echo $folderdata['folder_name'];?></td> 
                                        <td><?php echo $folderdata['routinecount'];?></td> 
                                       
                                        <td class="center">
                                            <a data-objectid="<?php echo $folderdata['id']; ?>" 
                                               data-objectname="<?php echo $folderdata['folder_name']; ?>"
                                               data-action="active"  class="deleteBtn danger"> <i class="glyphicon glyphicon-trash " data-toggle="tooltip" title="" data-original-title="Delete Folder"></i> </a>
                                             
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
<!-- 
        <div class="row">
            <div class="col-md-12">
                <div class="jquery-bootpag-pagination pull-right">
                    <ul class="bootpag pagination">
               
                        <?php
                        // if (!empty($exercise_videos)) {
                        //     foreach ($links as $link) {
                        //         echo "<li>" . $link . "</li>";
                        //     }
                        // }
                        ?>
                    </ul>
                </div>
            </div>
        </div> -->
    </div>  

    <!--Model Upload Video Dialouge-->
    <?php if($isgeneral==true) { ?>
    <div class="modal fade" id="foldermodal">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
               <?php echo form_open((($isgeneral==false)?base_url('admin/exercisefolders/addclientfolder'):base_url('admin/exercisefolders/addgeneralfolder')), array('class' => 'crud_ex_video')); ?>                   
                        
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Create new folder</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-body clearfix col-md-12">
                            <div class="col-md-12">
                                    
                               <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Folder Name</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input class="form-control foldername" name="foldername" placeholder="Folder name" type="text">
                                </div>
                            </div>          
                            </div>
                            <div class="clearfix"></div>                            
                        </div>
                        <div class="clearfix"></div>   

                    </div>
                    <div class="modal-footer">
                        <div class="form-group col-md-12 text-center">                                            
                            <button type="submit" class="btn btn-success btnAddnewfolder">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?php } else{?>
    
    <div class="modal fade" id="foldermodal">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
               <?php echo form_open((($isgeneral==false)?base_url('admin/exercisefolders/addclientfolder'):base_url('admin/exercisefolders/addgeneralfolder')), array('class' => 'crud_ex_video')); ?>                   
                        
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Create new folder</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-body clearfix col-md-12">
                            <div class="col-md-12">
                                    
                               <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Folder Name</label>
                                </div>
                                <div class="form-group col-md-9">
                                     <select name="foldername">
                                    <?php foreach($folder_remained as $folder)
                                    { echo '<option value="'.$folder["id"].'">'.$folder["firstname"].' '.$folder["lastname"].'</option>';
                                            
                                       } ?>
                                       </select> 
                                   
                                    <!--<input class="form-control foldername" name="foldername" placeholder="Folder name" type="text"> --->
                                </div>
                            </div>          
                            </div>
                            <div class="clearfix"></div>                            
                        </div>
                        <div class="clearfix"></div>   

                    </div>
                    <div class="modal-footer">
                        <div class="form-group col-md-12 text-center">                                            
                            <button type="submit" class="btn btn-success btnAddnewfolder">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    
    <?php } ?>
    

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
    
        function filterGlobal () {
                $('#routineTable').DataTable().search(
                    $('#folder_name_search').val()
                ).draw();
            }
                    
        $(document).ready( function () {
            $('#routineTable').DataTable();
            $('input#folder_name_search').on( 'keyup click', function () {
                    filterGlobal();
                } );
        } );

        var base_url = '<?php echo base_url(); ?>';
        var base_url_Plimageupload = '<?php echo base_url('admin/exercises/Pluploader'); ?>';

        // delete warning model
        $(document).on('click', '.deleteBtn', function () {
            var objectid = $(this).attr('data-objectid');
            var object_name = $(this).attr('data-objectname');
            var action = $(this).data('action');
            $(".modeldeleteyes").attr('data-objectid', objectid);
            $(".modeldeleteyes").attr('data-objectname', object_name);
            $(".modeldeleteyes").attr('data-action', action);
            $("#deleteWarning p").html("Do you realy want to delete this Folder <strong>" + object_name + "</strong>?");
            $("#deleteWarning").modal('show');
            return false;
        });

        //if user accept to delete park from model then process request
        $(document).on('click', '.modeldeleteyes', function () {
            var objectid = $('.modeldeleteyes').attr('data-objectid');
            var object_name = $('.modeldeleteyes').attr('data-objectname');
            var action = $('.modeldeleteyes').attr('data-action');
            var url= '<?php echo (($isgeneral==false)?base_url('admin/exercisefolders/deleteclientfolder/'):base_url('admin/exercisefolders/deletegeneralfolder/')) ?>';
            $.ajax({
                type: 'POST',
                url:url+'/'+ objectid,
                success: function (deleteAction) {
                    var deleteuserdata = JSON.parse(deleteAction);
                    var extraMessageHtml = "";
                    if (deleteuserdata['status'] == true) {
                        extraMessageHtml = '<div class="alert alert-success">Folder <strong>' + object_name + '</strong> deleted successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    } else {
                        extraMessageHtml = '<div class="alert alert-danger">Error while deleting Folder <strong>' + object_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
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
        
		$("#searchBtn").click(function(){
			 $("#folder_name").blur()
		})
        $("#folder_name").blur(function(){
			$.ajax({ 
		    type: 'POST', 
		    url: '/admin/exercisefolders/index_search', 
		    data: { folder_name: $("#folder_name").val(), is_general: '<?PHP echo $isgeneral; ?>' }, 
		    dataType: 'json',
		    success: function (data) { 
			       console.info(data)

			       $("#myTable").html("");
			       var patients = data.general_folders;
			       console.log("LEN")
			       if(!patients){
				       $("#myTable").append(`<tr class="gradeX"><td colspan="5" class="text-center">No Folders available.</td></tr>`)
				       $("#counter").html("")
			       }else{
				       $("#counter").html(patients.length + " Search Result")
				       patients.forEach(function(patient){
					   $("#myTable").append(`<tr class="gradeX " data-id="55555" id="folder-`+patient.id+`">                  
	                            <td><a href="/admin/exercisefolders/detail/`+patient.id+`">`+patient.folder_name+`</td> 
	                            <td>`+patient.routinecount+`</td> 
	                            <td class="center">
	                                <a data-objectid="`+patient.id+`" 
	                                   data-objectname="`+patient.folder_name+`"
	                                   data-action="active"  class="deleteBtn danger"> <i class="glyphicon glyphicon-trash " data-toggle="tooltip" title="" data-original-title="Delete Folder"></i> </a>
	                                 
	                                </td>
	                        </tr>`)
					   });
			       }
				   

			       
			    }
			});
        })
    
   
        $('.crud_add_video').validate({
            rules: {
                foldername: "required"
            }, messages: {
                foldername: "Folder name should not be blank"
            }
        });
    </script>

    <style>
        #routineTable_filter {
            display: none;
        }
    </style>
    <style>
    #routineTable_paginate .paginate_button:hover {
        background-color: #eee !important;
    }
    #routineTable_paginate {
        margin: 20px 0;
        border-radius: 4px;
    }
    #routineTable_filter {
        display: none;
    }
    #routineTable_previous {
        color: #cb4040 !important;
        background: #fff;
    }
    #routineTable_paginate .paginate_button.current {
        background: #428bca !important;
        color: #fff !important;
    }
    #routineTable_paginate .paginate_button {
        background: #FFF !important;
        color: #cb4040 !important;
        border: 1px solid #ddd;
    }
    </style>
