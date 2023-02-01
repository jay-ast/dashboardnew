<article class="module width_full">
	<header><h3>Change Password</h3></header>

<?php
	echo $user->render_form(array(
			'password',
			'confirm_password'
		),
		'admin/profile/password/save',
		array(
			'save_button' => 'Save',
			'reset_button' => 'Clear'
		)
	);
?>
</article>