<div class="col-xs-12">
	<fieldset>
		<legend>Tambah Agent</legend>
			<form action="<?php echo $url; ?>" method="post" >
				<div class="form-group">
				    <label for="publisher">Agent Name</label>
				    <input type="text" name="nama_agent" class="form-control" id="publisher" placeholder="Agent Name" value="<?php echo isset($agent['nama_agent']) ? $agent['nama_agent'] :'' ?>">
				</div>
				<div class="form-group">
				    <label for="publisher">NPWP</label>
				    <input type="text" name="npwp" class="form-control" id="publisher" placeholder="NPWP" value="<?php echo isset($agent['npwp']) ? $agent['npwp'] :'' ?>">
				</div>
				<div class="form-group">
				    <label for="province">City</label>
				   <select class="form-control" name="kota" id="kota">
                        <?php 
                        	foreach ($kota as $kota) 
                        	{ ?>
                        		<option value="<?php echo $kota['id'] ?>"><?php echo $kota['name']; ?></option>
                        	<?php }
                        ?>
                    </select>
				</div>
				<div class="form-group">
				    <label for="phone">Alamat</label>
				    <input type="text" name="address" class="form-control" id="phone" placeholder="Alamat" value="<?php echo isset($agent['address']) ? $agent['address'] :'' ?>">
				</div>
				<div class="form-group">
				    <label >Agent Category</label>
				    <select class="form-control" name="agent_category" id="agent_category">
                        <?php 
                        	foreach ($agent_cat as $agent_cat) 
                        	{ ?>
                        		<option value="<?php echo $agent_cat['agent_category_id'] ?>"><?php echo $agent_cat['nama_agent_cat']; ?></option>
                        	<?php }
                        ?>
                    </select>
				</div>
				<div class="form-group">
				    <label for="phone">Phone Number</label>
				    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value="<?php echo isset($agent['phone']) ? $agent['phone'] :'' ?>">
				</div>
				<div class="form-group">
				    <label for="phone">Available Contact</label>
				    <input type="text" name="contact" class="form-control" id="phone" placeholder="Available Contact" value="<?php echo isset($agent['contact']) ? $agent['contact'] :'' ?>" >
				</div>
				<div class="form-group">
				    <label for="phone">Discount</label>
				    <input type="text" name="discount" class="form-control" id="phone" placeholder="Discount" value="<?php echo isset($agent['discount']) ? $agent['discount'] :'' ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?> >
				</div>
				<div class="form-group">
				    <label for="phone">Deposit</label>
				    <input type="text" name="deposit" class="form-control" id="phone" placeholder="Deposit" value="<?php echo isset($agent['deposit']) ? $agent['deposit'] :'' ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?> >
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
	</fieldset>
</div>
<script type="text/javascript">
	<?php echo (isset($agent['agent_category']))?"$('#agent_category').val(".$agent['agent_category'].");":''?>
	<?php echo (isset($agent['kota']))?"$('#kota').val(".$agent['kota'].");":''?>
</script>