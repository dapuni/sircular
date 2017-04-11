<fieldset>
	<legend>Laporan Data Penerbit</legend>
	<div class="col-xs-12 ">
		<a class="btn btn-default" onclick="popWindow()"> <i class="fa fa-print"></i> Print As HTML</a>
		<a class="btn btn-default" href="laporan/penerbit/pdf" target="_blank"> <i class="fa fa-file-pdf-o"></i> Print As PDF</a>
		<a href="laporan/penerbit/export" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Excel</a>
	</div>
	
	<table class="table">
		<thead>
			<th>#</th>
			<th>Penerbit</th>
			<th>NPWP</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>Majalah</th>
		</thead>
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
</fieldset>
<script type="text/javascript">
	function popWindow() {
	    var newWindow = window.open("<?php echo base_url()?>laporan/penerbit/cetak", "", "width=400, height=500");
	}
</script>