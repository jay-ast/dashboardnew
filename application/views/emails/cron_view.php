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
    <h1 style="font-family:emailfont;">A message from Synergy+</h1>
    </p>
    <?php if(!empty($msg_data)){ ?>
    <p>
        <?php echo $msg_data; ?>
    </p>
    <?php } ?>
    <br/>    
</body>

</html>