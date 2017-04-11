<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>

<form action="masterdata/penerbit" method="get">
	<div class="col-xs-6">
		<select name="cari" onchange="this.form.submit()" class="form-control" id="cari">
			<option>---</option>
			<?php 
	    		foreach ($city as $city)
	    		{ ?>
	    			<option value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
	    		<?php }
	    	?>
	    </select>
	</div>
	<div class="col-xs-6">
		<a href="masterdata/penerbit/tambah" class="btn btn-default"> Tambah </a>
	</div>
</form>
<table class="table table-striped">
	<thead style="text-align: center;">
		<th width="3%">#</th>
		<th>Nama</th>
		<th>Kota</th>
		<th>Provinsi</th>
		<th>Telepon</th>
		<th>Kontak</th>
		<th style="text-align: center;">Action</th>
	</thead>
	<tbody>
	<?php 
		$no = 1;
		foreach ($data as $data) 
		{ ?>
			<tr>
				<td><?php echo $no ?></td>
				<td><?php echo $data['nama'] ?></td>
				<td><?php echo $data['nama_kota'] ?></td>
				<td><?php echo $data['nama_provinsi'] ?></td>
				<td><?php echo $data['phone'] ?></td>
				<td><?php echo $data['contact'] ?></td>
				<td style="text-align: center;"><a class="btn btn-success btn-sm" href="masterdata/penerbit/edit/<?php echo $data['penerbit_id'] ?>"  > Edit  </a> <a class="btn btn-danger btn-sm" href="masterdata/penerbit/delete/<?php echo $data['penerbit_id'] ?>" onclick="return confirm('Anda Yakin Menghapus Data?')"> Hapus</a></td>
			</tr>
		<?php $no++; }
	?>
	</tbody>
</table>
<?php echo $pagination ?>
<script type="text/javascript">
	<?php echo (isset($find))?"$('#cari').val(".$find.");":''?>
</script>