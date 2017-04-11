<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset id="retur">
	<legend>Create New Retur</legend>
	<form action="sirkulasi/retur_penjualan/simpan" method="post">
		<div class="form-group">
		    <label for="city">No. Retur</label>
		    <input type="text" name="return_no" id='retur_no' class="form-control" value="<?php echo isset($retur_no) ? $retur_no : '' ?>">
		</div>
		<div class="form-group">
		    <label>Agent</label>
		    <select name="agent" class="form-control" id="agent">
				<option value="">Select Agent</option>
				<?php 
					foreach ($agent as $agent) 
					{
						echo "<option value=".$agent['agent_id'].">".$agent['nama_agent']."</option>";
					}
				?>
			</select>
		</div>
		<div class="form-group">
		    <label>Retur date</label>
		    <input type="text" name="return_date" id='return_date' class="form-control date" value="<?php echo $return_date ?>" >
		</div>
		<div class="form-group">
		    <label for="city">Majalah</label>
		    <select class="form-control" name="majalah" id="majalah">
		    	<option value="0">---</option>
		   		<?php 
	    			foreach ($majalah as $majalahx) 
	    			{ ?>
	    				<option value="<?php echo $majalahx['majalah_id']?>"><?php echo $majalahx['nama_majalah']?></option>
	    			<?php }
	    		?>
            </select>
		</div>
		<div class="form-group">
		    <label>Edisi</label>
		    <select class="form-control" name="edisi" id="edisi">
		    	<option value="0">---</option>
		    	<?php
		    		if ($edisi) {
		    			foreach ($edisi as $edisix) { ?>
		    				<option value="<?php echo $edisix['edisi_id']?>"><?php echo $edisix['kode_edisi']?></option>
		    			<?php }
		    		}
		    	?>
		    </select>
		</div>
		<div class="form-group">
		    <label>Nomor DO</label>
		    <select class="form-control" name="do" id="do">
		    	<option value="">---</option>
		    	<?php
		    		$startdate = 0;
		    		$max_return_date = 0;
		    		if ($do) {
		    			foreach ($do as $do) { ?>
		    				<option value="<?php echo $do['distribution_realization_detail_id']?>"><?php echo date('y',strtotime($do['date_created']))."/".$do['nama_majalah']."/0".$do['distribution_realization_detail_id'] ?></option>
		    			<?php 
		    			$startdate = $do['date_publish'];
		    			$max_return_date = $do['retur_date'];
		    			}
		    		}
		    	?>
		    </select>
		</div>
		<input type="hidden" name="date_max" id="date_max" value="<?php echo date('Ymd',strtotime($max_return_date)) ?>">
		<p class="help-block" ><em> Max Retur Date : <?php echo date('d/m/Y',strtotime($max_return_date)); ?> </em></p>
		<div class="form-group">
		    <label>Jumlah Diterima</label>
		    <select class="form-control" name="jumlah">
		    	<option value="">---</option>
		    	<?php
		    		//collect all return data
		    		$total_return = 0;
		    		if ($return) {
		    			foreach ($return as $return) {
		    				$total_return = $total_return + $return['jumlah'];
		    			}
		    		}
		    		if ($jumlah) {
		    			$total = $jumlah['consigned'] - $total_return;
		    			for ($i=1; $i <= $total ; $i++) { ?>
		    				<option value="<?php echo $i ?>"><?php echo $i ?></option>
		    			<?php }
		    		}
		    	?>
		    </select>
		</div>
		<div class="form-group">
		    <label>Keterangan</label>
		    <select class="form-control" name="keterangan" id="keterangan">
		    	<option value="">---</option>
		    	<option value="1">No Faktur</option>
		    	<option value="2">Tidak Sesuai dengan Faktur Jalan</option>
		    </select>
		</div>
		<div class="form-group">
		    <label>Password</label>
		    <input class="form-control" name="password" id="password" type="password" >
		    </select>
		</div>
		<button type="submit" class="btn btn-primary check_realisasi" id="submit">Submit</button>
	</form>
</fieldset> <br>
<script type="text/javascript">
	$(function(){
		//For auto select
		$("#majalah,#edisi,#agent,#do").change(function()
		{
			$.get("<?php echo base_url();?>sirkulasi/retur_penjualan/tambah?agent="+$('#agent').val()+"&return_date="+$('#return_date').val()+"&retur_no="+$('#retur_no').val()+"&majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&do="+$('#do').val()+"&keterangan="+$('#keterangan').val(), function(data){
            	$('body').html(data);
        	});
		});

		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>
		<?php echo (isset($select_agent))?"$('#agent').val(".$select_agent.");":''?>
		<?php echo (isset($select_agent))?"$('#agent').val(".$select_agent.");":''?>
		<?php echo (isset($select_do))?"$('#do').val(".$select_do.");":''?>
		<?php echo (isset($select_keterangan))?"$('#keterangan').val(".$select_keterangan.");":''?>
	});
</script>