<fieldset>
	<legend>Laporan Data Retur</legend>
	<form action="<?php echo base_url()?>laporan/retur_permajalah" method="get">
	<div class="col-xs-8">
		<div class="col-xs-3 input-group-sm">
			<select class="form-control" name="majalah" id="majalah">
		    	<option value="">---</option>
		   		<?php 
	    			foreach ($majalah as $majalahx) 
	    			{ ?>
	    				<option value="<?php echo $majalahx['majalah_id']?>"><?php echo $majalahx['nama_majalah']?></option>
	    			<?php }
	    		?>
	        </select>
		</div>
		<div class="col-xs-3 input-group-sm">
			<select class="form-control" name="edisi" id="edisi">
		    	<option value="">---</option>
		    	<?php
		    		if ($edisi) {
		    			foreach ($edisi as $edisix) { ?>
		    				<option value="<?php echo $edisix['edisi_id']?>"><?php echo $edisix['kode_edisi']?></option>
		    			<?php }
		    		}
		    	?>
		    </select>
		</div>
		<div class="col-xs-2 input-group-sm">
			<select class="form-control" name="agent" id="agent">
		    	<option value="">---</option>
		    	<?php
		    		if ($agent) {
		    			foreach ($agent as $agentx) { ?>
		    				<option value="<?php echo $agentx['agent_id']?>"><?php echo $agentx['nama_agent']?></option>
		    			<?php }
		    		}
		    	?>
		    </select>
		</div>
		<div class="col-xs-2 input-group-sm">
			<input type="text" class="form-control date" name="startdate" id="startdate" value="<?php echo $select_startdate ?>">
		</div>
		<div class="col-xs-2 input-group-sm">
			<input type="text" class="form-control date" name="enddate" id="enddate" value="<?php echo $select_enddate ?>">
		</div>
	</div>
		
		<div class="col-xs-4 btn-group btn-group-sm">
			<button type="submit" class="btn btn-default">Cari</button>
			<a id="cetak" class="btn btn-default"><i class="fa fa-print"></i> HTML</a>
			<a id="pdf" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> PDF</a>
			<a id="excel" class="btn btn-default"> <i class="fa fa-file-excel-o"></i> Excel</a>
		</div>	
	</form>
	<table class="table">
		<thead>
			<th>#</th>
			<th>Nama Agent</th>
			<th>Majalah</th>
			<th>Edisi</th>
			<th>Nomor Retur</th>
			<th>Tanggal Retur</th>
			<th>Jumlah Retur</th>
			<th>Total</th>
		</thead>
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
</fieldset>
<script type="text/javascript">
	$(function(){
		//For auto select
		$("#majalah").change(function()
		{
		    document.location.href ="<?php echo base_url();?>laporan/retur_permajalah?majalah="+$('#majalah').val();
		});
		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_edisi))?"$('#edisi').val(".$select_edisi.");":''?>
		<?php echo (isset($select_agent))?"$('#agent').val(".$select_agent.");":''?>

		//select PDF or EXCEL
		$('#cetak').click(function(){
			window.open("<?php echo base_url();?>laporan/retur_permajalah/cetak?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&startdate="+$('#startdate').val()+"&enddate="+$('#enddate').val()+"&agent="+$('#agent').val(), "", "width=400, height=500");
		});

		$('#pdf').click(function(){
			window.open("<?php echo base_url();?>laporan/retur_permajalah/pdf_retur?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&startdate="+$('#startdate').val()+"&enddate="+$('#enddate').val()+"&agent="+$('#agent').val(), "");
		});

		$('#excel').click(function(){
			document.location.href ="<?php echo base_url();?>laporan/retur_permajalah/excel?majalah="+$('#majalah').val()+"&edisi="+$('#edisi').val()+"&startdate="+$('#startdate').val()+"&enddate="+$('#enddate').val()+"&agent="+$('#agent').val();
		});
	});
</script>