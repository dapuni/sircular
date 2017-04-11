<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>Edit Realisasi</legend>
	<form action="sirkulasi/realisasi_distribusi/update/<?php echo $distribution_plan_id."/".$id;?>" method="post">
		<div class="form-group">
		    <label for="city">Agent</label>
		    <input type="text" class="form-control" value="<?php echo $realisasi['nama_agent'] ?>" disabled >
		</div>
		<div class="form-group">
		    <label>Ekspedisi</label>
		    <select name="ekspedisi" class="form-control" id="ekspedisi">
		    	<option value="">---</option>
		    	<option value="Kirim Sendiri"<?php echo (isset($realisasi))? ($realisasi['ekspedisi'] == 'Kirim Sendiri') ? 'selected':'' :''?>>Kirim Sendiri</option>
		    	<option value="PT. EFNATALI CITRA VARIA" <?php echo (isset($realisasi))? ($realisasi['ekspedisi'] == 'PT. EFNATALI CITRA VARIA') ? 'selected':'' :''?>>PT. EFNATALI CITRA VARIA</option>
		    </select>
		</div>
		<div class="form-group">
		    <label>Quota</label>
		    <input type="text" name="quota" class="form-control" value="<?php echo $realisasi['quota'] ?>">
		</div>
		<div class="form-group">
		    <label>Consigned</label>
		    <input type="text" name="consigned" class="form-control" value="<?php echo $realisasi['consigned'] ?>">
		</div>
		<div class="form-group">
		    <label>Gratis</label>
		    <input type="text" name="gratis" class="form-control" value="<?php echo $realisasi['gratis'] ?>">
		</div>
		<div class="form-group">
		    <label>Diskon %</label>
		    <input type="text" name="disc_total" class="form-control" value="<?php echo $realisasi['disc_total'] ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?> >
		</div>
		<div class="form-group">
		    <label>Deposit</label>
		    <input type="text" name="disc_deposit" class="form-control" value="<?php echo $realisasi['disc_deposit'] ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?>>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</fieldset> <br>