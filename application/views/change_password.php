<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>Change Password</legend>
	<form action="login/change" method="post">
		<div class="form-group">
		    <label for="city">Username</label>
		    <input type="text" name="username" class="form-control" value="<?php echo $this->session->userdata('username') ?>">
		</div>
		<div class="form-group">
		    <label for="city">Old Password</label>
		    <input type="password" name="oldpass" class="form-control" value="">
		</div>
		<div class="form-group">
		    <label for="city">New Password</label>
		    <input type="password" name="newpass" class="form-control" value="">
		</div>
		<div class="form-group">
		    <button style="submit" class="btn btn default">Simpan</button>
		</div>
	</form>
</fieldset>