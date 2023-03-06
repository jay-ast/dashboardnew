<html>
<style>
    @font-face {
        font-family: 'emailfont';
        src: url(<?php echo base_url('assets/emailfont.ttf'); ?>) format('truetype');
        /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
    }
</style>
<body>
    <p>
        <h1 style="font-family:emailfont;">Synergy+</h1>
    </p>
    <br/>
    
    <!-- <p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 style="font-family:emailfont;">Business name</h3>
    </p><br/>
    
    <p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 style="font-family:emailfont;">Business address</h3>
    </p><br/><br/> -->
    
    <p>
        <h3 style="font-family:emailfont;">Client Name <?php echo $result[0]->firstname . ' ' . $result[0]->lastname ?></h3>
    </p><br/>
    
    <!-- <p>
        <h3 style="font-family:emailfont;">Client Address</h3>
    </p><br/> -->
        
    <br/>
        
   <table class="dynamicTable tableTools table table-striped checkboxs">
   <thead>
        <tr class="text-center">
            <th>Date</th>
            <th>Services</th>
            <th>Amount</th>
            <th style="text-align: center;">Method of Payment</th>
        </tr>
    </thead>
    <tbody id="myTable">
        <?php 
            foreach($result as $data){
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