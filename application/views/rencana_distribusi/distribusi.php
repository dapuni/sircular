<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<div class="col-xs-1" style="padding:0;">
	<a href="sirkulasi/rencana_distribusi/tambah" class="btn btn-default">Tambah</a>
</div>
<div class="col-xs-11">
	<form action="<?php echo base_url()?>sirkulasi/rencana_distribusi" method='get'>
		<div class="col-xs-5">
			<select name="majalah" class="form-control" id="search">
				<option value="">---</option>
				<?php 
					foreach ($majalah as $majalah) 
					{
						echo "<option value=".$majalah['majalah_id'].">".$majalah['nama_majalah']."</option>";
					}
				?>
			</select>
		</div>
		<div class="col-xs-7">
			<button type="submit" class="btn btn-default"> Cari</button>
		</div>
	</form>
</div>
<table class="table">
	<thead>
		<th width="3%">#</th>
		<th>Magazine</th>
		<th>Edition</th>
		<th>Publish Date</th>
		<th>Total Print</th>
		<th>Status</th>
		<th style="text-align: center">Action</th>
	</thead>
	<tbody>
		<?php
			$no = 1;
			foreach ($rencana as $rencana) 
			{ ?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $rencana['nama_majalah']; ?></td>
					<td><?php echo $rencana['kode_edisi']; ?></td>
					<td><?php echo date('d-m-Y',strtotime($rencana['date_publish'])) ?></td>
					<td><?php echo $rencana['print']; ?></td>
					<td><?php echo ($rencana['is_realisasi'] == 0) ? "Pending" : "Realisasi / Locked"?></td>
					<td style="text-align: center;"><a href="sirkulasi/rencana_distribusi/edit/<?php echo $rencana['distribution_plan_id']?>" class="btn btn-primary btn-sm" > Edit </a> <a  href="sirkulasi/rencana_distribusi/detail/<?php echo $rencana['distribution_plan_id']?>" class="btn btn-success btn-sm" > Details </a> </td>
				</tr>
			<?php }
		?>
	</tbody>
</table>
<?php echo $pagination ?>
<script type="text/javascript">
	<?php echo (isset($search))?"$('#search').val(".$search.");":''?>
</script>
