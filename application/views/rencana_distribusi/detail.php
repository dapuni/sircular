<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<h3 style="margin-top: 4px; margin-bottom: 10px;">Rencana Distribusi Majalah</h3>
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
			<p><?php echo $detail['harga'] ?></p>
		</div>
		<div class="col-xs-4">
			<label>Status</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo ($detail['is_realisasi'] >= 1 ) ? "Realisasi / Locked" : "pending" ?></p>
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
			<p id="stock">0</p>
		</div>
	</div>
</fieldset>

<fieldset>
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
			<th width="3$">#</th>
			<th>Agent Name</th>
			<th>Quota</th>
			<th>Consigned</th>
			<th>Gratis</th>
			<th style="text-align: center;">Action</th>
		</thead>
		<tbody>
			<?php
				$no = 1; $gratis = 0; $distribusi = 0; $consigned = 0; $nama_agent = '';
				foreach ($agent as $agent) 
				{ 
					$gratis = $gratis + $agent['gratis'];
					$distribusi = $distribusi + $agent['quota'] + $agent['consigned'];
					?>
					<tr>
						<td><?php echo $no ?></td>
						<?php 
							if ($nama_agent != $agent['nama_agent']) 
							{
								echo "<td>".$agent['nama_agent']."</td>";
								$nama_agent = $agent['nama_agent'];
							} else {
								echo "<td></td>";
							}
						?>
						<td><?php echo $agent['quota'] ?></td>
						<td><?php echo $agent['consigned'] ?></td>
						<td><?php echo $agent['gratis'] ?></td>
						<td style="text-align: center;"><a href="sirkulasi/rencana_distribusi/edit_agent/<?php echo $id ?>/<?php echo $agent['distribution_plan_detail_id'] ?>" class="btn btn-primary btn-sm check_realisasi"> Edit </a> <a href="sirkulasi/rencana_distribusi/hapus_agent/<?php echo $id ?>/<?php echo $agent['distribution_plan_detail_id'] ?>" class="btn btn-danger btn-sm check_realisasi" onclick="return confirm('Anda Yakin Menghapus Data ini?')"> Hapus </a></td>
					</tr>
				<?php $no++; }
				$stock = $detail['print'] - ($gratis + $distribusi);
			?>
		</tbody>
	</table>
</fieldset>
<?php 
	//check jika data telah direalisasikan
	if ($detail['is_realisasi'] == 0 ) { ?>
		<a class="btn btn-primary check_realisasi" href="sirkulasi/rencana_distribusi/tambah_agent/<?php echo $detail['distribution_plan_id'] ?>" >Tambah Agent</a>
		<a class="btn btn-success check_realisasi" href="sirkulasi/rencana_distribusi/realisasi/<?php echo $detail['distribution_plan_id'] ?>" onclick="return confirm('Anda Yakin Realisasi Data ini?')">Realisasi Rencana Distribusi</a>
		<a href="sirkulasi/rencana_distribusi/hapus_rencana/<?php echo $detail['distribution_plan_id'] ?>" class="btn btn-danger check_realisasi" onclick="return confirm('Anda Yakin Menghapus Data ini ?')" >Hapus Rencana Distribusi</a><br><br>
	<?php }
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#gratis').text(<?php echo $gratis; ?>);
		$('#distribusi').text(<?php echo $distribusi; ?>);
		$('#stock').text(<?php echo $stock; ?>);

		<?php 
			//check jika data telah direalisasikan
			if ($detail['is_realisasi'] == 1 || $detail['is_realisasi'] == 2 ) 
			{
				echo "$('.check_realisasi').click(function(){";
				echo "alert('Data Sudah Direalisasikan Tidak Bisa Dirubah! ');";
				echo "return false;";
				echo "});";
			}
		?>

		//For auto select
		$("#agent_category").change(function()
		{
			document.location.href ="<?php echo base_url();?>sirkulasi/rencana_distribusi/detail/<?php echo $id?>?agent_category="+$('#agent_category').val();
		});
	});

	<?php echo (isset($agent_category))?"$('#agent_category').val(".$agent_category.");":''?>
</script>