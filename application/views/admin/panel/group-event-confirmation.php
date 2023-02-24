<div class="modal-dialog ">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
            <h3 class="modal-title">Appointment Status</h3>
        </div>
        <div class="modal-body modelform">
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-1">Appointment Info</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="well">
                        <p class="appointment_provider_name mb-1">Provider Name :- <?php echo $data[0]->provider_first_name . ' ' . $data[0]->provider_last_name ?></p>
                        <p class="appointment_date_time">Appointment Date :- <?php echo formatDate($data[0]->schedule_date) ?></p>
                        <p class="appointment_type">Appointment Type : <?php echo $data[0]->appointment_name ?></p>
                        <p class="appointment_rate">Appointment Rate : <?php echo $data[0]->price ?></p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-1">Client Listing</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="well">                        
                    <?php 
                        foreach($data as $dt){ 
                        // $checked = ($dt->payment_status == 'paid') ? 'checked' : '';
                        $disabled = ($dt->payment_status == 'paid') ? 'disabled' : '';
                        if($dt->payment_status == 'pending'){
                            $temp = 1;
                        }                               
                    ?>
                        <input type="checkbox" name="client_checkout" id="client_checkout" data-clientid="<?php echo $dt->client_id ?>" data-appointmentypeid="<?php echo $dt->appointment_type ?>" value="<?php echo $dt->id_event ?>" <?php echo $disabled ?>/>
                        <span class="appointment_client_name"><?php echo $dt->firstname . ' ' . $dt->lastname ?></span><br>

                        <div class="appoinment_transaction_details_<?php echo $dt->client_id; ?> hide">
                            <span class="appointment_fees" data-appointmentfees="<?php echo $dt->client_id; ?>">Received Amount: <?php echo $dt->price ?></span><br>
                            <span class="wallet_balance" data-walletbalance="<?php echo $dt->client_id; ?>">Wallet Balance: <?php echo $dt->appointment_balance ? $dt->appointment_balance: '0' ?></span><br>
                            <?php 
                                if($dt->appointment_balance > 0){
                            ?>
                                <input type="checkbox" name="use_wallet" class="wallet_balance_used" data-appointmentprice="<?php echo $dt->price; ?>" data-clientid="<?php echo $dt->client_id ?>" value="<?php echo $dt->appointment_balance ? $dt->appointment_balance: '0' ?>"/>
                                <span class="appointment_wallet">Use Wallet</span><br>
                            <?php        
                                }
                            ?>                            
                            <br/>
                        </div>                        

                    <?php        
                        }
                    ?>        
                    </div>                                       
                </div>
                <?php 
                    if($temp == 1){
                ?>                
                    <div class="row my-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-warning btnCheckout edit-appointment-confirmation" style="margin: 4px;" id="btnCheckout" name="btnCheckout">Mark as Paid</button>
                        </div>
                    </div>
                <?php        
                    }else{
                        echo "<label class='btnCheckPaid edit-appointment-confirmation' style='margin: 4px;cursor: not-allowed;color: green;font-size: 19px;' id='btnCheckPaid' name='btnCheckPaid'>Checkout</label>";
                    }
                ?>
            </div>                        
        </div>
    </div>
</div>