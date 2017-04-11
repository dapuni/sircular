<fieldset>
	<legend>Laporan Data Rencana Distribusi</legend>
	<form action="<?php echo base_url()?>laporan/rencana_distribusi" method="get">
		<div class="col-xs-3 form-group">
			<label>Magazine</label>
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
		<div class="col-xs-3 form-group">
			<label>Previous Edition</label>
			<select class="form-control" name="prev_edisi" id="prev_edisi">
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
		<div class="col-xs-3 form-group">
			<label>Edition</label>
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
		<div class="col-xs-3" style="margin-top:25px;">
			<button type="submit" class="btn btn-default"> Cari</button>
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
			<th>Kirim Lama</th>
			<th>Mutasi</th>
			<th>Jatah</th>
			<th>Konsinyasi</th>
			<th>Gratis</th>
			<th>Total</th>
			<th>Sub Bagian</th>
			<th>Total</th>
		</thead>
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
								echo "<td colspan=5>Total</td>";
								echo "<td></td>";
								echo "<td style='text-align:center'>".$total_jatah."</td>";
								echo "<td style='text-align:center'>".$total_konsinyasi."</td>";
								echo "<td style='text-align:center'>".$total_gratis."</td>";
								echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi + $total_gratis)."</td>";
								echo "<td style='text-align:center'></td>";
								echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi + $total_gratis)."</td>";
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
							echo "<td style='text-align:center'>".(($jatah + $konsinyasi + $gratis) - $prev_quota )."</td>";
							echo "<td style='text-align:center'>".$jatah."</td>";
							echo "<td style='text-align:center'>".$konsinyasi."</td>";
							echo "<td style='text-align:center'>".$gratis."</td>";
							echo "<td style='text-align:center'>".($jatah + $konsinyasi + $gratis)."</td>";

							//Sub Bagian
							if ($kota_2 != $laporanx['name'] || $agent_cat_id != $laporanx['agent_category_id'] ) 
							{
								$sub_bagian = 0;
								foreach ($laporan as $count_laporan) 
								{
									if ($laporanx['name'] == $count_laporan['name'] && $laporanx['agent_category_id'] == $count_laporan['agent_category_id']) 
									{
										$sub_bagian = $sub_bagian + $count_laporan['quota'] + $count_laporan['consigned'] + $count_laporan['gratis'];
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
				echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi + $total_gratis)."</td>";
				echo "<td style='text-align:center'></td>";
				echo "<td style='text-align:center'>".($total_jatah + $total_konsinyasi + $total_gratis)."</td>";
			echo "</tr>";
		?>
		</tbody>
	</table>
</fieldset>
<script type="text/javascript">
	$(function(){
		//For auto select
		$("#majalah").change(function()
		{
		    document.location.href ="<?php echo base_url();?>laporan/rencana_distribusi?majalah="+$('#majalah').val();
		});
		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>
		<?php echo (isset($select_prev_edisi))?"$('#prev_edisi').val(".$select_prev_edisi.");":''?>

		//select PDF or EXCEL
		$('#cetak').click(function(){
			window.open("<?php echo base_url();?>laporan/rencana_distribusi/cetak?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&prev_edisi="+$('#prev_edisi').val(), "", "width=400, height=500");
		});

		$('#pdf').click(function(){
			window.open("<?php echo base_url();?>laporan/rencana_distribusi/pdf?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&prev_edisi="+$('#prev_edisi').val(), "");
		});

		$('#excel').click(function(){
			document.location.href ="<?php echo base_url();?>laporan/rencana_distribusi/excel?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&prev_edisi="+$('#prev_edisi').val();
		});
	});
</script>