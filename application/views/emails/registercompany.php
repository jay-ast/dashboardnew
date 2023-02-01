<html>
    <style>
 @font-face {
  font-family: 'emailfont';
  src: url(<?php echo base_url('assets/emailfont.ttf'); ?>) format('truetype'); /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
}
        </style>

    <body>
         <p>
        <H1 style="font-family:emailfont;"><?php echo SITE_MAIL_TITLE ?></H1>
    </p>

    <p>
        Hi <?php echo $name ?>,
    </p>

    <p>
       Welcome to <?php echo SITE_MAIL_TITLE ?>. Your Company Account is now active. Follow these instructions to login to your dashboard:.
     <br>
     <br>
     
     <p><strong>Dashboard:</strong> <a href="http://dashboard.perfect-forms.net/">http://dashboard.perfect-forms.net/</a>    <br/>
     <br>
     
     <p><strong>Your Username:</strong>  <?php echo $username ?><br/>
           <p><strong>Your Password:</strong>   <?php echo $password ?><br/>
    </p>

    <p>
       For a detailed video tutorial on how to use your Perfect Forms Company dashboard, follow the link below:
    </p>
    <p><a href=""<?php echo APP_WEBAPP_LINK ?>"><?php echo APP_WEBAPP_LINK ?></a></p>
    <br>
     
     <p> Type <strong> admin@videotutorial.com </strong> in the Username field<br/>
          Type <strong> adminvideo </strong>  in the Password field<br/>
    </p>
    <br>
     <br>

   
    
    <p>
        For any question or to contact support, please follow this link:, <br>
        <a href="<?php echo SUPPORT_LINK ?>"><?php echo SUPPORT_LINK ?></a>       
    </p>
    <br>
         <br>
         <b>
        The  <?php echo SITE_MAIL_TITLE ?> Team      
             </p> </b>
</body>
</html>
