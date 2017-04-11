<fieldset>
	<legend>Laporan Data Retur</legend>
	<form action="<?php echo base_url()?>laporan/retur" method="get">
		<div class="col-xs-2">
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
		<div class="col-xs-2">
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
		<div class="col-xs-2">
			<input type="text" class="form-control date" name="startdate" id="startdate" value="<?php echo $select_startdate ?>">
		</div>
		<div class="col-xs-2">
			<input type="text" class="form-control date" name="enddate" id="enddate" value="<?php echo $select_enddate ?>">
		</div>
		<div class="col-xs-4">
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
		</thead>
		<tbody>
			<?php
			if (isset($laporan)) {
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
							}
						}
						$persen_return = ($count_jatah == 0 && $count_konsinyasi ==0) ? 0 : round($count_retur/($count_jatah+$count_konsinyasi) * 100,2);
						$total_laku = $count_jatah + $count_konsinyasi - $count_retur;
						$persen_return_all = 100 - $persen_return;
						echo "<tr>";
							echo "<td colspan=3>Total</td>";
							echo "<td></td>";
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
						}
					}
					$persen_return = ($count_jatah == 0 && $count_konsinyasi ==0) ? 0 : round($count_retur/($count_jatah+$count_konsinyasi) * 100,2);
					$total_laku = $count_jatah + $count_konsinyasi - $count_retur;
					$persen_return_all = 100 - $persen_return;
					echo "<tr>";
						echo "<td colspan=3>Total</td>";
						echo "<td></td>";
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
		    document.location.href ="<?php echo base_url();?>laporan/retur?majalah="+$('#majalah').val();
		});
		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>

		//select PDF or EXCEL
		$('#cetak').click(function(){
			window.open("<?php echo base_url();?>laporan/retur/cetak?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&startdate="+$('#startdate').val()+"&enddate="+$('#enddate').val(), "", "width=400, height=500");
		});

		$('#pdf').click(function(){
			window.open("<?php echo base_url();?>laporan/retur/pdf_retur?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&startdate="+$('#startdate').val()+"&enddate="+$('#enddate').val(), "");
		});

		$('#excel').click(function(){
			document.location.href ="<?php echo base_url();?>laporan/retur/excel?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&startdate="+$('#startdate').val()+"&enddate="+$('#enddate').val(), "";
		});
	});
</script>