<!DOCTYPE html>
<html>
<head>
	<?php 
		if (isset($excel)) {
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=Penjualan Majalah.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
	?>
	<title></title>
	<style type="text/css">
		*{
			font-size: 11px;
		}
	</style>
</head>
<body>
	<h2 style="margin:0; font-size: 20px ">PT. Citra Distribusi Mandiri</h2>
	<h5 style="margin:0">Wisma MRA Lantai 3 </h5>
	<h5 style="margin:0">Jl. TB. Simatupang No. 19 Cilandak Barat, Cilandak Jakarta Selatan </h5>
	<h5 style="margin:0">Telp. : </h5>
	<h4>Laporan Data Penjualan Majalah <?php echo $majalah['nama_majalah'].' EDISI '.$edisi['kode_edisi'].' HARGA Rp. '.number_format($edisi['harga'],0,'.','.') ?></h4>
	<table class="table" style="border:1px solid;" width="100%">
		<tr>
			<th style="border-bottom: 1px solid black;">#</th>
			<th style="border-bottom: 1px solid black;">Kategori</th>
			<th style="border-bottom: 1px solid black;">Kota</th>
			<th style="border-bottom: 1px solid black;">Nama Agent</th>
			<th style="border-bottom: 1px solid black;">Jatah</th>
			<th style="border-bottom: 1px solid black;">Konsinyasi</th>
			<th style="border-bottom: 1px solid black;">Total</th>
			<th style="border-bottom: 1px solid black;">Retur</th>
			<th style="border-bottom: 1px solid black;">Laku</th>
			<th style="border-bottom: 1px solid black;">% Laku</th>
			<th style="border-bottom: 1px solid black;">SubOmzet</th>
		</tr>
		<tbody>
		<?php
			if (isset($laporan)) {
				$no = 1;
				$nama_agent_cat = '';
				$kota = '';
				$separated_agent_category = '';
				foreach ($laporan as $keylaporan) {
					//separated between category
					if ($separated_agent_category == '') {
						$separated_agent_category = $keylaporan['agent_category_id'];

					}
					if ($separated_agent_category != $keylaporan['agent_category_id']) {
						$count_jatah = 0;
						$count_konsinyasi = 0;
						$count_retur = 0;
						$jumlah_retur = 0;
						$distribution_realization_detail_id = 0;
						$sum_total_omset = 0;
						$sum_total_retur = 0;
						foreach ($laporan as $keycountlaporan) {
							if ($keycountlaporan['agent_category_id'] == $separated_agent_category && $keycountlaporan['distribution_realization_detail_id'] != $distribution_realization_detail_id) {
								$distribution_realization_detail_id = $keycountlaporan['distribution_realization_detail_id'];
								$count_jatah = $count_jatah + $keycountlaporan['quota'];
								$count_konsinyasi = $count_konsinyasi + $keycountlaporan['consigned'];
								$sum_total_omset = $sum_total_omset + (($keycountlaporan['quota'] + $keycountlaporan['consigned']) * $keycountlaporan['harga']) * ((100 - $keycountlaporan['disc_total'])/100);
								$sum_total_retur = $sum_total_retur + ($keycountlaporan['retur'] * $keycountlaporan['harga']) * ((100 - $keycountlaporan['disc_total'])/100);
								$count_retur = $count_retur + $keycountlaporan['retur'];
								$nama_kategori = $keycountlaporan['nama_agent_cat'];
							}
						}

						$sum_total = $count_jatah + $count_konsinyasi;
						$sum_laku = $sum_total - $count_retur;
						$persenlaku = ($sum_total != 0) ? $sum_laku / $sum_total * 100 : 0 ; 

						echo "<tr>";
							echo "<td colspan=3>Total</td>";
							echo "<td>".$nama_kategori."</td>";
							echo "<td style='text-align:center'>".$count_jatah."</td>";
							echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
							echo "<td style='text-align:center'>".$sum_total."</td>";
							echo "<td style='text-align:center'>".$count_retur."</td>";
							echo "<td style='text-align:center'>".$sum_laku."</td>";
							echo "<td style='text-align:center'>".number_format($persenlaku,2,'.','.')."</td>";
							echo "<td style='text-align:right'>".(isset($excel) ? ($sum_total_omset - $sum_total_retur) : number_format(($sum_total_omset - $sum_total_retur),0,'.','.'))."</td>";
						echo "</tr>";
						$separated_agent_category = $keylaporan['agent_category_id'];
					}

					//data agent
					$total = $keylaporan['quota'] + $keylaporan['consigned'];
					$retur = ($keylaporan['retur'] != '') ? $keylaporan['retur'] : 0;
					$laku = $total - $retur;
					$persenlaku = ($laku == 0 )? 0 :($laku / $total) * 100;
					$Subomzet = ($laku * $keylaporan['harga']) * ((100 - $keylaporan['disc_total']) / 100) ;
					?>
					<tr>
						<td><?php echo $no++ ?></td>
						<?php 
							if ($nama_agent_cat != $keylaporan['agent_category_id']) {
								echo "<td>".$keylaporan['nama_agent_cat']."</td>";
								$nama_agent_cat = $keylaporan['agent_category_id'];
							} else{
								echo "<td></td>";
							}
							
							if ($kota != $keylaporan['name']) {
								echo "<td>".$keylaporan['name']."</td>";
								$kota = $keylaporan['name'];
							} else{
								echo "<td></td>";
							}

						?>
						<td><?php echo $keylaporan['nama_agent'] ?></td>
						<td style='text-align:center' ><?php echo $keylaporan['quota'] ?></td>
						<td style='text-align:center' ><?php echo $keylaporan['consigned'] ?></td>
						<td style='text-align:center' ><?php echo $total ?></td>
						<td style='text-align:center' ><?php echo $retur ?></td>
						<td style='text-align:center' ><?php echo $laku ?></td>
						<td style='text-align:center' ><?php echo number_format($persenlaku,1,',','.') ?></td>
						<td style='text-align:right'><?php echo isset($excel) ? $Subomzet : number_format($Subomzet,0,',','.') ?></td>

					</tr>
				<?php }
					//for last category
					$count_jatah = 0;
					$count_konsinyasi = 0;
					$count_retur = 0;
					$jumlah_retur = 0;
					$sum_total_omset = 0;
					$distribution_realization_detail_id = 0;
					foreach ($laporan as $keycountlaporan) {
						if ($keycountlaporan['agent_category_id'] == $separated_agent_category && $keycountlaporan['distribution_realization_detail_id'] != $distribution_realization_detail_id) {
							$distribution_realization_detail_id = $keycountlaporan['distribution_realization_detail_id'];
							$count_jatah = $count_jatah + $keycountlaporan['quota'];
							$count_konsinyasi = $count_konsinyasi + $keycountlaporan['consigned'];
							$count_retur = $count_retur + $keycountlaporan['retur'];
							$sum_total_omset = $sum_total_omset + (($keycountlaporan['quota'] + $keycountlaporan['consigned']) * $keycountlaporan['harga']) * ((100 - $keycountlaporan['disc_total'])/100);
							$nama_kategori = $keycountlaporan['nama_agent_cat'];
						}
					}

					$sum_total = $count_jatah + $count_konsinyasi;
					$sum_laku = $sum_total - $count_retur;
					$persenlaku = ($sum_total != 0) ? $sum_laku / $sum_total * 100 : 0;

					echo "<tr>";
						echo "<td colspan=3>Total</td>";
						echo "<td>".$nama_kategori."</td>";
						echo "<td style='text-align:center'>".$count_jatah."</td>";
						echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
						echo "<td style='text-align:center'>".$sum_total."</td>";
						echo "<td style='text-align:center'>".$count_retur."</td>";
						echo "<td style='text-align:center'>".$sum_laku."</td>";
						echo "<td style='text-align:center'>".number_format($persenlaku,2,'.','.')."</td>";
						echo "<td style='text-align:right'>".(isset($excel) ? $sum_total_omset : number_format($sum_total_omset,0,'.','.'))."</td>";
					echo "</tr>";
			}
			
		?>
		</tbody>
	</table>
	<table class="table" width="100%" style="margin-top:20px">
		<tr>
			<td width="75%"></td>
			<td style="text-align:center"> Jakarta, <?php echo date('d M Y') ?></td>
		</tr>
		<tr >
			<td width="75%"></td>
			<td height="100" style="text-align:center"> ................ </td>
		</tr>
	</table>
</body>
</html>
