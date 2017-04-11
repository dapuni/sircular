<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>USER LIST</legend>
	<table class="table">
		<thead>
			<th width="3%">#</th>
			<th>Username</th>
			<th>Status</th>
			<th style="text-align:center">Action</th>
		</thead>
		<tbody>
			<?php 
			$no = 1;
			foreach ($user as $keyuser) 
			{ ?>
				<tr>
					<td><?php echo $no++;?></td>
					<td><?php echo $keyuser['username'] ?></td>
					<td><?php echo ($keyuser['is_del'] == 0) ? 'Active' : 'Not Active' ?></td>
					<td style="text-align:center">
					<?php if ($keyuser['is_del'] == 0) 
					{ ?>
						<a href="login/user_detail/<?php echo $keyuser['user_id'] ?>" class="btn btn-success btn-sm" >Detail</a> <a href="login/deactive/<?php echo $keyuser['user_id'] ?>" onclick="return confirm('Anda Yakin Deactive User Ini?')" class="btn btn-danger btn-sm">Deactive</a>
					<?php } else { ?>
						<a href="login/user_detail/<?php echo $keyuser['user_id'] ?>" class="btn btn-success btn-sm" >Detail</a> <a href="login/active/<?php echo $keyuser['user_id'] ?>" onclick="return confirm('Anda Yakin Active User Ini?')" class="btn btn-primary btn-sm">Active</a>
					<?php }?>
						
					</td>
				</tr>
			<?php }
			?>
		</tbody>
	</table>
</fieldset>