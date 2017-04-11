<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<form action="<?php echo $url?>">
	<div class="col-xs-6" >
		<select class="form-control" name="cari" id="cari" onchange="this.form.submit()">
			<option>---</option>
    		<?php 
    			foreach ($majalah as $majalah) 
    			{ ?>
    				<option value="<?php echo $majalah['majalah_id']?>"><?php echo $majalah['nama_majalah']?></option>
    			<?php }
    		?>
        </select>
	</div>
	<div class="col-xs-6">
		<a href="masterdata/edisi/tambah" class="btn btn-default"> Tambah </a>
	</div>
</form>
<table class="table table-striped">
	<thead style="text-align: center;">
		<th width="3%">#</th>
		<th>Nama Majalah</th>
		<th>Edisi</th>
		<th>Retur Date</th>
		<th>Harga</th>
		<th style="text-align:center;">Action</th>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			foreach ($edisi as $edisi) 
			{ ?>
				<tr>
					<td><?php echo $no++ ?></td>
					<td><?php echo $edisi['nama_majalah'] ?></td>
					<td><?php echo $edisi['kode_edisi'] ?></td>
					<td><?php echo date('d-m-Y',strtotime($edisi['retur_date'])) ?></td>
					<td><?php echo number_format($edisi['harga'],0,',','.') ?></td>
					<td style="text-align:center;"><a href="masterdata/edisi/edit/<?php echo $edisi['edisi_id'] ?>" class="btn btn-success btn-sm"> Edit </a> <a href="masterdata/edisi/delete/<?php echo $edisi['edisi_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin Menghapus Data?')" > Hapus</a></td>
				</tr>
			<?php }
		?>
		
	</tbody>
</table>
<?php echo $pagination ?>
<script type="text/javascript">
	<?php echo isset($cari)?"$('#cari').val(".$cari.");":''?>
</script>