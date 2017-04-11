<div class="col-xs-12">
	<fieldset>
		<legend><?php echo $label; ?></legend>
			<form action="<?php echo $url?>" method="post">
				<div class="form-group">
				    <label for="publisher">Edition Code</label>
				    <input type="text" name="kode_edisi" class="form-control" placeholder="Edition code" value="<?php echo isset($edisi['kode_edisi']) ? $edisi['kode_edisi'] : ""; ?>">
				     <p class="help-block"><em>e.g. 111/MARET/15; 01/SEP/2016; 52-JAN-16;</em></p>
				  </div>
				<div class="form-group">
				    <label for="city">Magazine Name</label>
				    <select class="form-control" name="majalah_id" id="majalah">
                       <?php 
			    			foreach ($majalah as $majalah) 
			    			{ ?>
			    				<option value="<?php echo $majalah['majalah_id']?>"><?php echo $majalah['nama_majalah']?></option>
			    			<?php }
			    		?>
                    </select>
				</div>
				<div class="form-group">
				    <label for="phone">Price</label>
				    <input type="text" name="harga" class="form-control" placeholder="0" value="<?php echo isset($edisi['harga']) ? $edisi['harga'] : ""; ?>">
				</div>
				<div class="form-group">
				    <label>Retur Date</label>
				    <input type="text" name="retur_date" class="form-control <?php echo ($accounting == TRUE) || $label == "Tambah Edisi" ? "date" : "" ?>" value="<?php echo isset($edisi['retur_date']) ? date('Y-m-d', strtotime($edisi['retur_date'])) : "" ?>" <?php echo ($accounting == TRUE) || $label == "Tambah Edisi" ? "required" : "readonly" ?> >
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
	</fieldset>
</div>
<script type="text/javascript">
	<?php echo (isset($edisi['majalah_id']))?"$('#majalah').val(".$edisi['majalah_id'].");":''?>
</script>