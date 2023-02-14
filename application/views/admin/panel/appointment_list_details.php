<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Appointments Types</h1>
    <div class="innerAll spacing-x2">
        <div class="extraCustomMessage">
        </div>
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none appointment_details">
                <div class="row">
                    <div class="col-md-2 pull-right" style="margin-bottom: 10px;">
                        <a class="btn btn-success btnAddAppointmentType col-sm-12" data-toggle="modal" href="#createAppointmentType"> <i class="fa fa-plus"></i> Add</a>
                    </div>
                    <table class="dynamicTable tableTools table table-striped checkboxs">
                        <thead>
                            <tr class=" text-center">                                
                                <th>Appointment Type</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            if (isset($appoitment_type)) {
                                foreach ($appoitment_type as $appointment_list) {
                                $color =  $appointment_list->color_code;
                            ?>
                                    <tr class="gradeX">                                        
                                        <td><?php echo $appointment_list->appointment_name ?></td>
                                        <td>
                                            <span style="height: 30px; width: 50%; display: block; background-color: <?php echo $color ?>"></span>
                                        </td>
                                        <td><?php echo $appointment_list->appointment_price ?></td>
                                        <td>
                                            <a class="editBtn" data-typeid="<?php echo $appointment_list->id; ?>" data-appointmantname="<?php echo $appointment_list->appointment_name; ?>" data-action="edit" data-toggle="modal" href="#createAppointmentType">
                                                <i class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Edit Appointment Type"></i></a>
                                            <?php 
                                                if($appointment_list->event_count == 0){
                                            ?>
                                                <a class="deleteBtn" data-typeid="<?php echo $appointment_list->id; ?>" data-appointmantname="<?php echo $appointment_list->appointment_name; ?>" data-action="delete" data-toggle="modal" href="#deleteWarning">
                                                <i class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Delete Appointment Type"></i></a>
                                            <?php 
                                                }
                                            ?>                                            
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr class="gradeX"><td colspan="5" class="text-center">No Events available.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="jquery-bootpag-pagination pull-right">
                        <ul id="myLinks" class="bootpag pagination">                            
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
</div>

<div id="createAppointmentType" class="modal fade">
    <div class="modal-dialog new-modal-dialog">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New Appointment Type</h4>
            </div>

            <div class="modal-body modelform">
                <div class="error"></div>
                <div class="form-body clearfix col-md-12">
                    <div class="row margin-top-10">
                        <div class="form-group col-md-6">
                            <input type="hidden" class="form-control appointment_type_id" id="appointment_type_id" name="appointment_type_id" value="">
                        </div>
                    </div>
                    <div class="col-md-12 userdetail">
                        <div class="row margin-top-10 userdetails col-md-12">
                            <div class="form-group col-md-4">
                                <label>Appointment Name</label>
                            </div>
                            <div class="form-group col-md-8">
                                <textarea type="text" class="form-control appointment_name" rows="6" id="appointment_name" name="appointment_name" placeholder="Appointment Name"></textarea>
                            </div>
                        </div>

                        <div class="row margin-top-10 userdetails col-md-12">
                            <div class="form-group col-md-4">
                                <label>Color</label>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="color" class="form-control color_code" id="color_code" name="color_code" placeholder="olor Code" />
                            </div>
                        </div>

                        <div class="row margin-top-10 userdetails col-md-12">
                            <div class="form-group col-md-4">
                                <label>Price</label>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="number" class="form-control appointment_price" id="appointment_price" name="appointment_price" placeholder="Appointment Price" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <button type="button" class="client-portal-button addAppointmentTypeDetails" id="addAppointmentTypeDetails">Add Appointment Type</button>
                            <button type="button" class="client-portal-button updateAppointmentTypeDetails" id="updateAppointmentTypeDetails">Update Appointment Type</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="deleteWarning" class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Appointment</h4>
                </div>
                <div class="modal-body alert-message">
                    <p style="margin: 10px 0px; font-size: 15px;"></p>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success deleteTypeDetails" data-action="" data-typeid data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-danger no" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

<?php include_once 'footer.php'; ?>
<script>
    $(document).ready(function() {
        var base_url = '<?php echo base_url(); ?>';
        
        $(document).on('click', '.btnAddAppointmentType', function(e) {    
            $('#createAppointmentType').find('#addAppointmentTypeDetails').show()
            $('#createAppointmentType').find('#updateAppointmentTypeDetails').hide()            
        });
        
        $(document).on('click', '.addAppointmentTypeDetails', function(e) {              
            if ($('#appointment_name').val() && $("#appointment_price").val()) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'admin/appointment/addNewAppointmentType',
                    beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },
                    data: {
                        appointment_name: $('#appointment_name').val(),
                        color: $('#color_code').val(),
                        appointment_price: $('#appointment_price').val(),
                    },
                    success: function(result) {
                        var typedata = JSON.parse(result);
                        $('#createAppointmentType').modal('toggle');
                        var extraMessageHtml = "";
                        if (typedata['success'] == true) {
                            extraMessageHtml = '<div class="alert alert-success">' + typedata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        } else {
                            extraMessageHtml = '<div class="alert alert-danger">' + typedata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        }
                        $('.extraCustomMessage').html(extraMessageHtml);                        
                        window.location.reload();
                        return false;

                    },
                    complete: function() {},
                    error: function(data) {
                        console.log(data);
                    }
                });
            } else {
                $('.error').html('Appointment name and Price is required');
                return false;
            }
        });

        $(document).on('click', '.deleteBtn', function() {
            var typeid = $(this).attr('data-typeid');
            $(".deleteTypeDetails").attr('data-typeid', typeid);
            $("#deleteWarning p").html("Are you sure you want to delete this appointment type?");            
            return false;
        });

        
        $(document).on('click', '.deleteTypeDetails', function() {
            var typeid = $('.deleteTypeDetails').attr('data-typeid');

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/appointment/deleteAppointmentType/' + typeid,
                success: function(deleteAction) {                    
                    var deleteuserdata = JSON.parse(deleteAction);
                    var extraMessageHtml = "";
                    if (deleteuserdata['success'] == true) {
                        extraMessageHtml = '<div class="alert alert-success">' + deleteuserdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    } else {
                        extraMessageHtml = '<div class="alert alert-danger">' + deleteuserdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    }
                    $('.extraCustomMessage').html(extraMessageHtml);                    
                    window.location.reload();
                    return false;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '.editBtn', function() {
            var typeid = $(this).attr('data-typeid');
            $('#createAppointmentType').find('#addAppointmentTypeDetails').hide()
            $('#createAppointmentType').find('#updateAppointmentTypeDetails').show()
            $('#createAppointmentType').find('.modal-title').html('Edit Appointment Type');    
                        
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/appointment/editAppointmentType/' + typeid,
                success: function(data) {                    
                    var appointmentTypeData = JSON.parse(data);                    
                    $.each(appointmentTypeData['data'], function (key, val) {                        
                        $('#createAppointmentType').find('#appointment_type_id').val(val.id);
                        $('#createAppointmentType').find('#appointment_name').val(val.appointment_name);
                        $('#createAppointmentType').find('#color_code').val(val.color_code);
                        $('#createAppointmentType').find('#appointment_price').val(val.appointment_price);
                    });                    
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        
        $(document).on('click', '.updateAppointmentTypeDetails', function(e) {           
            if ($('#appointment_name').val() && $("#appointment_price").val()) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'admin/appointment/updateAppointmentType',
                    beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },
                    data: {
                        id: $('#appointment_type_id').val(), 
                        appointment_name: $('#appointment_name').val(),
                        color: $('#color_code').val(),
                        appointment_price: $("#appointment_price").val(),
                    },
                    success: function(result) {
                        var typedata = JSON.parse(result);
                        $('#createAppointmentType').modal('toggle');
                        var extraMessageHtml = "";
                        if (typedata['success'] == true) {
                            extraMessageHtml = '<div class="alert alert-success">' + typedata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        } else {
                            extraMessageHtml = '<div class="alert alert-danger">' + typedata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        }
                        $('.extraCustomMessage').html(extraMessageHtml);                        
                        window.location.reload();
                        return false;
                    },
                    complete: function() {},
                    error: function(data) {
                        console.log(data);
                    }
                });
            } else {
                $('.error').html('Appointment name and Price is required');
                return false;
            }
        });
    });
</script>
