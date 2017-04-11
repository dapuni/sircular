<fieldset>
	<legend>Laporan Discount Agent</legend>
	<div class="col-xs-12 ">
		<a class="btn btn-default" onclick="popWindow()"> <i class="fa fa-print"></i> Print As HTML</a>
		<a class="btn btn-default" href="laporan/agent/pdf_discount" target="_blank"> <i class="fa fa-file-pdf-o"></i> Print As PDF</a>
		<a href="laporan/agent/export_discount" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Excel</a>
	</div>
	
	<table class="table">
		<thead>
			<th>#</th>
			<th>Agent Cat</th>
			<th>Agent</th>
			<th>Majalah</th>
			<th>Disc Total</th>
			<th>Disc Deposit</th>
		</thead>
		<tbody>
			<?php
				$nama_agent_cat = '';
				$nama_agent = '';
				$no = 1;
				foreach ($agent as $agent) 
				{ ?>
					<tr>
						<td><?php echo $no++ ?></td>
						<?php 
							if ($nama_agent_cat != $agent['nama_agent_cat']) 
							{
								echo "<td>".$agent['nama_agent_cat']."</td>";
								$nama_agent_cat = $agent['nama_agent_cat'];
							} else {
								echo "<td></td>";
							}

							if ($nama_agent != $agent['nama_agent']) 
							{
								echo "<td>".$agent['nama_agent']."</td>";
								$nama_agent = $agent['nama_agent'];
							} else {
								echo "<td></td>";
							}
						?>
						<td><?php echo $agent['nama_majalah'] ?></td>
						<td><?php echo $agent['disc_total'] ?></td>
						<td><?php echo $agent['disc_deposit'] ?></td>
					</tr>
				<?php }
			?>
		</tbody>
	</table>
</fieldset>
<script type="text/javascript">
	function popWindow() {
	    var newWindow = window.open("<?php echo base_url()?>laporan/agent/cetak_discount", "", "width=400, height=500");
	}
</script>