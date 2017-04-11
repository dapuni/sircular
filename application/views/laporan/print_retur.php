<!DOCTYPE html>
<html>
<head>
	<?php 
		if (isset($excel)) {
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=Retur_Excel.xls");
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
	<h4>Laporan Data Retur <?php echo $majalah['nama_majalah'].' EDISI '.$edisi['kode_edisi'].' Tanggal '.date('d-m-Y',strtotime($select_startdate)).' - '.date('d-m-Y',strtotime($select_enddate)) ?> </h4>
	<table class="table" style="border:1px solid;" width="100%">
		<tr>
			<th>#</th>
			<th>Kategori</th>
			<th>Kota</th>
			<th>Nama Agent</th>
			<th>Jatah</th>
			<th>Konsinyasi</th>
			<th>Retur</th>
			<th>X</th>
			<th>% Retur</th>
			<th>Laku</th>
			<th>% Laku</th>
			<th>Sub Bagian</th>
			<th>Total</th>
		</tr>
		<tbody>
			<?php
			if (isset($laporan)) {
				$grandjatah = 0;
				$grandkonsinyasi = 0;
				$grandretur = 0;
				$grandjumlahretur = 0;
				$no = 1;
				$nama_agent_cat = '';
				$kota = '';
				$separated_agent_category = '';
				foreach ($laporan as $keylaporan) { 
					
					//total perkategory
					if ($separated_agent_category == '') {
						$separated_agent_category = $keylaporan['agent_category_id'];
					}
					//jika diantara kategory, sisipkan satu line untuk total perkategory
					if ($separated_agent_category != $keylaporan['agent_category_id']) {
						$count_jatah = 0;
						$count_konsinyasi = 0;
						$count_retur = 0;
						$jumlah_retur = 0;
						$distribution_realization_detail_id = 0;
						foreach ($laporan as $keycountlaporan) {
							if ($keycountlaporan['agent_category_id'] == $separated_agent_category) {
								$count_jatah = $count_jatah + $keycountlaporan['quota'];
								$count_konsinyasi = $count_konsinyasi + $keycountlaporan['consigned'];
								$count_retur = $count_retur + $keycountlaporan['jumlah'];
								$jumlah_retur = $jumlah_retur + $keycountlaporan['xretur'];
								$nama_kategori = $keycountlaporan['nama_agent_cat'];
							}
						}
						$persen_return = ($count_jatah == 0 && $count_konsinyasi ==0) ? 0 : round($count_retur/($count_jatah+$count_konsinyasi) * 100,2);
						$total_laku = $count_jatah + $count_konsinyasi - $count_retur;
						$persen_return_all = 100 - $persen_return;
						$grandjatah = $grandjatah + $count_jatah;
						$grandkonsinyasi = $grandkonsinyasi + $count_konsinyasi;
						$grandretur = $grandretur + $count_retur;
						$grandjumlahretur = $grandjumlahretur + $jumlah_retur;
						echo "<tr height='30'>";
							echo "<td colspan=2>Total</td>";
							echo "<td colspan=2>".$nama_kategori."</td>";
							echo "<td style='text-align:center'>".$count_jatah."</td>";
							echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
							echo "<td style='text-align:center'>".$count_retur."</td>";
							echo "<td style='text-align:center'>".$jumlah_retur."</td>";
							echo "<td style='text-align:center'>".$persen_return."</td>";
							echo "<td style='text-align:center'>".$total_laku."</td>";
							echo "<td style='text-align:center'>".number_format($persen_return_all,2,',','.')."</td>";
							echo "<td style='text-align:center'></td>";
							echo "<td style='text-align:center'>".$total_laku."</td>";
						echo "</tr>";
						$separated_agent_category = $keylaporan['agent_category_id'];
					}

					//Detail per kategory
					$total = $keylaporan['quota'] + $keylaporan['consigned'];
					$retur = $keylaporan['jumlah'];
					$laku = $total - $retur;
					$persenjual = ($laku / $total) * 100;
					$persenretur = 100 - $persenjual
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

						if ($kota != $keylaporan['kota']) {
							echo "<td>".$keylaporan['kota']."</td>";
						} else{
							echo "<td></td>";
						}
						?>
						<td><?php echo $keylaporan['nama_agent'] ?></td>
						<td style='text-align:center' ><?php echo $keylaporan['quota'] ?></td>
						<td style='text-align:center' ><?php echo $keylaporan['consigned'] ?></td>
						<td style='text-align:center' ><?php echo $retur ?></td>
						<td style='text-align:center' ><?php echo $keylaporan['xretur'] ?></td>
						<td style='text-align:center' ><?php echo number_format($persenretur,1,',','.') ?></td>
						<td style='text-align:center' ><?php echo $laku ?></td>
						<td style='text-align:center' ><?php echo number_format($persenjual,1,',','.') ?></td>
						<?php 
						$sub_bagian = 0;
						//sub bagian
						if ($kota != $keylaporan['kota']) {
							$kota = $keylaporan['kota'];
							foreach ($laporan as $keysubbagian) {
								if ($kota == $keysubbagian['kota'] && $nama_agent_cat == $keysubbagian['agent_category_id']) {
									$sub_bagian = $sub_bagian + $keysubbagian['jumlah'];
								}
							}
							echo "<td style='text-align:center'>".$sub_bagian."</td>";
							
						} else{
							echo "<td></td>";
						}?>
					</tr>
				<?php } 

				//jika diantara kategory, sisipkan satu line untuk total perkategory untuk kategori terakhir
					$count_jatah = 0;
					$count_konsinyasi = 0;
					$count_retur = 0;
					$jumlah_retur = 0;
					$distribution_realization_detail_id = 0;
					foreach ($laporan as $keycountlaporan) {
						if ($keycountlaporan['agent_category_id'] == $separated_agent_category) {
							$count_jatah = $count_jatah + $keycountlaporan['quota'];
							$count_konsinyasi = $count_konsinyasi + $keycountlaporan['consigned'];
							$count_retur = $count_retur + $keycountlaporan['jumlah'];
							$jumlah_retur = $jumlah_retur + $keycountlaporan['xretur'];
							$nama_kategori = $keycountlaporan['nama_agent_cat'];
						}
					}
					$persen_return = ($count_jatah == 0 && $count_konsinyasi == 0) ? 0 : round($count_retur/($count_jatah+$count_konsinyasi) * 100,2);
					$total_laku = $count_jatah + $count_konsinyasi - $count_retur;
					$persen_return_all = 100 - $persen_return;

					//grand total
					$grandjatah = $grandjatah + $count_jatah;
					$grandkonsinyasi = $grandkonsinyasi + $count_konsinyasi;
					$grandretur = $grandretur + $count_retur;
					$grandjumlahretur = $grandjumlahretur + $jumlah_retur;
					$grand_persen_retur = ($grandjatah == 0 && $grandkonsinyasi == 0) ? 0 : round($grandretur/($grandjatah+$grandkonsinyasi) * 100,2);
					$grandlaku = $grandjatah + $grandkonsinyasi - $grandretur;
					$grand_persen_laku = 100 - $grand_persen_retur;

					echo "<tr height='30'>";
						echo "<td colspan=2>Total</td>";
						echo "<td colspan=2>".$nama_kategori."</td>";
						echo "<td style='text-align:center'>".$count_jatah."</td>";
						echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
						echo "<td style='text-align:center'>".$count_retur."</td>";
						echo "<td style='text-align:center'>".$jumlah_retur."</td>";
						echo "<td style='text-align:center'>".$persen_return."</td>";
						echo "<td style='text-align:center'>".$total_laku."</td>";
						echo "<td style='text-align:center'>".number_format($persen_return_all,2,',','.')."</td>";
						echo "<td style='text-align:center'></td>";
						echo "<td style='text-align:center'>".$total_laku."</td>";
					echo "</tr>";

					//Grand Total
					echo "<tr height='30'>";
						echo "<td colspan=4> Grand Total</td>";
						echo "<td style='text-align:center'>".$grandjatah."</td>";
						echo "<td style='text-align:center'>".$grandkonsinyasi."</td>";
						echo "<td style='text-align:center'>".$grandretur."</td>";
						echo "<td style='text-align:center'>".$grandjumlahretur."</td>";
						echo "<td style='text-align:center'>".$grand_persen_retur."</td>";
						echo "<td style='text-align:center'>".$grandlaku."</td>";
						echo "<td style='text-align:center'>".$grand_persen_laku."</td>";
						echo "<td style='text-align:center'></td>";
						echo "<td style='text-align:center'>".$grandlaku."</td>";
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
