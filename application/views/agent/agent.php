<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<form action="masterdata/agent">
	<div class="form-group col-xs-3">
		<select name="category_agent" class="form-control" id="category">
			<option value="0">--</option>
			<?php 
				foreach ($category_agent as $category_agent) 
				{ ?>
					<option value="<?php echo $category_agent['agent_category_id']?>"><?php echo $category_agent['nama_agent_cat']?></option>
				<?php }
			?>
		</select>
	</div>
	<div class="form-group col-xs-3">
		<select name="kota" class="form-control" id="kota">
			<option value="0">--</option>
			<?php 
				foreach ($kota as $kota) 
				{ ?>
					<option value="<?php echo $kota['id']?>"><?php echo $kota['name']?></option>
				<?php }
			?>
		</select>
	</div>
	<button class="btn btn-default">Cari</button>
	<a href="masterdata/agent/tambah" class="btn btn-default"> Tambah </a>
</form>

<table class="table table-striped">
	<thead style="text-align: center;">
		<th width="3%">#</th>
		<th>Nama</th>
		<th>Kota</th>
		<th>Kategori</th>
		<th>Telepon</th>
		<th>Kontak</th>
		<th style="text-align: center;">Action</th>
	</thead>
	<tbody>
		<?php
			$no = 1;
			foreach ($agent as $agent) 
			{ ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $agent['nama_agent']; ?></td>
					<td><?php echo $agent['name']; ?></td>
					<td><?php echo $agent['nama_agent_cat']; ?></td>
					<td><?php echo $agent['phone']; ?></td>
					<td><?php echo $agent['contact']; ?></td>
					<td style="text-align: center;"><a class="btn btn-primary btn-sm" href="masterdata/agent/relation/<?php echo $agent['agent_id']; ?>"> Majalah  </a> <a class="btn btn-success btn-sm" href="masterdata/agent/edit/<?php echo $agent['agent_id']; ?>"> Edit  </a> <a class="btn btn-danger btn-sm" href="masterdata/agent/delete/<?php echo $agent['agent_id']; ?>" onclick="return confirm('Anda Yakin Menghapus Data?')" > Hapus</a></td>
				</tr>
			<?php $no++; }
		?>
	</tbody>
</table>
<?php echo $pagination; ?>
<script type="text/javascript">
	<?php echo (isset($category))?"$('#category').val(".$category.");":''?>
	<?php echo (isset($city))?"$('#kota').val(".$city.");":''?>
</script>