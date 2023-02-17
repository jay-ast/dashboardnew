<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Appointments</h1>
    <div class="innerAll spacing-x2">
        <div class="extraCustomMessage">
        </div>
        <div class="widget widget-inverse">
            <div class="col-md-5" style="margin-top: 20px;">
                <div class="col-md-4">
                    <select class="form-control provider_data filter_data" id="provider_data" name="provider_data">
                        <option value="">All Provider</option>
                        <?php
                        foreach ($providerlist as $clientfolder) {
                            echo '<option value="' . $clientfolder['id'] . '" data-name="' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] . '">' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] . '</option>';
                        } ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <select class="form-control client_data filter_data" id="client_data" name="client_data">
                        <option value="">All Clients</option>
                        <?php
                        foreach ($clientlist as $clients) {
                            $selected = '';
                            if ($client_id) {                             
                                $selected = ($client_id == $clients['id']) ? 'selected' : '';
                            }
                            echo '<option value="' . $clients['id'] . '" data-name="' . $clients['firstname']  . ' ' .  $clients['lastname'] . '" ' . $selected . '>' . $clients['firstname']  . ' ' .  $clients['lastname'] . '</option>';
                        } ?>
                    </select>
                </div>                
            </div>
            <div class="pull-right">
                <a class="btn btn-mail client-portal-button" href="<?php echo base_url("admin/home?id=".$client_id); ?>" target="_top" id="">Add Appointment</a>
            </div>
            <div class="widget-body padding-bottom-none appointment_details">
                <div class="row">
                    <table class="dynamicTable tableTools table table-striped checkboxs">
                        <thead>
                            <tr class=" text-center">
                                <th>Client Name</th>
                                <th>Appointment Type</th>
                                <th>Schedule Date</th>
                                <th>Timing</th>                                
                                <th>Brief Note</th>
                                <th>Provider Name</th>
                                <th>Amount</th>
                                <th style="text-align: center;">Checkout</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            if (isset($event_data)) {
                                foreach ($event_data as $event_list) {
                                 $date = date("d-m-Y", strtotime($event_list->schedule_date));   
                                 $start_time = date("h:i a", strtotime($event_list->start_time));
                                 $end_time = date("h:i a", strtotime($event_list->end_time));                                 
                            ?>
                                    <tr class="gradeX">
                                        <td><?php echo $event_list->firstname . ' ' . $event_list->lastname ?></td>
                                        <td><?php echo $event_list->appointment_name ?></td>
                                        <td><?php echo $date ?></td>
                                        <td><?php echo $start_time . '-' . $end_time ?></td>                                                                                
                                        <td><?php echo $event_list->brief_note ?></td>
                                        <td><?php echo $event_list->provider_first_name . ' ' .  $event_list->provider_last_name ?></td>
                                        <td><?php echo $event_list->appointment_price ?></td>                                        
                                        <?php 
                                            if($event_list->payment_status == "paid"){
                                        ?>  
                                            <td style="color: green; text-align: center">paid</td>
                                        <?php    
                                            }else{
                                        ?>                                            
                                            <td style="text-align: center">
                                                <a class="checkoutBtn" data-appointmentid="<?php echo $event_list->id; ?>" data-action="checkout" data-toggle="modal" href="#">
                                                <i class="fa fa-check-square-o" data-toggle="tooltip" title="Checkout Appointment"></i></a>
                                            </td>
                                        <?php        
                                            }
                                        ?>                                        
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr class="gradeX"><td colspan="5" class="text-center">No Appoinment available.</td></tr>';
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
<?php include_once 'footer.php'; ?>
<script>
    $(document).ready(function() {
        var base_url = '<?php echo base_url(); ?>';

        $(".filter_data").change(function(item) {
            var provider_id = $('#provider_data').val();
            var provider_name = $('#provider_data').find(':selected').data('name');
            var client_id = $('#client_data').val();
            var client_name = $('#client_data').find(':selected').data('name');            
            
            $('.appointment_details').html('');            
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/appointment/filterAppointmentData',
                data: {
                        client_id: client_id, 
                        provider_id: provider_id,                        
                    },
                success: function(actionResponse) {                    
                    $('.appointment_details').html(actionResponse);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(".checkoutBtn").click(function(item){
            var event_id = $(this).attr('data-appointmentid');            

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/appointment/checkOutAppointment',
                data: {
                        event_id: event_id,                        
                    },
                success: function(actionResponse) {                    
                    var extraMessageHtml = "";
                    var typedata = JSON.parse(actionResponse);
                    if (typedata['success'] == true) {
                        extraMessageHtml = '<div class="alert alert-success">' + typedata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    } else {
                        extraMessageHtml = '<div class="alert alert-danger">' + typedata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    }
                    $('.extraCustomMessage').html(extraMessageHtml);
                    setTimeout(function () {                    
                        window.location.reload();
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);
                }
            });

        });
    });
</script>