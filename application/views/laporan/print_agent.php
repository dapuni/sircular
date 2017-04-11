<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php 
		if (isset($excel)) {
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=Laporan Data Agent.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
	?>
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
	<h4>Laporan Data Agent</h4>
	<table class="table" style="border:1px solid;" width="100%">
		<tr>
			<th style="border-bottom: 1px solid black;">#</th>
			<th style="border-bottom: 1px solid black;">Agent Cat</th>
			<th style="border-bottom: 1px solid black;">Agent</th>
			<th style="border-bottom: 1px solid black;">Alamat</th>
			<th style="border-bottom: 1px solid black;">Kontak</th>
			<th style="border-bottom: 1px solid black;">Telepon</th>
		</tr>
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
</body>
</html>
