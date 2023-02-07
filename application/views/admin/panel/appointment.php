<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Appointments</h1>
    <div class="innerAll spacing-x2">
        <div class="widget widget-inverse">
            <div class="col-md-5" style="margin-top: 20px;">
                <div class="col-md-4">
                    <select class="form-control provider_data" id="provider_data" name="provider_data">
                        <option value="">All Provider</option>
                        <?php
                        foreach ($providerlist as $clientfolder) {
                            echo '<option value="' . $clientfolder['id'] . '" data-name="' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] . '">' . $clientfolder['firstname']  . ' ' .  $clientfolder['lastname'] . '</option>';
                        } ?>
                    </select>
                </div>
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
                                <!-- <th style="text-align: center;">Action</th> -->
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
                                        <td><?php echo $event_list->firstname . ' ' . $event_list->lastname ?? '----' ?></td>
                                        <td><?php echo $event_list->appointment_name ?? '----'  ?></td>
                                        <td><?php echo $date ?? '----'  ?></td>
                                        <td><?php echo $start_time . '-' . $end_time ?? '----'  ?></td>                                                                                
                                        <td><?php echo $event_list->brief_note ?? '----'  ?></td>
                                        <td><?php echo $event_list->provider_first_name . ' ' .  $event_list->provider_last_name ?? '----'  ?></td>
                                        <!-- <td></td> -->
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
                        <!-- <ul id="myLinks" class="bootpag pagination">                            
                            <?php
                            foreach ($links as $link) {
                                echo "<li>" . $link . "</li>";
                            }
                            ?>
                        </ul> -->
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
        $(".provider_data").change(function(item) {
            var provider_id = $('#provider_data').val();
            var provider_name = $('#provider_data').find(':selected').data('name');
            console.log('provider_id', provider_id);
            console.log('provider_name', provider_name);
            $('.appointment_details').html('');
            // if (provider_name) {
            //     $('.provider_name').text(provider_name);
            // } else {
            //     $('.provider_name').text("All Staff");
            // }

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/appointment/filterByProvider/' + provider_id,
                success: function(actionResponse) {                    
                    $('.appointment_details').html(actionResponse);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>