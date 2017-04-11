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
			<th>Nama Agent</th>
			<th>Majalah</th>
			<th>Edisi</th>
			<th>Nomor Retur</th>
			<th>Tanggal Retur</th>
			<th>Jumlah Retur</th>
			<th>Total</th>
		</tr>
		<tbody>
			<?php $no = 1; $total = 0;if (isset($laporan)) { 
				foreach ($laporan as $keylaporan) { 
					$total = $total + $keylaporan['jumlah'];
					?>
					<tr>
						<td><?php  echo $no++; ?></td>
						<td><?php  echo $keylaporan['nama_agent']; ?></td>
						<td><?php  echo $keylaporan['nama_majalah']; ?></td>
						<td><?php  echo $keylaporan['kode_edisi']; ?></td>
						<td><?php  echo $keylaporan['no_return']; ?></td>
						<td><?php  echo date('d-m-Y',strtotime($keylaporan['return_date'])); ?></td>
						<td style="text-align:center"><?php  echo $keylaporan['jumlah']; ?></td>
					</tr>
				<?php }
			} ?>
			<tr>
				<td colspan="7">Total</td>
				<td style="text-align:center"> <?php  echo $total ?></td>
			</tr>
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
