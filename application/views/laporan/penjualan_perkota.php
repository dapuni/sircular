<fieldset>
	<legend>Laporan Penjualan Perkota</legend>
	<form action="<?php echo base_url()?>laporan/penjualan_perkota" method="get">
		<div class="col-xs-3">
			<select class="form-control" name="majalah" id="majalah">
		    	<option value="0">---</option>
		   		<?php 
	    			foreach ($majalah as $majalahx) 
	    			{ ?>
	    				<option value="<?php echo $majalahx['majalah_id']?>"><?php echo $majalahx['nama_majalah']?></option>
	    			<?php }
	    		?>
	        </select>
		</div>
		<div class="col-xs-3">
			<select class="form-control" name="edisi" id="edisi">
		    	<option value="0">---</option>
		    	<?php
		    		if ($edisi) {
		    			foreach ($edisi as $edisix) { ?>
		    				<option value="<?php echo $edisix['edisi_id']?>"><?php echo $edisix['kode_edisi']?></option>
		    			<?php }
		    		}
		    	?>
		    </select>
		</div>
		<div class="col-xs-6">
			<button type="submit" class="btn btn-default">Cari</button>
			<a id="cetak" class="btn btn-default"><i class="fa fa-print"></i> HTML</a>
			<a id="pdf" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> PDF</a>
			<a id="excel" class="btn btn-default"> <i class="fa fa-file-excel-o"></i> Excel</a>
		</div>	
	</form>
	<table class="table">
		<thead>
			<th>#</th>
			<th>Kategori</th>
			<th>Kota</th>
			<th style='text-align:center'>Jatah</th>
			<th style='text-align:center'>Konsinyasi</th>
			<th style='text-align:center'>Retur</th>
			<th style='text-align:center'>Laku</th>
			<th style='text-align:center'>% Laku</th>
		</thead>
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
</fieldset>
<script type="text/javascript">
	$(function(){
		//For auto select
		$("#majalah").change(function()
		{
		    document.location.href ="<?php echo base_url();?>laporan/penjualan_perkota?majalah="+$('#majalah').val();
		});
		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>

		//select PDF or EXCEL
		$('#cetak').click(function(){
			window.open("<?php echo base_url();?>laporan/penjualan_perkota/cetak?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val(), "", "width=400, height=500");
		});

		$('#pdf').click(function(){
			window.open("<?php echo base_url();?>laporan/penjualan_perkota/pdf_retur?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val(), "");
		});

		$('#excel').click(function(){
			document.location.href ="<?php echo base_url();?>laporan/penjualan_perkota/excel?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val();
		});
	});
</script>