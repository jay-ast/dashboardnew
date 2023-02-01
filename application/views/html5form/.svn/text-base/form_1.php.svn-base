<?php
	if( ! isset($save_button))
	{
		$save_button = 'Save';
	}
	if( ! isset($reset_button))
	{
		$reset_button = FALSE;
	}
	else
	{
		if($reset_button === TRUE)
		{
			$reset_button = 'Reset';
		}
	}
?>
<?php if( ! empty($object->error->all)): ?>
<div class="error">
	<h4 class="alert_error">
		There was an error saving the form.
		<ul><?php foreach($object->error->all as $k => $err): ?>
			<li><?php echo $err; ?></li>
			<?php endforeach; ?>
		</ul>
	</h4>
</div>
<?php endif; ?>

<form action="<?php echo $this->config->site_url($url); ?>" method="post">
<div class="module_content">
<?php echo $rows; ?>
	<p class="buttons" align="center">
		<input type="submit" value="<?php echo $save_button; ?>" class="alt_btn"/><?php
			if($reset_button !== FALSE)
			{
				?> <input type="reset" value="<?php echo $reset_button; ?>" /><?php
			}
		?>
	</p>
</div>
</form>
