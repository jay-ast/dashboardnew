<html>
    <style>
 @font-face {
  font-family: 'emailfont';
  src: url(<?php echo base_url('assets/emailfont.ttf'); ?>) format('truetype'); /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
}
        </style>
<?php $sitename='Perfect Forms App'; ?>
    <body>
         <p>
        <H1 style="font-family:emailfont;"><?php echo $sitename ?></H1>
    </p>

    <p>
        Hi <?php echo $name ?>,
    </p>

    <p>
        We received a request to reset your <?php echo $sitename ?> password  <br>
        Your new temporary password is: <b><?php echo $password; ?></b>
    </p>

    <p>
        Log in to the app with this temporary password and then go to Account Settings > Change Password to reset your password.
    </p>
    <p>
        Thanks, <br>
        <!--<a href="<?= site_url(); ?>"><?php echo $sitename ?></a> Team-->
        <?php echo $sitename ?> Team
    </p>
</body>
</html>
