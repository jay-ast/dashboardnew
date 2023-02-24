<?php include_once 'header.php'; ?>
<script src='<?php echo base_url(); ?>assets/js/moment.min.js'></script>
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>

<div id="content">
    <h1 class="bg-white content-heading border-bottom">Account Details</h1>
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
                <div class="row">
                    <div class="col-md-10">
                        <?php
                        foreach ($data['appointment_type_balance_details'] as $dt) {                                                        
                        ?>
                            <div class="p-3 border bg-light">
                                <h4><?php echo $dt->appointment_name . ': ' . $dt->appointment_balance ?></h4>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-primary addAppintmentBalance mt-1" id="addAppintmentBalance" data-toggle="modal" href="#addBalance" data-clientid="<?php echo $data['client_id'] ?>">Add Balance</a>
                    </div>
                    <table class="dynamicTable tableTools table table-striped checkboxs">
                        <thead>
                            <tr class=" text-center">
                                <th>Date</th>
                                <th>Appointment Type</th>
                                <th>Cost</th>
                                <th>Payment Applied</th>
                                <th>Balance Cr/Dr</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            $amt_details = [];
                            if (!empty($data['accountData'])) {
                                foreach ($data['accountData'] as $dt) {
                                    $balance = $balance - $data->price;
                            ?>
                                    <tr class="gradeX" id="">
                                        <td><?php echo $dt->schedule_date ? formatDate($dt->schedule_date) : formatDate($dt->updated_at) ?></td>
                                        <td><?php echo $dt->appointment_name ?></td>
                                        <td><?php echo $dt->used_balanced ?></td>
                                        <td><?php echo formatDate($dt->updated_at) ?></td>
                                        <?php
                                        if ($dt->transsaction_type == 'debit') {
                                            echo "<td style='color:red'>$dt->used_balanced</td>";
                                        } else {                                            
                                            echo "<td style='color:green'>$dt->used_balanced</td>";
                                        }
                                        ?>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<td>No Record Found</td>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="addBalance" class="modal fade">
    <div class="modal-dialog new-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>

            <div class="modal-body modelform">
                <div class="form-body clearfix col-md-12">
                    <div class="row margin-top-10">
                        <div class="form-group col-md-6">
                            <input type="hidden" class="form-control clientid" id="clientid" name="clientid" value="">
                        </div>
                    </div>
                    <div class="col-md-12 userdetail">
                        <div class="row margin-top-10 userdetails col-md-12">
                            <div class="form-group col-md-4">
                                <label>Select Appointment</label>
                            </div>
                            <div class="form-group col-md-8">
                                <select class="form-control appointment_type" id="appointment_type" name="appointment_type">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($data['appointment_type'] as $types) {
                                    ?>
                                        <option value="<?php echo $types->id ?>"><?php echo $types->appointment_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-10 userdetails col-md-12">
                            <div class="form-group col-md-4">
                                <label>Balance</label>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="number" class="form-control appointment_balance" id="appointment_balance" name="appointment_balance" placeholder="Appointment Balance" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-right add_appointment_balance" id="add_appointment_balance">Add Balance</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
<script>
    $(document).ready(function() {

        var base_url = '<?php echo base_url(); ?>';

        $('.input-daterange input').each(function() {
            $(this).datetimepicker({
                format: 'DD-MM-YYYY'
            });
        });

        $(document).on('click', '#addAppintmentBalance', function() {
            var client_id = $('#addAppintmentBalance').attr('data-clientid');
            $("#addBalance").find(".modal-title").html('Add balance');
            $("#addBalance").find('#clientid').val(client_id);
        });

        $(document).on('click', '#add_appointment_balance', function() {
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/addAppointmentBalance',
                data: {
                    client_id: $('#addBalance').find('#clientid').val(),
                    appointment_type: $('#addBalance').find('#appointment_type').val(),
                    appointment_balance: $('#addBalance').find('#appointment_balance').val(),
                },
                success: function(result) {
                    $('#addBalance').modal('toggle');
                    window.location.reload();
                },
                complete: function() {},
                error: function(data) {
                    console.log(data);
                }
            })
        });

    });
</script>
<style type="text/css">
    .modal-dialog {
        overflow-y: initial !important
    }

    .imagestyle {
        width: 100px;
        height: 100px;
        margin-right: 20px;
    }

    .ml10 {
        margin-left: 10px;
    }

    .modal-body {
        padding: 0px 20px;
    }

    .modal-header .close {
        margin-top: 0px;
        font-size: 28px;
        font-weight: 300;
        text-shadow: unset;
        opacity: .7;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    .btn-primary {
        background: #0395E2;
        border-color: #0395E2;
        color: #fff;
    }

    .btn-primary:hover {
        background: none;
        color: black;
        border-color: black;
    }
</style>