<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>ADD USER</legend>
	<form action="<?php echo $button ?>" method="post">
		<div class="form-group">
		    <label for="city">Username</label>
		    <input type="text" name="username" class="form-control" value="<?php echo isset($user) ? $user['username'] :'' ?>" required>
		</div>
		<div class="form-group">
		    <label for="city">Password</label>
		    <input type="password" name="password" class="form-control" value="" required>
		</div>
		<div class="form-group">
		    <label for="city">Access</label></br>
		    <?php 
		    	foreach ($module as $module) 
		    	{ 
		    		if ($module['parent'] != 0) 
		    		{
		    			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		    		}
		    		?>

		    		<input type="checkbox" name="module[]" value="<?php echo $module['module_id'] ?>" 
		    		<?php 
		    			$modulex = isset($user) ? explode(',', $user['module']) : '';
		    			if ($modulex != '') {
		    				foreach ($modulex as $key) 
			    			{
			    				if ($key == $module['module_id']) 
			    				{
			    					echo "checked";
			    				}
			    			}
		    			}
		    		?>>
		    		<?php echo $module['module_name'] ?>
		    		</br>
		    	<?php }
		    ?>
		</div>
		<div class="form-group">
		    <label for="city">Role</label></br>
			<input type="radio" name="group" value="0" <?php echo (isset($user) && $user['is_group'] == 0) ? 'checked' : '' ?> >User
			<br>
			<input type="radio" name="group" value="1" <?php echo (isset($user) && $user['is_group'] == 1) ? 'checked' : '' ?>>Finance And Accounting
			<br>
			<input type="radio" name="group" value="2" <?php echo (isset($user) && $user['is_group'] == 2) ? 'checked' : '' ?>>Administrator
		</div>
		<div class="form-group">
		    <button style="submit" class="btn btn default">Simpan</button>
		</div>
	</form>
</fieldset>