<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<h3 style="margin-top: 4px; margin-bottom: 10px;">Realisasi Distribusi Majalah</h3>
<fieldset>
	<legend>Majalah Yang Akan Diedarkan</legend>
	<div class="col-xs-6">
		<div class="col-xs-4">
			<label>Majalah</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo $detail['nama_majalah'] ?></p>
		</div>
		<div class="col-xs-4">
			<label>Harga</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo number_format($detail['harga'],0,',','.')  ?></p>
		</div>
		<div class="col-xs-4">
			<label>Status</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo ($detail['is_realisasi'] == 1 ) ? "Realisasi" : "Locked" ?></p>
		</div>
		<div class="col-xs-4">
			<label>Total Rencana</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo isset($total_rencana)? $stock = $total_rencana['total'] :"" ?></p>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="col-xs-4">
			<label>Edisi</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo $detail['kode_edisi'] ?></p>
		</div>
		<div class="col-xs-4">
			<label>Tanggal Terbit</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo date('d-m-Y',strtotime($detail['date_publish'])) ?></p>
		</div>
		<div class="col-xs-4">
			<label><?php echo ($detail['is_realisasi'] == 1 ) ? "Realisasi By" : "Lock By" ?></label>
		</div>
		<div class="col-xs-8">
			<p><?php echo  $detail['username']?></p>
		</div>
		<div class="col-xs-4">
			<label>Total Realisasi</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo isset($total_realisasi)? $total_realisasi['total'] :"" ?></p>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Rencana Edaran</legend>
	<div class="col-xs-6">
		<div class="col-xs-4">
			<label>Cetak</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo $detail['print'] ?></p>
		</div>
		<div class="col-xs-4">
			<label>Gratis</label>
		</div>
		<div class="col-xs-8">
			<p id="gratis">0</p>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="col-xs-4">
			<label>Distribusi</label>
		</div>
		<div class="col-xs-8">
			<p id="distribusi">0</p>
		</div>
		<div class="col-xs-4">
			<label>Stock</label>
		</div>
		<div class="col-xs-8">
			<p id="stock" style="color: red ">0</p>
		</div>
	</div>
</fieldset>
<fieldset>
	<form method="post" target="_blank" id="myform">
	<legend>Detail Per Agent</legend>
	<select class="form-control" name="agent_category" id="agent_category">
		<option value=""> -All- </option>
        <?php 
        	foreach ($agent_cat as $agent_cat) 
        	{ ?>
        		<option value="<?php echo $agent_cat['agent_category_id'] ?>"><?php echo $agent_cat['nama_agent_cat']; ?></option>
        	<?php }
        ?>
    </select>
	<table class="table">
		<thead>
			<th width="3%">#</th>
			<th>Agent Name</th>
			<th>Ekspedisi</th>
			<th style="text-align:center">Do#</th>
			<th style="text-align:center">Quota</th>
			<th style="text-align:center">Consigned</th>
			<th style="text-align:center">Gratis</th>
			<th style="text-align:center">Diskon%</th>
			<th style="text-align:center">Deposit</th>
			<th style="text-align: center;">Action</th>
		</thead>
		<tbody>
		<?php
			$gratis = 0; $distribusi = 0; $consigned = 0; $nama_agent = '';
			foreach ($agent as $agent) 
			{ 
				$gratis = $gratis + $agent['gratis'];
				$distribusi = $distribusi + $agent['quota'] + $agent['consigned'];
				?>
				<tr>
					<input type="hidden" name="id" value="<?php echo $id?>">
					<input type="hidden" name="agent_id[]" value="<?php echo $agent['agent_id']?>">
					<td><input type="checkbox" class="checkbox" name="dist_realization_detail_id[]" value="<?php echo $agent['distribution_realization_detail_id']?>"></td>
					<?php 
						if ($nama_agent != $agent['nama_agent']) 
						{
							echo "<td>".$agent['nama_agent']."</td>";
							$nama_agent = $agent['nama_agent'];
						} else {
							echo "<td></td>";
						}
					?>
					<td><?php echo $agent['ekspedisi'] ?></td>
					<td style="text-align:center"><?php echo date('y',strtotime($agent['date_created']))."/".$detail['nama_majalah']."/0".$agent['distribution_realization_detail_id'] ?></td>
					<td style="text-align:center"><?php echo $agent['quota'] ?></td>
					<td style="text-align:center"><?php echo $agent['consigned'] ?></td>
					<td style="text-align:center"><?php echo $agent['gratis'] ?></td>
					<td style="text-align:center"><?php echo $agent['disc_total'] ?></td>
					<td style="text-align:center"><?php echo $agent['disc_deposit'] ?></td>
					<td style="text-align: center;"><a href="sirkulasi/realisasi_distribusi/edit/<?php echo $id."/".$agent['distribution_realization_detail_id']; ?>" class="btn btn-primary  btn-sm check_realisasi">Edit</a> <a href="sirkulasi/realisasi_distribusi/hapus/<?php echo $id."/".$agent['distribution_realization_detail_id'];  ?>" class="btn btn-danger btn-sm check_realisasi" onclick="return confirm('Anda Yakin Menghapus Data?')" >Hapus</a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</fieldset>
	<a class="btn btn-primary btn-sm check_realisasi" href="sirkulasi/realisasi_distribusi/tambah/<?php echo $detail['distribution_plan_id'] ?>" >Tambah Agent</a>
		<?php 
		if ($accounting == TRUE) 
		{ ?>
			<a class="btn btn-success btn-sm check_realisasi" href="sirkulasi/realisasi_distribusi/lock/<?php echo $detail['distribution_plan_id'] ?>" onclick="return confirm('Anda Yakin Mengunci Data ini?')">Kunci Realisasi Rencana Distribusi</a>
		<?php }
	?>
  	<button type="submit" class="btn btn-primary btn-sm cetak do_html" ><span class="glyphicon glyphicon-print"></span> Cetak DO</button>
  	<button type="submit" class="btn btn-primary btn-sm cetak do_pdf" > <span class="glyphicon glyphicon-save-file"></span> Cetak PDF DO</button>
	</form>
</br></br></br>
<script type="text/javascript">
	$(document).ready(function(){
		$('#gratis').text(<?php echo $gratis; ?>);
		$('#distribusi').text(<?php echo $distribusi; ?>);
		$('#stock').text(<?php echo $stock - $total_realisasi['total']; ?>);

		<?php 
			//check jika data telah direalisasikan
			if ($detail['is_realisasi'] == 2) 
			{
				echo "$('.check_realisasi').click(function(){";
				echo "alert('Data Sudah Dikunci');";
				echo "return false;";
				echo "});";
			}
		?>

		$('.cetak').click(function(){
			if($('input[name="dist_realization_detail_id[]"]:checked').length == 0 || <?php echo $stock; ?> < 0 ){
			    alert('Agent Belum dipilih / Stock Minus');
			    return false;
			}
		})

		$('.do_html').click(function(){
			$("#myform").attr('action', '<?php echo base_url()?>sirkulasi/realisasi_distribusi/cetak_do');
		});

		$('.do_pdf').click(function(){
			$("#myform").attr('action', '<?php echo base_url()?>sirkulasi/realisasi_distribusi/cetak_do_pdf');
		});

		//For auto select
		$("#agent_category").change(function()
		{
			document.location.href ="<?php echo base_url();?>sirkulasi/realisasi_distribusi/detail/<?php echo $id?>?agent_category="+$('#agent_category').val();
		});

		<?php echo (isset($agent_category))?"$('#agent_category').val(".$agent_category.");":''?>
	});
</script>
