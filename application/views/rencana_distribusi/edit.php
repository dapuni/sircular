<fieldset>
	<legend>Edit Plan</legend>
	<form action="sirkulasi/rencana_distribusi/update/<?php echo $id;?>" method="post">
		<div class="form-group">
		    <label for="city">Majalah</label>
		    <select class="form-control" id="majalah" disabled>
		   		<?php 
	    			foreach ($majalah as $majalah) 
	    			{ ?>
	    				<option value="<?php echo $majalah['majalah_id']?>"><?php echo $majalah['nama_majalah']?></option>
	    			<?php }
	    		?>
            </select>
		</div>
		<div class="form-group">
		    <label>Edisi</label>
		    <input type="text" class="form-control" value="<?php echo $rencana['kode_edisi'] ?>" disabled >
		    <p class="help-block"><em>e.g. 185/DESEMBER/2011</em></p>
		</div>
		<div class="form-group">
		    <label>Total Print</label>
		    <input type="text" name="plan_print" class="form-control" value="<?php echo $rencana['print'] ?>">
		</div>
		<div class="form-group">
		    <label>Publish date</label>
		    <input type="text" name="publish_date" class="form-control date" value="<?php echo date('Y-m-d', strtotime($rencana['date_publish']))  ?>">
		</div>
		<button type="submit" class="btn btn-primary check_realisasi">Submit</button>
	</form>
</fieldset> <br>
<script type="text/javascript">
	$(document).ready(function(){
		<?php 
			//check jika data telah direalisasikan
			if ($rencana['is_realisasi'] == 2) 
			{
				echo "$('.check_realisasi').click(function(){";
				echo "alert('Data Sudah Direalisasikan Tidak Bisa Dirubah! ');";
				echo "return false;";
				echo "});";
			}
		?>

		<?php echo (isset($rencana))?"$('#majalah').val(".$rencana['majalah_id'].");":''?>
	});
	
</script>