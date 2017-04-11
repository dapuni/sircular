<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		*{
			font-size: 9px;
		}
	</style>
</head>
<body>
	<h2 style="margin:5px">PT. Citra Distribusi Mandiri</h2>
	<h5 style="margin:0">Gedung Kosgoro Lt.19</h5>
	<h5 style="margin:0">Jl. MH.Thamrin No.53, Jakarta Pusat 10350</h5>
	<h5 style="margin:0">Telp. : 2302179, 2303039  Fax. : (021)39832330</h5>
	<h4>Laporan Discount</h4>
	<table class="table" style="border: solid 1px" width="100%">
		<tr>
			<th>#</th>
			<th>Agent Cat</th>
			<th>Agent</th>
			<th>Majalah</th>
			<th>Disc Total</th>
			<th>Disc Deposit</th>
		</tr>
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
						<td style="text-align:center"><?php echo $agent['nama_majalah'] ?></td>
						<td style="text-align:center" ><?php echo $agent['disc_total'] ?></td>
						<td style="text-align:center"><?php echo $agent['disc_deposit'] ?></td>
					</tr>
				<?php }
			?>
		</tbody>
	</table>
</body>
</html>	
	
