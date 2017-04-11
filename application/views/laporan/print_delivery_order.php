<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php 
		if (isset($excel)) {
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=Rekapitulasi DO.xls");
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
	<h4>Laporan Rekapitulasi DO <?php echo $nama_majalah['nama_majalah'].' '.$kode_edisi['kode_edisi'] ?></h4>
	<table class="table" style="border : 1px solid;" width="100%">
		<tr>
			<th style="border-bottom: 1px solid black;">#</th>
			<th style="border-bottom: 1px solid black;">Tanggal DO</th>
			<th style="border-bottom: 1px solid black;">DO#</th>
			<th style="border-bottom: 1px solid black;">Nama Agent</th>
			<th style="border-bottom: 1px solid black;">Jatah</th>
			<th style="border-bottom: 1px solid black;">Konsinyasi</th>
			<th style="border-bottom: 1px solid black;">Gratis</th>
			<th style="border-bottom: 1px solid black;">Total</th>
		</tr>
		<tbody>
			<?php if (isset($laporan)) 
		{
			$nama_agent = ''; 
			$no = 1;
			$total_jatah = 0;
			$total_konsinyasi = 0;
			$total_gratis = 0;
			foreach ($laporan as $agent) 
			{ 
				$total_jatah = $total_jatah + $agent['quota'];
				$total_konsinyasi = $total_konsinyasi + $agent['consigned'];
				$total_gratis = $total_gratis + $agent['gratis'];
				$totalprint = $agent['print'];
				?>
				<tr>
					<td><?php echo $no; $no++; ?></td>
					<td><?php echo date('d/m/Y',strtotime($agent['date_created'])) ?></td>
					<td><?php echo date('y',strtotime($agent['date_created']))."/".$agent['nama_majalah']."/0".$agent['distribution_realization_detail_id'] ?></td>
					<?php 
						if ($nama_agent != $agent['nama_agent']) 
						{
							echo "<td>".$agent['nama_agent']."</td>";
							$nama_agent = $agent['nama_agent'];
						} else {
							echo "<td></td>";
						}
					?>
					<td style='text-align:center'><?php echo $agent['quota'] ?></td>
					<td style='text-align:center'><?php echo $agent['consigned'] ?></td>
					<td style='text-align:center'><?php echo $agent['gratis'] ?></td>
					<td style='text-align:center'><?php echo $agent['quota'] + $agent['consigned'] + $agent['gratis'] ?></td>
				</tr>
			<?php }
			echo "<tr>";
				echo "<td colspan=4>Total</td>";
				echo "<td style='text-align:center'>".$total_jatah."</td>";
				echo "<td style='text-align:center'>".$total_konsinyasi."</td>";
				echo "<td style='text-align:center'>".$total_gratis."</td>";
				echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi + $total_gratis)."</td>";
			echo "</tr>";	
			echo "<tr>";
				echo "<td colspan=7>Total Print</td>";
				echo "<td style='text-align:center'>".$totalprint."</td>";
			echo "</tr>";	
			echo "<tr>";
				echo "<td colspan=7>Stock</td>";
				echo "<td style='text-align:center'>".($totalprint - ($total_jatah + $total_konsinyasi + $total_gratis))."</td>";
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