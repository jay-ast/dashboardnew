<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

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
    <div class="top_t_BG">
        <div class="row" style="text-align: center; display: flex; gap: 5px;">
            <div style="margin-top: 2px;">
                <h3>Invoice Details</h3>
            </div>
            <div class="mt-5">
                <h3>Synergy+</h3><br />
                <p style="margin-bottom: 4px;">
                    California 704 Mission Avenue, San Rafael CA 94901.<br />
                    Switzerland Golf Gerry Losone, via aloe Gerry 5, 6616 Losone.<br />
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
                    <!-- <th>Cost</th> -->
                    <th>Payments Received</th>
                    <th>Credit</th>
                    <th>Debit</th>
                </tr>
            </thead>
            <tbody style="padding: 20px;">
                <?php
                $symbol = $this->config->item('currency_symbol');                
                $amt_details = [];
                foreach ($data as $dt) {
                    $balance;
                    if ($dt->transsaction_type == 'credit') {
                        $balance = $balance + $dt->used_balanced;
                    } else {
                        $balance = $balance - $dt->used_balanced;
                    }
                ?>
                    <tr style="text-align: left;">
                        <td><?php echo formatDate($dt->created_at) ?></td>
                        <td style="text-align: left;"><?php echo $dt->appointment_name ?></td>
                        <!-- <td><?php // echo number_format($dt->used_balanced, 2, '.', ',') 
                                    ?></td> -->
                        <td><?php echo formatDate($dt->updated_at) ?></td>
                        <?php
                        if ($dt->transsaction_type == 'debit') {
                            echo "<td></td>";
                            echo "<td style='color:red; text-align:right'>" . $symbol . number_format($dt->used_balanced, 2, '.', ',') . "</td>";
                        } else {
                            echo "<td style='color:green; text-align:right'>" . $symbol . number_format($dt->used_balanced, 2, '.', ',') . "</td>";
                            echo "<td></td>";
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div>
            <?php
            if ($balance < 0) {
                $balance = abs($balance);
                echo "<h3 style='color:red; margin-left:30px'>Due Balance: " . $symbol . number_format($balance, 2, '.', ',') . "</h3>";
            } else {
                echo "<h3 style='color:green; margin-left:30px'>Available Balance: " . $symbol . number_format($balance, 2, '.', ',') . "</h3>";
            }
            ?>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"> </script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

</body>

</html>