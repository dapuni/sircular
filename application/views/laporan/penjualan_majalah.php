<fieldset>
	<legend>Laporan Penjualan Majalah</legend>
	<form action="<?php echo base_url()?>laporan/penjualan_majalah" method="get">
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
			<button type="submit" class="btn btn-default" id="cari">Cari</button>
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
			<th>Nama Agent</th>
			<th style='text-align:center' >Jatah</th>
			<th style='text-align:center'>Konsinyasi</th>
			<th style='text-align:center' >Total</th>
			<th style='text-align:center'>Retur</th>
			<th style='text-align:center'>Laku</th>
			<th style='text-align:center'>% Laku</th>
			<th style='text-align:right'>SubOmzet</th>
		</thead>
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
								$count_retur = $count_retur + $keycountlaporan['retur'];
								$sum_total_retur = $sum_total_retur + ($keycountlaporan['retur'] * $keycountlaporan['harga']) * ((100 - $keycountlaporan['disc_total'])/100);
							}
						}

						$sum_total = $count_jatah + $count_konsinyasi;
						$sum_laku = $sum_total - $count_retur;
						$persenlaku = ($sum_total != 0) ? $sum_laku / $sum_total * 100 : 0 ; 

						echo "<tr>";
							echo "<td colspan=3>Total</td>";
							echo "<td></td>";
							echo "<td style='text-align:center'>".$count_jatah."</td>";
							echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
							echo "<td style='text-align:center'>".$sum_total."</td>";
							echo "<td style='text-align:center'>".$count_retur."</td>";
							echo "<td style='text-align:center'>".$sum_laku."</td>";
							echo "<td style='text-align:center'>".number_format($persenlaku,2,'.','.')."</td>";
							echo "<td style='text-align:right'>".number_format(($sum_total_omset - $sum_total_retur),0,'.','.')."</td>";
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
						<td style='text-align:right'><?php echo number_format($Subomzet,0,',','.') ?></td>

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
						}
					}

					$sum_total = $count_jatah + $count_konsinyasi;
					$sum_laku = $sum_total - $count_retur;
					$persenlaku = ($sum_total != 0) ? $sum_laku / $sum_total * 100 : 0;

					echo "<tr>";
						echo "<td colspan=3>Total</td>";
						echo "<td></td>";
						echo "<td style='text-align:center'>".$count_jatah."</td>";
						echo "<td style='text-align:center'>".$count_konsinyasi."</td>";
						echo "<td style='text-align:center'>".$sum_total."</td>";
						echo "<td style='text-align:center'>".$count_retur."</td>";
						echo "<td style='text-align:center'>".$sum_laku."</td>";
						echo "<td style='text-align:center'>".number_format($persenlaku,2,'.','.')."</td>";
						echo "<td style='text-align:right'>".number_format($sum_total_omset,0,'.','.')."</td>";
					echo "</tr>";
			}
			
		?>
		</tbody>
	</table>
</fieldset>
<script type="text/javascript">
	$(function(){

		$('#cari').click(function(){
			var valueB = $('#edisi').val();
			if (valueB == 0) {
				return false;
			} else {
				return true;
			}
		});

		//For auto select
		$("#majalah").change(function()
		{
		    document.location.href ="<?php echo base_url();?>laporan/penjualan_majalah?majalah="+$('#majalah').val();
		});
		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>

		//select PDF or EXCEL
		$('#cetak').click(function(){
			window.open("<?php echo base_url();?>laporan/penjualan_majalah/cetak?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val(), "", "width=400, height=500");
		});

		$('#pdf').click(function(){
			window.open("<?php echo base_url();?>laporan/penjualan_majalah/pdf_retur?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val(), "");
		});

		$('#excel').click(function(){
			document.location.href ="<?php echo base_url();?>laporan/penjualan_majalah/excel?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val();
		});
	});
</script>