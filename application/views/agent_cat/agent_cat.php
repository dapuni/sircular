<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>

<a href="masterdata/agent_cat/tambah" class="btn btn-default"> Tambah </a>
<table class="table table-striped">
	<thead style="text-align: center;">
		<th width="3%">#</th>
		<th>Nama</th>
		<th>Keterangan</th>
		<th style="text-align: center;">Action</th>
	</thead>
	<tbody>
		<?php 
		$no = 1;
			foreach ($agent_cat as $agent_cat) 
			{ ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $agent_cat['nama_agent_cat']; ?></td>
					<td><?php echo $agent_cat['description']; ?></td>
					<td style="text-align: center;"><a class="btn btn-success btn-sm" href="masterdata/agent_cat/edit/<?php echo $agent_cat['agent_category_id']; ?>"> Edit </a> <a <a class="btn btn-danger btn-sm"href="masterdata/agent_cat/delete/<?php echo $agent_cat['agent_category_id']; ?>" onclick="return confirm('Anda Yakin Menghapus Data?')"> Hapus</a></td>
				</tr>
			<?php $no++; }
		?>
		
	</tbody>
</table>