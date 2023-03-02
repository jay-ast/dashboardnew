<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>

<div id="content">
    <h1 class="bg-white content-heading border-bottom">Invoice Details</h1>
    <div class="innerAll spacing-x2">
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none">
                <div class="row table-responsive">                    
                    <table class="dynamicTable tableTools table table-striped">
                        <thead class="my-2">
                            <tr class=" text-center">                                
                                <th>Date of Service</th>
                                <th>Type of Service</th>
                                <th>Cost</th>
                                <th>Payments Received</th>                                
                            </tr>
                        </thead>
                        <tbody id="myTable" class="my-2">
                            <?php
                            $amt_details = [];                            
                                foreach ($data as $dt) {
                                    $balance = $balance - $data->price;
                            ?>
                                    <tr class="gradeX">                                 
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
                </div>
            </div>
        </div>
    </div>
</div>