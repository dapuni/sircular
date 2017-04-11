<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php 
		if (isset($excel)) {
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=Laporan Penerbit.xls");
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
	<h4>Laporan Data Penerbit</h4>
	<table class="table" style="border:1px solid;" width="100%" >
		<tr>
			<th style="border-bottom: 1px solid black;">#</th>
			<th style="border-bottom: 1px solid black;">Penerbit</th>
			<th style="border-bottom: 1px solid black;">NPWP</th>
			<th style="border-bottom: 1px solid black;">Alamat</th>
			<th style="border-bottom: 1px solid black;">Telepon</th>
			<th style="border-bottom: 1px solid black;">Majalah</th>
		</tr>
		<tbody>
			<?php 
				$no = 1;
				$nama = '';
				$npwp = '';
				$alamat = '';
				$phone = '';
				foreach ($majalah as $majalah) 
				{ ?>
					<tr>
						<td><?php echo $no ?></td>
						<?php 
							if ($nama != $majalah['nama']) {
								echo "<td>".$majalah['nama']."</td>";
								$nama = $majalah['nama'];
							} else{
								echo "<td></td>";
							}

							if ($npwp != $majalah['npwp']) {
								echo "<td>".$majalah['npwp']."</td>";
								$npwp = $majalah['npwp'];
							} else{
								echo "<td></td>";
							}

							if ($alamat != $majalah['alamat']) {
								echo "<td>".$majalah['alamat']."</td>";
								$alamat = $majalah['alamat'];
							} else{
								echo "<td></td>";
							}

							if ($phone != $majalah['phone']) {
								echo "<td>".$majalah['phone']."</td>";
								$phone = $majalah['phone'];
							} else{
								echo "<td></td>";
							}
						?>
						<td><?php echo $majalah['nama_majalah'] ?></td>
					</tr>
				<?php $no++; }
			?>
		</tbody>
	</table>
</body>
</html>	
	
