<html>
    <style>
 @font-face {
  font-family: 'emailfont';
  src: url(<?php echo base_url('assets/emailfont.ttf'); ?>) format('truetype'); /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
}
        </style>

    <body>

    <p>
        Dear  <?php echo $firstname.' '.$lastname  ?>,
    </p>
    <br>

    <p>
        Your home program has been updated. Please log into Perfect Forms to see your new updated routine.
    </p>

    <br>

    <p>
        To view your videos:
        <br>
    
	1- Download our Perfect Forms app from App Store(IOS): <a href="<?php echo APP_ITUNES_LINK ?>"><?php echo APP_ITUNES_LINK ?></a></p>
    <br><br>
    2- Download our Perfect Forms app from Play Store(Android): <a href="<?php echo APP_PLAYSTORE_LINK ?>"><?php echo APP_PLAYSTORE_LINK ?></a></p>
    <br>OR<br>

    3- Log into <a href="<?php echo APP_WEBAPP_LINK ?>"><?php echo APP_WEBAPP_LINK ?></a> from any device or computer.

    </p>
    <br><br>
    <p>Your Details</p>
    <p><strong>Username:</strong>  <?php echo $email ?><br/>
    <p><strong>Password:</strong>   <?php echo $password ?><br/>
    </p>
    
    <p>
        For any question or to contact support, please follow this link:, <br>
        <a href="<?php echo SUPPORT_LINK ?>"><?php echo SUPPORT_LINK ?></a>       
    </p>
    <br>
         <b>
        The  <?php echo SITE_MAIL_TITLE ?> Team      
             </p> </b>
</body>
</html>
