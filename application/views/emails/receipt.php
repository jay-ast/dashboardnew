<html>

<head>
    <style>
        @font-face {
            font-family: 'emailfont';
            src: url(<?php echo base_url('assets/emailfont.ttf'); ?>) format('truetype');
            /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
        }

        * {
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        .container {
            width: 1140px;
            display: flex;
            flex-wrap: wrap;
            margin: 0 auto;
        }

        .top_t_BG {
            background: #0395E2;
            color: #fff;
        }

        th {
            padding: 10px;
            text-align: center;
        }

        td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <p>
    <h1 style="font-family:emailfont;">Synergy+</h1>
    </p>
    <br />

    <!-- <p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 style="font-family:emailfont;">Business name</h3>
    </p><br/>
    
    <p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 style="font-family:emailfont;">Business address</h3>
    </p><br/><br/> -->

    <p>
    <h4 style="font-family:emailfont;">Client Name <?php echo $result[0]->firstname . ' ' . $result[0]->lastname ?></h4>
    </p>

    <!-- <p>
        <h3 style="font-family:emailfont;">Client Address</h3>
    </p><br/> -->    

    <table class="table table-bordered" style="padding: 20px;">
        <thead style="padding: 20px;">
            <tr class="text-center">
                <th>Date</th>
                <th>Services</th>
                <th>Amount</th>
                <th style="text-align: center;">Method of Payment</th>
            </tr>
        </thead>
        <tbody id="myTable" style="padding: 20px;">
            <?php
            foreach ($result as $data) {
            ?>
                <tr class="gradeX text-center">
                    <td><?php echo formatDate($data->created_at) ?></td>
                    <td><?php echo $data->appointment_name ?></td>
                    <td><?php echo $data->price ?></td>
                    <td><?php echo $data->amount_type ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <p>
    <h3>Thank you for your payment!</h3>
    </p>
</body>

</html>