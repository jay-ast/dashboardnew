<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <style type="text/css" media="all">
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
    <div class="container top_t_BG">
        <div class="row">
            <div class="top_text col-md-6">
                <h1 style="margin-left: 2px;">Invoice Details</h1>
            </div>
            <div class="top_text" style="margin-left: 350px;">
                <h3>Synergy+</h3><br />
                <p>
                    California 704 Mission Avenue, San Rafael CA 94901.<br/>
                    Switzerland Golf Gerry Losone, via aloe Gerry 5, 6616 Losone.<br/>
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-bordered" style="padding: 20px;">
            <thead style="padding: 20px;">
                <tr>
                    <th>Date of Service</th>
                    <th>Type of Service</th>
                    <th>Cost</th>
                    <th>Payments Received</th>
                </tr>
            </thead>
            <tbody style="padding: 20px;">
                <?php
                $amt_details = [];
                foreach ($data as $dt) {
                    $balance;
                    if($dt->transsaction_type == 'credit'){
                        $balance = $balance + $dt->used_balanced;
                    }else{
                        $balance = $balance - $dt->used_balanced;
                    }
                ?>
                    <tr>
                        <td><?php echo formatDate($dt->created_at) ?></td>
                        <td><?php echo $dt->appointment_name ?></td>
                        <td><?php echo $dt->used_balanced ?></td>
                        <td>---</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div>
            <?php 
                if($balance < 0){
                    $balance = abs($balance);
                   echo "<h3 style='color:red;'>Due Balance :- $balance </h3>";
                }else{
                    echo "<h3 style='color:green'>Available Balance :- $balance  </h3>";
                }
            ?>            
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"> </script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

</body>

</html>