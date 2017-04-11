<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>Detail Retur</legend>
		<div class="form-group">
		    <label for="city">No. Retur</label>
		    <input type="text" name="return_no" id='retur_no' class="form-control" value="<?php echo ($retur_no != '') ? $retur_no : $return['no_return'] ?>" readonly>
		</div>
		<div class="form-group">
		    <label>Agent</label>
		    <select name="agent" class="form-control" id="agent" readonly>
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
		    <input type="date" name="return_date" id='return_date' class="form-control" value="<?php echo ($return_date != '') ? $return_date : date('Y-m-d',strtotime($return['return_date'])) ?>" readonly>
		</div>
		<div class="form-group">
		    <label for="city">Majalah</label>
		    <input type="text" class="form-control" name="edisi" value="<?php echo $return['nama_majalah'] ?>" readonly>
		</div>
		<div class="form-group">
		    <label>Edisi</label>
		    <input type="text" class="form-control" name="edisi" value="<?php echo $return['kode_edisi'] ?>" readonly>
		</div>
		<div class="form-group">
		    <label>Nomor DO</label>
		    <input type="text" class="form-control" name="do" value="<?php echo date('y',strtotime($return['date_created']))."/".$return['nama_majalah']."/0".'/0'.$return['distribution_realization_detail_id'] ?>" readonly>
		</div>
		<div class="form-group">
		    <label>Jumlah Diterima</label>
		    <input type="text" class="form-control" name="jumlah" value="<?php echo $return['jumlah'] ?>" readonly>
		</div>
		<div class="form-group">
		    <label>Keterangan</label>
		     <input type="text" class="form-control" name="jumlah" value="<?php echo ($return['keterangan'] == 1) ? 'No Faktur' : (($return['keterangan'] == 2) ? 'Tidak Sesuai dengan Faktur Jalan' : '') ?> " readonly>
		</div>
</fieldset> <br>
<script type="text/javascript">
	$(function(){
		//For auto select
		$("#majalah,#edisi,#agent,#do").change(function()
		{
			$.get("<?php echo base_url();?>sirkulasi/retur_penjualan/detail/<?php echo $id?>?agent="+$('#agent').val()+"&return_date="+$('#return_date').val()+"&retur_no="+$('#retur_no').val()+"&majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&do="+$('#do').val(), function(data){
            	$('body').html(data);
        	});
		});
		//autoselect
		<?php echo "$('#agent').val(".$return['agent_id'].");" ?>
	});
</script>