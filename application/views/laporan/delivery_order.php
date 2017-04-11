<fieldset>
	<legend>Laporan Data DO</legend>
	<form action="<?php echo base_url()?>laporan/delivery_order" method="get">
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
			<th>Tanggal</th>
			<th>DO#</th>
			<th>Nama Agent</th>
			<th>Jatah</th>
			<th>Konsinyasi</th>
			<th>Gratis</th>
			<th>Total</th>
		</thead>
		<tbody>
			<?php
			$nama_agent = ''; $no = 1;
			foreach ($laporan as $agent) 
			{ 
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
					<td><?php echo $agent['quota'] ?></td>
					<td><?php echo $agent['consigned'] ?></td>
					<td><?php echo $agent['gratis'] ?></td>
					<td><?php echo $agent['quota'] + $agent['consigned'] + $agent['gratis'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</fieldset>
<script type="text/javascript">
	$(function(){
		//For auto select
		$("#majalah").change(function()
		{
		    document.location.href ="<?php echo base_url();?>laporan/delivery_order?majalah="+$('#majalah').val();
		});
		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>

		//select PDF or EXCEL
		$('#cetak').click(function(){
			window.open("<?php echo base_url();?>laporan/delivery_order/cetak?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val(), "", "width=400, height=500");
		});

		$('#pdf').click(function(){
			window.open("<?php echo base_url();?>laporan/delivery_order/pdf?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val());
		});

		$('#excel').click(function(){
			document.location.href ="<?php echo base_url();?>laporan/delivery_order/excel?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val();
		});
	});
</script>