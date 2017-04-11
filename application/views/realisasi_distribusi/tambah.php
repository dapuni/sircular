<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>Tambah Realisasi</legend>
	<form action="sirkulasi/realisasi_distribusi/simpan/<?php echo $id;?>" method="post">
		<div class="form-group">
		    <label for="city">Agent</label>
		    <select class="form-control" name="agent_id">
		    	<option value="">---</option>
		    	<?php foreach ($agent as $agent) 
		    	{ ?>
		    		<option value="<?php echo $agent['agent_id']?>"><?php echo $agent['nama_agent']?></option>
		    	<?php } ?>
		    </select>
		</div>
		<div class="form-group">
		    <label>Ekspedisi</label>
		    <select name="ekspedisi" class="form-control" id="ekspedisi">
		    	<option value="">---</option>
		    	<option value="Kirim Sendiri">Kirim Sendiri</option>
		    	<option value="PT. EFNATALI CITRA VARIA">PT. EFNATALI CITRA VARIA</option>
		    </select>
		</div>
		<div class="form-group">
		    <label>Quota</label>
		    <input type="text" name="quota" class="form-control" value="">
		</div>
		<div class="form-group">
		    <label>Consigned</label>
		    <input type="text" name="consigned" class="form-control" value="">
		</div>
		<div class="form-group">
		    <label>Gratis</label>
		    <input type="text" name="gratis" class="form-control" value="">
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</fieldset> <br>