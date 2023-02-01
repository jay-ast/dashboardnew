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