<?php include_once 'header.php'; ?>
<script src='<?php echo base_url(); ?>assets/js/moment.min.js'></script>
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

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
                <?php
                if (!empty($data['appointment_type_balance_details'])) {
                ?>
                <div class="row">
                    <div class="col-12">
                        <p>Existing Balance with the client by Appointment Type: </p>    
                    </div>
                </div>
                    <div class="row">
                        <?php
                        foreach ($data['appointment_type_balance_details'] as $dt) {
                        ?>
                            <div class="col-md-2">
                                <div class="card mb-1">
                                    <div class="card-body border bg-info py-2">
                                        <div class="text-center">
                                            <h4><?php echo $dt->appointment_name; ?></h4>
                                            <h2><?php echo $dt->appointment_balance; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                <hr>
                <div class="row">
                    <form method="get" action="<?= site_url("admin/patients/getAccountDetails") ?>" class="col-md-6">
                        <div class="col-md-12 mb-2">
                            <div class="row" style="display: flex; align-items: center; gap:5px;">
                                <label>Select Date Range</label>
                                <input style="width: 30%; " type="date" name="start_date" class="form-control start_date_filter" id="start_date_filter" />
                                <input style="width: 30%; " type="date" name="end_date" class="form-control end_date_filter" id="end_date_filter" />
                                <input type="submit" name="date_range_filter" class="btn btn-primary date_range_filter" value="Submit" id="date_range_filter" />
                            </div>
                        </div>
                        <input type="hidden" name="client_id" class="client_id" value="<?php echo $data['client_id'] ?>" />
                    </form>
                    <div class="col-md-2">
                        <a class="btn btn-primary addAppintmentBalance" id="addAppintmentBalance" data-toggle="modal" href="#addBalance" data-clientid="<?php echo $data['client_id'] ?>">Add Balance</a>
                    </div>
                    <table class="dynamicTable tableTools table table-striped checkboxs">
                        <thead>
                            <tr class=" text-center">
                                <th><input type="checkbox" name="invoice_checkbox_all" class="invoice_checkbox_all" id="invoice_checkbox_all" value="all" /> </th>
                                <th>Date</th>
                                <th>Appointment Type</th>
                                <!-- <th>Cost</th> -->
                                <th>Payment Applied</th>
                                <th>Balance Credit</th>
                                <th>Balance Debit</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            $symbol = $this->config->item('currency_symbol');
                            $amt_details = [];
                            if (!empty($data['accountData'])) {
                                foreach ($data['accountData'] as $dt) {
                                    $balance = $balance - $data->price;
                            ?>
                                    <tr class="gradeX" id="">
                                        <td><input type="checkbox" name="invoice_checkbox" class="invoice_checkbox" id="invoice_checkbox" value="<?php echo $dt->client_wallet_transaction_id ?>" /> </td>
                                        <td><?php echo formatDate($dt->created_at) ?></td>
                                        <td><?php echo $dt->appointment_name ?></td>
                                        <!-- <td><?php // echo number_format($dt->used_balanced, 2, '.', ',') ?></td> -->
                                        <td><?php echo formatDate($dt->updated_at) ?></td>
                                        <?php
                                        if ($dt->transsaction_type == 'debit') {
                                            echo "<td> ---- </td>";
                                            echo "<td style='color:red'>" . $symbol .number_format($dt->used_balanced, 2, '.', ',')."</td>";
                                        } else {
                                            echo "<td style='color:green'>". $symbol . number_format($dt->used_balanced, 2, '.', ',')."</td>";
                                            echo "<td> ---- </td>";
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
                    <div class="col-md-2 pull-right">
                        <a class="btn btn-primary generateInvoice my-1" id="generateInvoice">Generate Invoice</a>
                    </div>
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
                <div class="error"></div>
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

        // $('input[name="daterange"]').daterangepicker();

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
            if ($('#addBalance').find('#appointment_type').val() && $('#addBalance').find('#appointment_balance').val()) {
                if ($('#addBalance').find('#appointment_balance').val() >= 0) {
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
                } else {
                    $('#addBalance').find('.error').html('Balance cannot be nagative.');
                    return false;
                }

            } else {
                $('#addBalance').find('.error').html('Appointment type and balance field are require.');
                return false;
            }
        });

        $(document).on('click', '#date_range_filter', function() {
            var client_id = $('#addAppintmentBalance').data('clientid');
            if ($('#start_date_filter').val() && $('#end_date_filter').val()) {
                if ($('#end_date_filter').val() > $('#start_date_filter').val()) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'admin/patients/getAccountDetails/' + client_id,
                        data: {
                            start_date: $('#start_date_filter').val(),
                            end_date: $('#end_date_filter').val(),
                        },
                        success: function(result) {},
                        complete: function() {},
                        error: function(data) {
                            console.log(data);
                        }
                    })
                } else {
                    alert('End date must be grater than Start date');
                }
            } else {
                alert('Please Select Date');
            }
        });

        $(document).on('click', '#invoice_checkbox_all', function() {
            if ($(this).is(':checked')) {
                $('#myTable').find('.invoice_checkbox').prop('checked', true);
            } else {
                $('#myTable').find('.invoice_checkbox').prop('checked', false);
            }

        });

        $(document).on('click', '#generateInvoice', function() {

            var invoice_id = [];
            $.each($("input[name='invoice_checkbox']:checked"), function() {
                invoice_id.push($(this).val())
            });

            if (invoice_id) {
                window.location.href = base_url + 'admin/patients/generateInvoice?invoice_id=' + invoice_id.join();
                // $.ajax({
                //     type: 'POST',
                //     url: base_url + 'admin/patients/generateInvoice',
                //     data: {
                //         invoice_id: invoice_id
                //     },
                //     success: function(response) {
                //         var blob = new Blob([response]);
                //         console.log(blob);
                // var link = document.createElement('a');
                // link.href = window.URL.createObjectURL(blob);
                // link.download = "test.pdf";
                // link.click();


                //     },
                //     complete: function() {},
                //     error: function(data) {
                //         console.log(data);
                //     }
                // })
            }
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