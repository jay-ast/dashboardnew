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
    <p>
        To view your videos:
        <br>
        1- Download our Perfect Forms app from App Store(IOS): <a href="<?php echo APP_ITUNES_LINK ?>"><?php echo APP_ITUNES_LINK ?></a>
    </p>
    <br><br>
    2- Download our Perfect Forms app from Play Store(Android): <a href="<?php echo APP_PLAYSTORE_LINK ?>"><?php echo APP_PLAYSTORE_LINK ?></a></p>
    <br>OR<br>

    3- Log into <a href="<?php echo APP_WEBAPP_LINK ?>"><?php echo APP_WEBAPP_LINK ?></a> from any device or computer
    <br><br>
    </p>
    <br><br>
    <p>
        For any question or to contact support, please follow this link:, <br>
        <a href="<?php echo SUPPORT_LINK ?>"><?php echo SUPPORT_LINK ?></a>
    </p>
    <br>
    <br>
    <b>
        <p>
            Enjoy your videos!, <br>
            The <?php echo SITE_MAIL_TITLE ?> Team
        </p>
    </b>
</body>

</html>