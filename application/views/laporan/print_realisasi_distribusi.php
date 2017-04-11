<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php 
		if (isset($excel)) {
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=Realisasi Distribusi.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
	?>
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
	<h4>Laporan Realisasi Distribusi <?php echo $majalah['nama_majalah'].' EDISI '.$edisi['kode_edisi'] ?></h4>
	<table class="table" style="border : 1px solid" width="100%">
		<tr>
			<th style="border-bottom: 1px solid black;">#</th>
			<th style="border-bottom: 1px solid black;">Kategori</th>
			<th style="border-bottom: 1px solid black;">Kota</th>
			<th style="border-bottom: 1px solid black;">Nama Agent</th>
			<th style="border-bottom: 1px solid black;">Kirim Lama</th>
			<th style="border-bottom: 1px solid black;">Mutasi</th>
			<th style="border-bottom: 1px solid black;">Jatah</th>
			<th style="border-bottom: 1px solid black;">Konsinyasi</th>
			<th style="border-bottom: 1px solid black;">Gratis</th>
			<th style="border-bottom: 1px solid black;">Total</th>
			<th style="border-bottom: 1px solid black;">Sub Bagian</th>
			<th style="border-bottom: 1px solid black;">Total</th>
		</tr>
				<tbody>
		<?php
			$no = 1;
			$nama_agent_cat = '';
			$agent_cat_id = '';
			$kota = '';
			$kota_2 = '';
			$total_percategory = '';
			$total_jatah = 0;
			$total_konsinyasi = 0;
			$total_gratis = 0;
			foreach ($agent as $detail_agent) 
			{
				$agent_id = '';
				$prev_quota = 0;
				$jatah = 0;
				$konsinyasi = 0;
				$gratis = 0;
				$mutasi = 0;
				foreach ($laporan as $laporanx) 
				{
					//total
					if ($total_percategory == '' || $total_percategory == $laporanx['agent_category_id']) {
						$total_percategory = $laporanx['agent_category_id'];
						$nama_category = $laporanx['nama_agent_cat'];
					}

					if ($total_percategory != $detail_agent['agent_category_id'] && $detail_agent['agent_category_id'] == $laporanx['agent_category_id']) {
							$total_jatah = 0;
							$total_konsinyasi = 0;
							$total_gratis = 0;
							foreach ($laporan as $keylaporan) 
							{
								if ($keylaporan['agent_category_id'] == $total_percategory) {
									$total_jatah = $total_jatah + $keylaporan['quota'];
									$total_konsinyasi = $total_konsinyasi + $keylaporan['consigned'];
									$total_gratis = $total_gratis + $keylaporan['gratis'];
								}
							}
							echo "<tr>";
								echo "<td colspan=3>Total</td>";
								echo "<td colspan=3>".$nama_category."</td>";
								echo "<td style='text-align:center'>".$total_jatah."</td>";
								echo "<td style='text-align:center'>".$total_konsinyasi."</td>";
								echo "<td style='text-align:center'>".$total_gratis."</td>";
								echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi)."</td>";
								echo "<td style='text-align:center'></td>";
								echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi)."</td>";
							echo "</tr>";
							$total_percategory = $detail_agent['agent_category_id'];
						}

					if ($laporanx['agent_id']  == $detail_agent['agent_id'] && $agent_id != $laporanx['agent_id']) 
					{
						$agent_id = $laporanx['agent_id'];
						$cat_id = $laporanx['agent_category_id'];
						$total_jatah = 0;
						$total_konsinyasi = 0;
						$total_gratis = 0;
						echo "<tr>";
							echo "<td>".$no++."</td>";
							
							if ($nama_agent_cat != $laporanx['agent_category_id']) {
								echo "<td>".$laporanx['nama_agent_cat']."</td>";
								$nama_agent_cat = $laporanx['agent_category_id'];
							} else{
								echo "<td></td>";
							}
							
							if ($kota != $laporanx['name']) {
								echo "<td>".$laporanx['name']."</td>";
								$kota = $laporanx['name'];
							} else{
								echo "<td></td>";
							}

							echo "<td>".$laporanx['nama_agent']."</td>";
							
							//Kirim Lama
							foreach ($prev_laporan as $prev_laporanx) 
							{
								if ($prev_laporanx['agent_id'] == $agent_id) 
								{
									$prev_quota = $prev_quota + $prev_laporanx['quota'] + $prev_laporanx['consigned'] + $prev_laporanx['gratis'];
								}
							}
							echo "<td style='text-align:center'>".$prev_quota."</td>";

							//Mutasi
							foreach ($laporan as $laporany) 
							{
								if ($agent_id == $laporany['agent_id']) 
								{
									$jatah = $jatah + $laporany['quota'];
									$konsinyasi = $konsinyasi + $laporany['consigned'];
									$gratis = $gratis + $laporany['gratis'];
								}

								if ($cat_id == $laporany['agent_category_id']) {
									$total_jatah = $total_jatah + $laporany['quota'];
									$total_konsinyasi = $total_konsinyasi + $laporany['consigned'];
									$total_gratis = $total_gratis + $laporany['gratis'];
								}
							}
							echo "<td style='text-align:center'>".(($jatah + $konsinyasi) - $prev_quota )."</td>";
							echo "<td style='text-align:center'>".$jatah."</td>";
							echo "<td style='text-align:center'>".$konsinyasi."</td>";
							echo "<td style='text-align:center'>".$gratis."</td>";
							echo "<td style='text-align:center'>".($jatah + $konsinyasi)."</td>";

							//Sub Bagian
							if ($kota_2 != $laporanx['name'] || $agent_cat_id != $laporanx['agent_category_id'] ) 
							{
								$sub_bagian = 0;
								foreach ($laporan as $count_laporan) 
								{
									if ($laporanx['name'] == $count_laporan['name'] && $laporanx['agent_category_id'] == $count_laporan['agent_category_id']) 
									{
										$sub_bagian = $sub_bagian + $count_laporan['quota'] + $count_laporan['consigned'];
									}
								}
								echo "<td style='text-align:center'>".$sub_bagian."</td>";
								$kota_2 = $laporanx['name'];
								$agent_cat_id = $laporanx['agent_category_id'];
							} else{
								echo "<td></td>";
							}
						echo "</tr>";
					}
				}
			}
			echo "<tr>";
				echo "<td colspan=5>Total</td>";
				echo "<td></td>";
				echo "<td style='text-align:center'>".$total_jatah."</td>";
				echo "<td style='text-align:center'>".$total_konsinyasi."</td>";
				echo "<td style='text-align:center'>".$total_gratis."</td>";
				echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi)."</td>";
				echo "<td style='text-align:center'></td>";
				echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi)."</td>";
			echo "</tr>";
		?>
		</tbody>
	</table>
	<footer style="page-break-after:always;"></footer>
	<h4  style="padding-top:15px;">Rekapitulasi Data Realisasi Distribusi <?php echo $majalah['nama_majalah'].' EDISI '.$edisi['kode_edisi'] ?></h4>
	<table class="table" style="border:1px solid;" width="100%">
		<tr>
			<th style="border-bottom: 1px solid black;">#</th>
			<th style="border-bottom: 1px solid black;">Kategori</th>
			<th style='text-align:center; border-bottom: 1px solid black;'>Jatah</th>
			<th style='text-align:center; border-bottom: 1px solid black;'>Konsinyasi</th>
			<th style='text-align:center; border-bottom: 1px solid black;'>Gratis</th>
			<th style='text-align:center; border-bottom: 1px solid black;'>Total</th>
		</tr>
		<tbody>
			<?php
				if (isset($laporan)) {
					$no = 1;
					$agent_cat = '';
					$kota = '';
					$nama_agent = '';
					$total_jatah = 0;
					$total_konsinyasi = 0;
					$total_gratis = 0;
					$all_total = 0;
					foreach ($laporan as $laporan_rekapitulasi) 
					{ 
						$print = $laporan_rekapitulasi['print'];
						if ($agent_cat != $laporan_rekapitulasi['agent_category_id']) 
						{
							$agent_cat = $laporan_rekapitulasi['agent_category_id'];
							echo "<tr>";
								echo "<td>".$no++."</td>";
								echo "<td>".$laporan_rekapitulasi['nama_agent_cat']."</td>";
								$jatah = 0; $konsinyasi = 0; $total = 0; $gratis = 0;
								foreach ($laporan as $key_laporan) 
								{
									if ($agent_cat == $key_laporan['agent_category_id']) 
									{
										$jatah = $jatah + $key_laporan['quota'];
										$konsinyasi = $konsinyasi + $key_laporan['consigned'];
										$gratis = $gratis + $key_laporan['gratis'];
									}
								}

								$total = $jatah + $konsinyasi + $gratis;
								$total_jatah = $total_jatah + $jatah;
								$total_konsinyasi = $total_konsinyasi + $konsinyasi;
								$total_gratis = $total_gratis + $gratis;
								$all_total = $total_jatah + $total_konsinyasi + $total_gratis;
								echo "<td style='text-align:center'>".$jatah."</td>";
								echo "<td style='text-align:center'>".$konsinyasi."</td>";
								echo "<td style='text-align:center'>".$gratis."</td>";
								echo "<td style='text-align:center'>".$total."</td>";
							echo "</tr>";
						} 
					}
					echo "<tr>";
						echo "<td colspan='2'>Grand Total</td>";
						echo "<td style='text-align:center'>".$total_jatah."</td>";
						echo "<td style='text-align:center'>".$total_konsinyasi."</td>";
						echo "<td style='text-align:center'>".$total_gratis."</td>";
						echo "<td style='text-align:center'>".$all_total."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td colspan='5'>Total Print</td>";
						echo "<td style='text-align:center'>".$print."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td colspan='5'>Stock</td>";
						echo "<td style='text-align:center'>".($print - $all_total)."</td>";
					echo "</tr>";
				} ?>
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