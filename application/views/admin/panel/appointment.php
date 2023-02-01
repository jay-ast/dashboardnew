<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Appointments</h1>
    <div class="innerAll spacing-x2">                
        <div class="alert alert-info displaymessage hidden">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p></p>
        </div>
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none">
                <div class="row">
                    <table class="dynamicTable tableTools table table-striped checkboxs">                        
                        <thead>
                            <tr class=" text-center">
                                <th>Client Name</th>
                                <th>Schedule Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Appointment Type</th>
                                <th>Brief Note</th>
                                <th>Provider Name</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>                        
                        <tbody id="myTable">
                        <?php
                            if (isset($event_data)) {
                                foreach ($event_data as $event_list) {                                    
                            ?>
                                <tr class="gradeX">
                                    <td><?php echo $event_list->firstname . ' ' . $event_list->lastname ?></td>
                                    <td><?php echo $event_list->schedule_date  ?></td>
                                    <td><?php echo $event_list->start_time ?></td>
                                    <td><?php echo $event_list->end_time ?></td>
                                    <td><?php echo $event_list->appointment_type ?></td>
                                    <td><?php echo $event_list->brief_note ?></td>
                                    <td><?php echo $event_list->provider_first_name . ' ' .  $event_list->provider_last_name?></td>
                                    <td></td>
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