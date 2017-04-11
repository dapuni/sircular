<!DOCTYPE html>
<html>
<head>
	<?php 
		if (isset($excel)) {
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=Penjualan Perkota.xls");
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
	<h4>Laporan Data Penjualan Per Kota <?php echo $majalah['nama_majalah'].' EDISI '.$edisi['kode_edisi'] ?></h4>
	<table class="table" style="border:1px solid;" width="100%">
		<tr>
			<th style="border-bottom: 1px solid black;">#</th>
			<th style="border-bottom: 1px solid black;">Kategori</th>
			<th style="border-bottom: 1px solid black;">Kota</th>
			<th style='border-bottom: 1px solid black;text-align:center'>Jatah</th>
			<th style='border-bottom: 1px solid black;text-align:center'>Konsinyasi</th>
			<th style='border-bottom: 1px solid black;text-align:center'>Retur</th>
			<th style='border-bottom: 1px solid black;text-align:center'>Laku</th>
			<th style='border-bottom: 1px solid black;text-align:center'>% Laku</th>
		</tr>
		<tbody>
			<?php
				if (isset($laporan)) {
					$kategori = '';
					$kota = '';
					$no = 1;
					$nama_agent_cat = '';
					$pemisah = '';
					foreach ($laporan as $keylaporan) {
						//pemisah perkategori dan kota
						if ($kategori != $keylaporan['agent_category_id'] || $kota != $keylaporan['name']) {
							$kategori = $keylaporan['agent_category_id'];
							$kota = $keylaporan['name'];
							$quota = 0;
							$consigned = 0;
							$retur = 0;

							//Total per kategori
							if ($pemisah != $keylaporan['nama_agent_cat'] && $pemisah != '') {
								$count_jatah = 0;
								$count_konsinyasi = 0;
								$count_retur = 0;
								
								//hitung perkategori
								foreach ($laporan as $keycount) {
									if ($pemisah_kategori == $keycount['agent_category_id']) {
										$count_jatah = $count_jatah + $keycount['quota'];
										$count_konsinyasi = $count_konsinyasi + $keycount['consigned'];
										$count_retur = $count_retur + $keycount['retur'];
									}
								}

								//menghitung persentase
								$laku = $count_jatah + $count_konsinyasi - $count_retur;
								$persenlaku = ($laku == 0 ) ? 0 : $laku / ($count_jatah + $count_konsinyasi) * 100;

								echo "<tr>";
									echo "<td colspan=2>Total</td>";
									echo "<td >".$pemisah."</td>";
									echo "<td style='text-align:center'>".$count_jatah."</td>";
									echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
									echo "<td style='text-align:center'>".$count_retur."</td>";
									echo "<td style='text-align:center'>".$laku."</td>";
									echo "<td style='text-align:center'>".number_format($persenlaku,1,',','.')."</td>";
								echo "</tr>";
							}

							//menghitung jumlah data perkota
							foreach ($laporan as $keykota) {
								if ($kategori == $keykota['agent_category_id'] && $kota == $keykota['name']) {
									$quota = $quota + $keykota['quota'];
									$consigned = $consigned + $keykota['consigned'];
									$retur = $retur + $keykota['retur'];
								}
							}

							//menghitung persentase
							$laku = $quota + $consigned - $retur;
							$persenlaku = ($laku == 0 ) ? 0 : $laku / ($quota + $consigned) * 100;

							//Tampilan kedalam table
							echo "<tr>";
								echo "<td>".$no++."</td>";

								if ($nama_agent_cat != $keylaporan['nama_agent_cat']) {
									echo "<td>".$keylaporan['nama_agent_cat']."</td>";
									$nama_agent_cat = $keylaporan['nama_agent_cat'];
								} else {
									echo "<td></td>";
								}
								
								echo "<td>".$keylaporan['name']."</td>";
								echo "<td style='text-align:center' >".$quota."</td>";
								echo "<td style='text-align:center'>".$consigned."</td>";
								echo "<td style='text-align:center'>".$retur."</td>";
								echo "<td style='text-align:center'>".$laku."</td>";
								echo "<td style='text-align:center'>".number_format($persenlaku,1,',','.')."</td>";
							echo "</tr>";

							//pemisah antar kategori
							$pemisah_kategori = $keylaporan['agent_category_id'];
							$pemisah = $keylaporan['nama_agent_cat'];
						}
					}
					//untuk total perkategori terakhir
					$count_jatah = 0;
					$count_konsinyasi = 0;
					$count_retur = 0;
					
					//hitung perkategori
					foreach ($laporan as $keycount) {
						if ($pemisah_kategori == $keycount['agent_category_id']) {
							$count_jatah = $count_jatah + $keycount['quota'];
							$count_konsinyasi = $count_konsinyasi + $keycount['consigned'];
							$count_retur = $count_retur + $keycount['retur'];
						}
					}

					//menghitung persentase
					$laku = $count_jatah + $count_konsinyasi - $count_retur;
					$persenlaku = ($laku == 0 ) ? 0 : $laku / ($count_jatah + $count_konsinyasi) * 100;

					echo "<tr>";
						echo "<td colspan=2>Total</td>";
						echo "<td >".$pemisah."</td>";
						echo "<td style='text-align:center'>".$count_jatah."</td>";
						echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
						echo "<td style='text-align:center'>".$count_retur."</td>";
						echo "<td style='text-align:center'>".$laku."</td>";
						echo "<td style='text-align:center'>".number_format($persenlaku,1,',','.')."</td>";
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
