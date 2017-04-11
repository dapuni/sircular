<fieldset>
	<legend>Laporan Data Agent</legend>
	<div class="col-xs-12 ">
		<a class="btn btn-default" onclick="popWindow()"> <i class="fa fa-print"></i> Print As HTML</a>
		<a class="btn btn-default" href="laporan/agent/pdf_agent" target="_blank"> <i class="fa fa-file-pdf-o"></i> Print As PDF</a>
		<a href="laporan/agent/export" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Excel</a>
	</div>
	
	<table class="table">
		<thead>
			<th>#</th>
			<th>Agent Cat</th>
			<th>Agent</th>
			<th>Alamat</th>
			<th>Kontak</th>
			<th>Telepon</th>
		</thead>
		<tbody>
			<?php 
			$no = 1;
			$agent_cat = '';
			foreach ($agent as $agent) 
			{ 
				?>
				<tr>
					<td><?php echo $no; ?></td>
					<?php 
						if ($agent_cat != $agent['nama_agent_cat']) {
							echo "<td>".$agent['nama_agent_cat']."</td>";
							$agent_cat = $agent['nama_agent_cat'];
						} else{
							echo "<td></td>";
						}
					?>
					<td><?php echo $agent['nama_agent']; ?></td>
					<td><?php echo $agent['address'] ?></td>
					<td><?php echo $agent['contact'] ?></td>
					<td><?php echo $agent['phone'] ?></td>
				</tr>
			<?php $no++; } ?>
		</tbody>
	</table>
</fieldset>
<script type="text/javascript">
	function popWindow() {
	    var newWindow = window.open("<?php echo base_url()?>laporan/agent/cetak", "", "width=400, height=500");
	}
</script>