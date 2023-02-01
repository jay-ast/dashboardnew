<article class="module width_full">
	<header><h3>My Profile</h3></header>
<?php
	echo $user->render_form(array(
			'username',
			'email'
		),
		'admin/profile/edit',
		array(
			'save_button' => 'Save',
			'reset_button' => 'Clear'
		)
	);
?>
	<footer>
		<div class="submit_link">
			<input type="button" value="Change Password" onclick="location.href='<?=site_url("admin/profile/password")?>'">
		</div>
	</footer>
</article>