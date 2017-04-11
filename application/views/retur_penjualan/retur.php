<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<div class="col-xs-1" style="padding:0;">
	<a href="sirkulasi/retur_penjualan/tambah" class="btn btn-default">Tambah</a>
</div>
<div class="col-xs-11">
	<form action="<?php echo base_url()?>sirkulasi/retur_penjualan" method='get'>
		<div class="col-xs-4">
			<select name="majalah" class="form-control" id="majalah">
				<option value="">Select Magazine</option>
				<?php 
	    			foreach ($majalah as $majalah) 
	    			{ ?>
	    				<option value="<?php echo $majalah['majalah_id']?>"><?php echo $majalah['nama_majalah']?></option>
	    			<?php }
	    		?>
			</select>
		</div>
		<div class="col-xs-4">
			<select name="edisi" class="form-control" id="edisi">
				<option value="">Select Edition</option>
				<?php
		    		if ($edisi) {
		    			foreach ($edisi as $edisix) { ?>
		    				<option value="<?php echo $edisix['edisi_id']?>"><?php echo $edisix['kode_edisi']?></option>
		    			<?php }
		    		}
		    	?>
			</select>
		</div>
	</form>
</div>
<table class="table">
	<thead>
		<th width="3%">#</th>
		<th>Agent</th>
		<th>Majalah</th>
		<th>Edisi</th>
		<th>Nomor Retur</th>
		<th>Retur Date</th>
		<th>Jumlah</th>
		<th style="text-align: center">Action</th>
		<tbody>
			<?php 
			$no = 1;
			foreach ($retur as $retur) 
			{ ?>
			 	<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $retur['nama_agent']; ?></td>
					<td><?php echo $retur['nama_majalah']; ?></td>
					<td><?php echo $retur['kode_edisi']; ?></td>
					<td><?php echo $retur['no_return']; ?></td>
					<td><?php echo date('d/m/Y',strtotime($retur['return_date'])) ; ?></td>
					<td><?php echo $retur['jumlah']; ?></td>
					<td style="text-align: center"><a href="sirkulasi/retur_penjualan/detail/<?php echo $retur['return_item_id']?>" class="btn btn-primary btn-sm">Detail</a> <a href="sirkulasi/retur_penjualan/hapus/<?php echo $retur['return_item_id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin Menghapus Data?')" >Hapus</a></td>
				</tr>
			<?php $no++; } ?>
		</tbody>
	</thead>
</table>
<?php echo $pagination ?>
<script type="text/javascript">
	//For auto select
	$("#majalah,#edisi").change(function()
	{
		$.get("<?php echo base_url();?>sirkulasi/retur_penjualan?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val(),function(data){
        	$('body').html(data);
    	});
	});
	<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
	<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>
</script>