<?php include 'header.php'; ?>

<link rel="stylesheet" href="/assets/custom/dist/css/BsMultiSelect.css"> 
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Routines</h1>
 <div data-id="AAAAAAA" class="tabsbar">
			<ul>
				<li class="glyphicons building <?php echo ($isgeneral==true)?'active':'' ?>"><a  href="<?php echo base_url('admin/exercisefolders/generalroutinesfolder'); ?>"><i></i> General Routines</a></li>
				 <li class="glyphicons parents <?php echo ($isgeneral==false)?'active':'' ?> "><a  href="<?php echo base_url('admin/exercisefolders/clientroutinesfolder'); ?>"><i></i> Client Routines </a></li>
		
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
        <div class="alert alert-info displaymessage hidden">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p></p>
        </div>
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none">
                <!-- Table -->
                <div class="row">
                 <?php echo form_open(base_url('admin/exercises/UpdateExercise'), array("class" => "exerciseForm","onsubmit"=>"return validateeditexForm()")); ?>
                  <div class="form-body clearfix col-md-12">
                        <div class="col-md-12">
                            <div data-id="111111" class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Name</label>
                                </div>
                                <div class="form-group col-md-10">                                            
                                    <input type="text" class="form-control exercise_name" maxlength="100" name="name" value="<?php echo $details['name'] ?>" placeholder="Routine Name"/>
                                  
                                </div>
                            </div>
                            <div data-id="222222"  class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Comments</label>
                                </div>
                                <div class="form-group col-md-10">
                                    <textarea placeholder="Routine Comments" class="form-control exercise_description col-md-12" rows="4" name="description"><?php echo $details['description'] ?></textarea>
                                </div>
                            </div>
                            
                            
                             <div data-id="333333"  class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Selected videos (<span id="videoCount"><?PHP echo count($assginedvideos); ?></span>)</label>
                                </div>
                                <div class="form-group col-md-10">  
                                    <div id = "divMain">
                                    <div id="Dragexercise" class="droppable">
                                      
                                    </div>
                                    <!--<input type="text" readonly="" class="videonames form-control" name="videonames" value="">  ---->
                                        <input type="hidden" class="videoids form-control" name="videoids" value="<?php echo implode(',',$assginedvideos) ?>">
                                </div>
                               </div>
                            </div>

                             <div class="row pull-right">
                            <button  class="btn btn-success btnLoadAddVideo" data-toggle="modal" href="#foldermodal"> <i class="fa fa-plus"></i> Add folder</button> 
                 
                            </div>  <br>
                            <br>

                            
                             <div data-id="444444"  class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Selected General Folders</label>
                                </div>
                                <div class="form-group col-md-10">

                                    <div class="row col-md-12">        
                                           <select name="generalfolderid[]" id="generalSelect" class="form-control"  multiple="multiple" style="display: none;">
	                                           <?php foreach($general_folders as $generalFolder)
                                         {
                                           $checked=(in_array($generalFolder['id'], $assginedfolder))?'SELECTED':'';
                                            echo'<option  '.$checked.' value="'.$generalFolder['id'].'"  >'.$generalFolder['folder_name'].'</option>';
                                           
                                         }?> 
										</select>                            
                                </div>
                            </div>
                                                        </div>
                            <?php if(isset($cleint_folders)&&!empty($cleint_folders)) { ?>
                            <div data-id="555555"  class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Choose your clients </label>
                                </div>
                                
                                <div class="form-group col-md-10"> 

                                    <div class="row col-md-12">
											<select placeholder="Click To Add" multiple class="form-control folders clientfolders"  name="clientfolderid[]">
                                       <?php
                                                                              
                                       foreach($cleint_folders as $clientfolder)
                                         {
                                           $selected=(in_array($clientfolder['id'], $assginedfolder))?'selected':'';
                                           echo'<option data-client ="'.$clientfolder['id'].'" value="'.$clientfolder['id'].'" '.$selected.'>'.$clientfolder['folder_name'].'</option>';
                                           
                                         }?>
                                          </select>
                                          <small>To create the routine select any videos from any of these folders</small>
                            </div>
                                                        </div>
                            
                            <?php } ?>
                            <div class="myfloatingbutton">
                            <button type="submit" class=" btn btn-success btnnewupdateuser" url="<?php echo base_url('admin/exercises/addNewExercise') ?>">Save as New</button> &nbsp;&nbsp;&nbsp;
                            <button type="submit" class=" btn btn-success btnupdateuser">Update</button>
                            </div>
<!--
                             <div data-id="BBBBBB" class="tabsbar">
                                 <input type="hidden" name="exerciseid" value="<?php echo $details['id']; ?>">
                                 
			<ul>
				<li class="glyphicons  generalvideos <?php echo ($isgeneral==true)?'active':'' ?>"><a  ><i></i> General Videos</a></li>
				
				<?php if($isgeneral==false) { ?><li class="glyphicons  clientvideos <?php echo ($isgeneral==false)?'active':'' ?> "><a  ><i></i> Client Videos</a></li>  <?php } ?>
		
			</ul>
		</div>
-->
		
                          
                            
             <div id="videos-container">
                 
                 <div class="generalvideoslist videolist <?php echo ($isgeneral==true)?'':'hidden' ?>">
                    <div class="form-group col-md-10">
<!--                                     Selected Exercies -->
                                    <select class="form-control generalfolderslist">
                                       <?php foreach($general_videos as $k=>$evv)
                                         {
                                           $class='';
                                           foreach($evv as $ev){
                                               
                                               if(in_array($ev['id'], $assginedvideos))
                                               {
                                                 $class='selected';                                                
                                                 break;
                                               }
                                                
                                           }
                                            echo'<option value="'.preg_replace("/[^a-zA-Z]+/", "", $k) .'" '.$class.'>'.$k.'</option>';
                                           
                                         }?>
                                          </select>
                                </div>  
                      <div class="row">  <div class="col-md-4"><input class="form-control videosearch" placeholder="Filter Video Name" name="vido_search" type="text"></div>                                       
                     </div><br><br>
            <?php foreach ($general_videos as $k=>$evv) { 
                
                 echo '<div class="row generalvideosfolder '.preg_replace("/[^a-zA-Z]+/", "", $k).'">  <h3>'.$k.'</h3> <br>';
                foreach($evv as $ev){
                   
                   
                        $class=(in_array($ev['id'], $assginedvideos))?'selected':'';
                    ?>
                <div class="col-xs-6 col-md-4 col-lg-4">
                    <div class="widget widget-inverse">
                        <div class="widget-head routineselector <?php echo $class ?>" id="video-<?php echo $ev['id']; ?>" data-videoid="<?php echo $ev['id']; ?>" data-videoname="<?php echo $ev['title']; ?>">
								<?php echo $ev['title']; ?>
                        </div>
                        <div class="widget-body padding-none text-center">
	                        <div class="videoThumb" style="background-image: url('<?php echo base_url('assets/uploads/exercises/thumbnails') . '/' . $ev['thumbnail']; ?>')" data-thumb="<?php echo base_url('assets/uploads/exercises/thumbnails') . '/' . $ev['thumbnail']; ?>" data-title="<?php echo $ev['title']; ?>" onclick="playVideo(this)" data-id="<?php echo $ev['id']; ?>" data-source="<?php echo base_url('assets/uploads/exercises') . '/' . $ev['name']; ?>"></div>


                        </div>

                    </div>
                </div>                    
                <?php } echo '</div>';}
                if(!isset($general_videos)||empty($general_videos)){echo '<div class="text-center"> No videos available</div>';}
                ?>  
                </div>
                 
                 <div class="publicvideoslist videolist hidden">
                     <div class="row">  <div class="col-md-4"><input class="form-control videosearch" placeholder="Filter Video Name" name="vido_search" type="text"></div>                                       
                     </div><br><br>
            <?php foreach ($public_videos as $k=>$ev) {                
                $class=(in_array($ev['id'], $assginedvideos))?'selected':'';
                    ?>
                <div class=" col-md-3 col-lg-4 routineselector <?php echo $class ?>" id="video-<?php echo $ev['id']; ?>" data-videoid="<?php echo $ev['id']; ?>" data-videoname="<?php echo $ev['title']; ?>">
                    <div class="widget widget-inverse">
                        <div class="widget-head">
                            <h4 class="heading " ><?php echo $ev['title']; ?> </h4>  
                            <i class="glyphicon glyphicon-check pull-right"></i>
                       
                        </div>
                        <div class="widget-body padding-none text-center">
                            <video width="210" height="200" controls preload="none"  allowfullscreen="false" poster="<?php echo base_url('assets/uploads/exercises/thumbnails') . '/' . $ev['thumbnail']; ?>">
                                <source src="<?php echo base_url('assets/uploads/exercises') . '/' . $ev['name']; ?>">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>                    
                <?php  }
                if(!isset($public_videos)||empty($public_videos)){echo '<div class="text-center"> No videos available</div>';}
                ?>  
                </div>
                 
                 
                   <div class="clientvideoslist videolist <?php echo ($isgeneral==true)?'hidden':'' ?>">
                       
                       
                       
                        <div class="form-group col-md-10">
                                    
                                    <select class="form-control clientfolderslist">
                                       <?php foreach($client_videos as $k=>$evv)
                                         {
                                           $class='';
                                           foreach($evv as $ev){
                                               
                                               if(in_array($ev['id'], $assginedvideos))
                                               {
                                                 $class='selected';                                                
                                                 break;
                                               }
                                                
                                           }
                                            echo'<option value="'.str_replace(' ', '', $k).'" '.$class.'>'.$k.'</option>';
                                           
                                         }?>
                                          </select>
                                       
                                </div> 
                       
                       
                       <div class="row">  <div class="col-md-4"><input class="form-control videosearch" placeholder="Video Name" name="vido_search" type="text"></div>                                       
                     </div><br><br>
            <?php foreach ($client_videos as $k=>$evv) { 
                echo '<div class="row clientvideosfolder '.str_replace(' ', '', $k).'">  <h3>'.$k.'</h3> <br>';
                foreach($evv as $ev){
                    $class=(in_array($ev['id'], $assginedvideos))?'selected':'';
                    ?>
                <div class=" col-md-3 routineselector <?php echo $class ?>" id="video-<?php echo $ev['id']; ?>" data-videoid="<?php echo $ev['id']; ?>" data-videoname="<?php echo $ev['title']; ?>">
                    <div class="widget widget-inverse">
                        <div class="widget-head">
                            <h4 class="heading " ><?php echo $ev['title']; ?>  </h4>
                            <i class="glyphicon glyphicon-check pull-right"></i>
                        </div>
                        <div class="widget-body padding-none text-center">
	                        <img src="<?php echo base_url('assets/uploads/exercises/thumbnails') . '/' . $ev['thumbnail']; ?>"/>
	                        
<!--
                            <video width="210" height="200" controls preload="none"  allowfullscreen="false" poster="<?php echo base_url('assets/uploads/exercises/thumbnails') . '/' . $ev['thumbnail']; ?>">
                                <source src="<?php echo base_url('assets/uploads/exercises') . '/' . $ev['name']; ?>">
                                Your browser does not support the video tag.
                            </video>
-->
                        </div>
                    </div>
                </div>                    
                <?php } echo '</div>'; }
                if(!isset($client_videos)||empty($client_videos)){echo '<div class="text-center"> No videos available</div>';}
                ?>  
                </div>
                 
        </div>
                                                 
                        </div>                   
                    </div>
                    <div class="clearfix"></div>
                    <?php echo form_close(); ?>
                              
            </div>
        </div>       

    </div>
    <!--Model user details-->
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
    
    
    <!--Model user details-->
    <!-- /.modal-dialog --> 
    <div id="showVideo"  class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Video Preview: <span id="titleVideo"></span></h4>
                </div>
                <div>
                     <video width="100%" height="650" controls preload="none"  allowfullscreen="false" poster="">
                                <source id="videoSource" src="">
                                Your browser does not support the video tag.
                            </video>

                </div>
                <!-- dialog buttons -->
                <div class="modal-footer"> 
	                 <button type="button" color="blue" class="btn btn-primary" data-action="" data-dismiss="modal">Insert</button>
                    <button type="button" class="btn btn-danger" data-action="" data-dismiss="modal">Close</button>
                </div>                  
            </div>
        </div>
    </div>

       <div class="modal fade" id="foldermodal">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
               <?php echo form_open(base_url('admin/folders/addgeneralfolderajax'), array('class' => 'addgeneralfolder')); ?>                   
                        
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Create new folder</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-body clearfix col-md-12">
                            <div class="col-md-12">
                                    
                               <div data-id="666666"  class="row margin-top-10">
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
                            <button type="button" class="btn btn-success btnAddnewfolder">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>


</div>
<?php include 'footer.php'; ?>   

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="/assets/custom/dist/js/BsMultiSelect.js"></script>


    
<script>
   
    var base_url = '<?php echo base_url(); ?>';
    var base_url_Plimageupload = '<?php echo base_url('admin/exercises/Pluploader'); ?>';
    
<?php
	 $exercise_videos = [];
	 
if (!empty($exercise_videos)) {
    foreach ($exercise_videos as $exc) {
        ?>
            $('.ex_list_to').append('<option value="<?php echo $exc['id']; ?>"> <?php echo  str_replace("'", "", $exc['title']); ?></option>');
            $exercise_videos.push({'id':<?php echo $exc['id']; ?>, 'name': '<?php echo  str_replace("'", "", $exc['title']); ?>', 'title': '<?php echo $exc['name']; ?>'});
        <?php
    }
}
?>

    $order = 1;
   
    // delete warning model
    $(document).on('click', '.deleteBtn', function () {
        var objectid = $(this).attr('data-objectid');
        var object_name = $(this).attr('data-objectname');
        var action = $(this).data('action');
        $(".modeldeleteyes").attr('data-objectid', objectid);
        $(".modeldeleteyes").attr('data-objectname', object_name);
        $(".modeldeleteyes").attr('data-action', action);
        $("#deleteWarning p").html("Do you realy want to delete this Routine <strong>" + object_name + "</strong>?");
        $("#deleteWarning").modal('show');
        return false;
    });
    
    
playVideo = function(me){
		var urlVideo = $(me).attr("data-source");
		var titleVideo = $(me).attr("data-title");
		var thumbVideo = $(me).attr("data-thumb");
		
		$("#titleVideo").html(titleVideo)
		$("#showVideo").modal('show');
//		$("#videoSource").attr("src",urlVideo)
		    var video = document.getElementsByTagName('video')[0];
		    var sources = video.getElementsByTagName('source');
		    sources[0].src = urlVideo;
			video.poster = thumbVideo;
		    video.load();
    
	}
    
    $("select").bsMultiSelect();
    $("#generalSelect").change(function(item){
	    console.log($("#generalSelect").val().length)
    })
  
    //if user accept to delete park from model then process request
    $(document).on('click', '.modeldeleteyes', function () {
        var objectid = $('.modeldeleteyes').attr('data-objectid');
        var object_name = $('.modeldeleteyes').attr('data-objectname');
        var action = $('.modeldeleteyes').attr('data-action');
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/exercises/deleteExercise/' + objectid,
            success: function (deleteAction) {
                var deleteuserdata = JSON.parse(deleteAction);
                var extraMessageHtml = "";
                if (deleteuserdata['status'] == true) {
                    extraMessageHtml = '<div class="alert alert-success">Routine <strong>' + object_name + '</strong> deleted successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                } else {
                    extraMessageHtml = '<div class="alert alert-danger">Error while deleting Routine <strong>' + object_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                }
                $('.extraCustomMessage').html(extraMessageHtml);
                $('#exercise-' + objectid).fadeOut(1500);
                return false;
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    $(document).on('click', '.btnAddExercise', function () {
        $('.btnSaveExercise').removeClass('hidden');
         
        $('.btnupdateuser').addClass('hidden');
        //reset field values
        $('.exerciseid').val("");
        $('.exercise_name').val("");
        $('.exercise_description').val("");
        $('.uploadedVideosDisplayArea').html('');
        $('.btnAddNewVideo').removeAttr('data-exerciseid');
        $('.selectNewVideo').val("");
        $('.assignes_ex_div').html('');
        $order = 1;
        $('#ex_list_to').find('option').remove();
        for (var key in $exercise_videos) {
            var id = $exercise_videos[key]['id'];
            var text = $exercise_videos[key]['name'];
            $('#ex_list_to').append('<option value="' + id + '">' + text + '</option>');
        }

    });
    $('#videoUploadModal').on('shown.bs.modal', function () {
        $('.has-error').children('p').remove('p');
        $('.has-error').removeClass('has-error');
    });

    //btn get exercise details
    $(document).on('click', '.btnExerciseDetails', function () {
        $('.fullscreendiv').removeClass('hidden');
        var objectid = $(this).attr('data-objectid');
        $('.btnSaveExercise').addClass('hidden');
        $('.btnupdateuser').removeClass('hidden');

        $('#ex_list_to').find('option').remove();
        for (var key in $exercise_videos) {
            var id = $exercise_videos[key]['id'];
            var text = $exercise_videos[key]['name'];
            $('#ex_list_to').append('<option value="' + id + '">' + text + '</option>');
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/exercises/getExerciseDetails/' + objectid,
            success: function (actionResponse) {
                var exerciseData = JSON.parse(actionResponse);
                $('.uploadedVideosDisplayArea').html('');
                $('.exerciseid').val(objectid);
                $('.exercise_name').val(exerciseData['data']['details']['name']);
                $('.exercise_description').val(exerciseData['data']['details']['description']);
                $('.btnAddNewVideo').attr('data-exerciseid', objectid);
                var ex_videos = exerciseData['data']['videos'];
                var ex_videos_len = ex_videos.length;
                $order = 1;
                $('.assignes_ex_div').html('');
                for (var i = 0; i < ex_videos_len; i++) {
                    var id = ex_videos[i]['id'];
                    //var name = ex_videos[i]['name'];
                    var title = ex_videos[i]['title'];
                    var orderno = ex_videos[i]['order'];

                    var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                            '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-id="' + id + '" data-text="' + title + '">&times;</button>' +
                            '<span style="line-height: 30px;">' + title + '</span>' +
                            '<input type="hidden" name="assigned_video[]" class="assigned_video" value="' + id + '"/>' +
                            '<input type="hidden" name="assigned_video_order[]" class="assigned_video_order" value="' + orderno + '"/>' +
                            '</label></div>';
                    $('.assignes_ex_div').append(appen_html);

                    $('#ex_list_to option[value=' + id + ']').remove();
                    $order = orderno;
                }
                $('.fullscreendiv').addClass('hidden');
                $('#responsiveExercisedetails').modal('show');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });


 //btn get exercise details
    $(document).on('click', '.btnAddnewfolder', function (e) {
        e.preventDefault();
        $url=$('.addgeneralfolder').attr('action');
       $.ajax({
                    url: $url,
                    type: "post",
                    data: $('.addgeneralfolder').serialize(),
                    dataType  : 'json',
                    success: function (response) {                       
                        if(response.success==true)
                        {                            
                            $('.generalfolders').append($('<option>', {
                                value:response.folder_id,
                                text: response.folder_name
                            }));
                            $('#foldermodal').modal('hide');
                        }else{
                            $('#foldermodal').modal('hide');
                        }
                       // you will get response from your php page (what you echo or print)                 

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       console.log(textStatus, errorThrown);
                       $('#foldermodal').modal('hide');
                    }


                });
    });


    $('#responsiveExercisedetails').on('hidden.bs.modal', function () {
        $('.has-error').children('p').remove('p');
        $('.has-error').removeClass('has-error')
    });


    //perform validation..
    $(document).on('ready', function () {
        $('.exerciseForm').validate({
            ignore: "not:hidden",
            rules: {
                name: "required",
                videoids: "required",
            },
            messages: {
                name: "Exercise name should not be blank",
                videoids: "Plese select atleast one video from listed videos"
            }
        });
        $('.crud_add_video').validate({
            rules: {
                title: "required",
                modal_video_name: "required"
            },
            messages: {
                title: "Routine name should not be blank",
                modal_video_name: "Please select Routine video"
            }
        });
    })
    
    $(document).on('click', '.btnnewupdateuser', function () {
        $(this).parents('form').attr('action',$(this).attr('url'));
        //alert($(this).parents('form').html());
       // return false;
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
                    '<input type="hidden" name="assigned_video_order[]" class="assigned_video_order" value="' + $order + '"/>' +
                    '</label></div>';
            $('.assignes_ex_div').append(appen_html);
            $order++;
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
    
    
    $(document).on('click', '.clientvideos', function () {
        $(this).addClass('active');
        $('.generalvideos').removeClass('active');
        $('.publicvideos').removeClass('active');
        var clientfolderslistlength = $('.clientfolderslist').children('option').length;
        if(clientfolderslistlength>0){
        $('.clientfolderslist').trigger('change');}
        $('.clientvideoslist').removeClass('hidden');
        $('.clientvideoslist').fadeIn(300)        
        $('.generalvideoslist').fadeOut(300)
        $('.publicvideoslist').fadeOut(300)
        
          
    });
    $(document).on('click', '.generalvideos', function () {
        $(this).addClass('active');
        $('.clientvideos').removeClass('active');
        $('.publicvideos').removeClass('active');
        var generalfolderslistlength = $('.generalfolderslist').children('option').length;
      //  $('.generalfolderslist').trigger('change');
        if(generalfolderslistlength>0){
        $('.generalfolderslist').trigger('change');}
         $('.generalvideoslist').removeClass('hidden');
         $('.generalvideoslist').fadeIn(300)
        $('.clientvideoslist').fadeOut(300)
        $('.publicvideoslist').fadeOut(300)
        

    });
    
    $(document).on('click', '.publicvideos', function () {
        $(this).addClass('active');
         $('.clientvideos').removeClass('active');
         $('.generalvideos').removeClass('active');
         $('.publicvideoslist').removeClass('hidden');
         $('.generalvideoslist').fadeOut(300)
        $('.clientvideoslist').fadeOut(300)
        $('.publicvideoslist').fadeIn(300)

    });
    
      var videosid = [];
   var videosname = [];
<?php if (!empty($assginedvideosname)) {
    foreach ($assginedvideosname as $key=>$name) {
        ?>
            $vname="<?php echo $name ?>";
            $vid="<?php echo $assginedvideos[$key] ?>";
            videosname.push($vname);
            $dragdiv='<div id="Exreciseid'+$vid+'" dataid='+$vid+' class="draggable">'+$vname+'<a class="deleteVideo pull-right" dataid="'+$vid+'"> <i class="glyphicon glyphicon-trash "></i></a></div>';
            $('.droppable').append($dragdiv);
        <?php
    }
} 
if (!empty($assginedvideos)) {
    foreach ($assginedvideos as $key=>$vid) {
        ?>
            $vid=<?php echo $vid ?>;
           videosid.push($vid);
        <?php
    }
}     
?>
   
     $(document).on('click', '.routineselector', function () {
   
         $this=$(this);
         $videoid=$this.attr('data-videoid');
         $videoname=$this.attr('data-videoname');
         
         if($this.hasClass('selected'))
         {
            $('#Exreciseid'+$videoid).remove();
            videosid.splice($.inArray($videoid, videosid), 1);
            videosname.splice($.inArray($videoname, videosname), 1);
             $this.removeClass('selected');
         }
         else{ 
             if(jQuery.inArray( $videoid, videosid )<0)
             {
               $dragdiv='<div id="Exreciseid'+$videoid+'" dataid='+$videoid+' class="draggable">'+$videoname+' <a class="deleteVideo pull-right" dataid="'+$videoid+'"> <i class="glyphicon glyphicon-trash "></i></a></div>'
               $('.droppable').append($dragdiv)
              videosid.push($videoid)
              videosname.push($videoname)}
             $this.addClass('selected');
         }
         
       
      
        $('.videoids').val(videosid);
        $('.videonames').val(videosname);
        $("#videoCount").html(jQuery(".draggable").length)
       
    });
    function validateeditexForm()
    {
         var checkedfolders = [];
        $('input.folders:select:selected').each(function () {
            checkedfolders.push($(this).val());
        });
        $('input.folders:checkbox:checked').each(function () {
            checkedfolders.push($(this).val());
        });
        if(checkedfolders.length <= 0){
            alert('Select any of the folder to create routine')
            return false;
        }
        
    }
    
    
     $('.videosearch').on('input', function() {
     
     $this=$(this);
    if($this.val()==''){$this.parents('.videolist').find('.routineselector').removeClass('hidden');return false;}
         
       
       
       
       $this.parents('.videolist').find('.routineselector').addClass('hidden');
       $this.parents('.videolist').find('.routineselector').each(function () {
            if($(this).attr('data-videoname').toLowerCase().includes($this.val().toLowerCase()))
            {
                $(this).removeClass('hidden');
            }
        });
});



$('.generalfolderslist').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    $('.generalvideosfolder').addClass('hidden');
     $('.'+valueSelected).removeClass('hidden');
});


$('.clientfolderslist').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    $('.clientvideosfolder').addClass('hidden');
     $('.'+valueSelected).removeClass('hidden');
});


$("#generalfoldersearch").on('input',function(e){
        var value = this.value.toLowerCase().trim();
    if(value==''){
        $(".generalfolders option").show();
    }

    $(".generalfolders option").hide();
    $(".folders option").each(function() {

        if($(this).text().toLowerCase().trim().indexOf(value)>=0){
            $(this).show();
        }

    });

    });


    $("#clientfoldersearch").on('input',function(e){
        var value = this.value.toLowerCase().trim();
        if(value==''){
            $(".clientfolders option").show();
        }

        $(".clientfolders option").hide();
        $(".clientfolders option").each(function() {

            if($(this).text().toLowerCase().trim().indexOf(value)>=0){
                $(this).show();
            }

        });

    });




$(document).ready(function() {

    $(".droppable").sortable({
      update: function( event, ui ) {
        Dropped();
      }
    });
    
       
    $(document).on('click','.draggable .deleteVideo', function() {        
        $this=$(this);
        $videoname=$this.parent('.draggable').text();
        $videoid=$this.attr('dataid');
        $('#video-'+$videoid).removeClass('selected');
        
            $('#Exreciseid'+$videoid).remove();
            videosid.splice($.inArray($videoid, videosid), 1);
            videosname.splice($.inArray($videoname, videosname), 1);
            $this.removeClass('selected');
            
            $('.videoids').val(videosid);
            
            $("#videoCount").html(jQuery(".draggable").length)
     });

});	
    
    
    
function Dropped(event, ui){
        videosid=[];
      $(".draggable").each(function(){            
         
          videosid.push($(this).attr('dataid'))
          $('.videoids').val(videosid);
      });
      $('.videoids').val(videosid);      
    }
</script> 

<style>
	    .badge{
		    background-color: #cb4040;
		    margin-right: 5px;
	    }
	    .myroutineselector {
		    background-color: grey;
	    }
        .routineselector .widget-head i{visibility: hidden;}
        .routineselector.selected .widget-head i{visibility: visible;}
        .glyphicons.publicvideos,.glyphicons.generalvideos,.glyphicons.clientvideos{cursor: pointer;}
        .videoThumb{
				background-size: contain;
				height: auto;
				background-position: center center;
				background-repeat: no-repeat;
				cursor: pointer;
				min-height: 140px;
        }
        span {
	        padding-left: 10px;
	        padding-right: 10px;
        }
        
        .custom-control-label{
	        margin-left: 5px;
        }
        
        .myfloatingbutton{
	        position: fixed;
	        bottom: 45px;
	        left: 35px;
	        z-index: 90;
        }
        .widget .widget-head {
	        line-height: 22px;
	        padding-left: 9px;
        }
         .draggable {
		    background: #eee none repeat scroll 0 0;
		    border: 1px solid #000;
		    cursor: move;
		    font-weight: bold;
		    margin: 2px;
		    max-width: 500px;
		    padding: 5px;
		    text-align: center;
		}
    </style>
    
