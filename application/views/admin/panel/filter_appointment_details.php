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
            if (!empty($event_data)) {
                foreach ($event_data as $event_list) {                    
                    $date = date("d-m-Y", strtotime($event_list->schedule_date));   
                    $start_time = date("h:i a", strtotime($event_list->start_time));
                    $end_time = date("h:i a", strtotime($event_list->end_time));
            ?>
                    <tr class="gradeX">
                        <td><?php echo $event_list->firstname . ' ' . $event_list->lastname ?></td>
                        <td><?php echo $event_list->appointment_name ?></td>
                        <td><?php echo $event_list->schedule_date  ?></td>
                        <td><?php echo $start_time . '-' . $end_time ?></td>
                        <td><?php echo $event_list->brief_note ?></td>
                        <td><?php echo $event_list->provider_first_name . ' ' .  $event_list->provider_last_name ?></td>
                        <td><?php echo $event_list->appointment_price ?></td>
                        <?php 
                            if($event_list->payment_status == "pending"){
                        ?>  
                            <td style="text-align: center">
                                <a class="checkoutBtn" data-appointmentid="<?php echo $event_list->id; ?>" data-action="checkout" data-toggle="modal" href="#">
                                <i class="fa fa-check-square-o" data-toggle="tooltip" title="Checkout Appointment"></i></a>
                            </td>        
                        <?php    
                            }else{
                        ?>
                            <td style="color: green; text-align: center">paid</td>
                        <?php        
                            }
                        ?>                        
                    </tr>
            <?php
                }
            } else {
                echo '<tr class="gradeX"><td colspan="8" class="text-center">No Events available.</td></tr>';
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