<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<form action="masterdata/majalah" method="get">
	<div class="col-xs-6">
		<select name="cari" onchange="this.form.submit()" class="form-control" id="cari">
				<option>---</option>
				<?php 
					foreach ($penerbit as $penerbit) 
					{ ?>
						<option value="<?php echo $penerbit['penerbit_id'] ;?>"><?php echo $penerbit['nama'] ;?></option>
					<?php }
				?>
	    </select>
	</div>
	<div class="col-xs-6">
		<a href="masterdata/majalah/tambah" class="btn btn-default"> Tambah </a>
	</div>
</form>

<table class="table table-striped">
	<thead style="text-align: center;">
		<th width="3%">#</th>
		<th>Nama Majalah</th>
		<th>Penerbit</th>
		<th>Periode</th>
		<th>Harga</th>
		<th style="text-align: center;">Action</th>
	</thead>
	<tbody>
	<?php 
		$no = 1;
		foreach ($data as $data) 
		{ ?>
			<tr>
				<td><?php echo $no ?></td>
				<td><?php echo $data['nama_majalah'] ?></td>
				<td><?php echo $data['nama'] ?></td>
				<td><?php echo $data['periode'] ?></td>
				<td><?php echo number_format($data['harga'],0,',','.') ?></td>
				<td style="text-align: center;"><a class="btn btn-primary btn-sm" href="masterdata/majalah/agent/<?php echo $data['majalah_id'] ?>"> Agent  </a> <a class="btn btn-success btn-sm" href="masterdata/majalah/edit/<?php echo $data['majalah_id'] ?>"> Edit  </a> <a class="btn btn-danger btn-sm" href="masterdata/majalah/delete/<?php echo $data['majalah_id'] ?>" onclick="return confirm('Anda Yakin Menghapus Data?')" > Hapus</a></td>
			</tr>
		<?php $no++; }
	?>
	</tbody>
</table>
<?php echo $pagination ?>
<script type="text/javascript">
	<?php echo (isset($find))?"$('#cari').val(".$find.");":''?>
</script>