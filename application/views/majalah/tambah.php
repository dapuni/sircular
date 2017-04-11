<div class="col-xs-12">
	<fieldset>
		<legend><?php echo $legend ?></legend>
		<form action=<?php echo $url ?> method="post">
			<div class="form-group">
			    <label for="publisher">Magazine Name</label>
			    <input type="text" name="nama_majalah" class="form-control" placeholder="Magazine Name" value="<?php echo isset($data['nama_majalah']) ? $data['nama_majalah'] : ""?>">
			  </div>
			<div class="form-group">
			    <label for="city">Publisher</label>
			    <select class="form-control" name="penerbit_id" id="penerbit_id">
			    <?php 
			    	foreach ($penerbit as $penerbit) 
			    	{ ?>
			    		 <option selected value="<?php echo $penerbit['penerbit_id'] ?>"><?php echo $penerbit['nama'] ?></option>
			    	<?php }
			    ?>
                </select>
			</div>
			<div class="form-group">
			    <label for="province">Period</label>
			    <input type="text" name="periode" class="form-control" placeholder="Period"  value="<?php echo isset($data['periode']) ? $data['periode'] : "";?>">
			</div>
			<div class="form-group">
			    <label for="phone">Harga</label>
			    <input type="text" name="harga" class="form-control" placeholder="0" value="<?php echo isset($data['harga']) ? $data['harga'] : "";?>">
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</fieldset>
</div>
<script type="text/javascript">
	<?php echo (isset($data))?"$('#penerbit_id').val(".$data['penerbit_id'].");":' ' ?>
</script>