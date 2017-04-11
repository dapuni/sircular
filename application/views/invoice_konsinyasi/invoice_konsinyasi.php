<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>Invoice Konsinyasi</legend>
	<form action="<?php echo base_url()?>tagihan/invoice_konsinyasi" method="get">
		<div class="col-xs-2">
			<select class="form-control" name="agent_category" id="agent_category">
		    	<option value="0">---</option>
		   		<?php 
		   			foreach ($agent_category as $keyagent_category) 
		   			{ ?>
		   				<option value="<?php echo $keyagent_category['agent_category_id'] ?>" ><?php echo $keyagent_category['nama_agent_cat'] ?></option>
		   			<?php }
		   		?>
	        </select>
		</div>
		<div class="col-xs-2">
			<select class="form-control" name="agent" id="agent">
		    	<option value="0">---</option>
		    	<?php 
		   			foreach ($agent as $keyagent) 
		   			{ ?>
		   				<option value="<?php echo $keyagent['agent_id'] ?>" ><?php echo $keyagent['nama_agent'] ?></option>
		   			<?php }
		   		?>
		    </select>
		</div>
		<div class="col-xs-2">
			<input type="text" class="form-control date" name="startdate" id="startdate" value="<?php echo (isset($select_startdate))? $select_startdate : ''?>">
		</div>
		<div class="col-xs-2">
			<input type="text" class="form-control date" name="enddate" id="enddate" value="<?php echo (isset($select_enddate))? $select_enddate : ''?>">
		</div>
		<div class="col-xs-2">
			<button type="submit" class="btn btn-default">Cari</button>
			<a href="tagihan/invoice_konsinyasi/add" class="btn btn-default">Tambah</a>
		</div>
		<div class="col-xs-2">
			<input type="text" name="pajak" id="pajak" class="form-control" placeholder="Nomor Pajak">
		</div>	
	</form>
	<table class="table">
		<thead>
			<th width="2%">#</th>
			<th>No Invoice</th>
			<th>Tanggal Invoice</th>
			<th>Nama Agent</th>
			<th>Total</th>
			<th>Pajak</th>
			<th style="text-align:center">Action</th>
		</thead>
		<tbody>
			<?php
				$no = 1;
				foreach ($invoice as $keyinvoice) 
				{ ?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td><?php echo date('y',strtotime($keyinvoice['proccess_date'])).'/'.date('m',strtotime($keyinvoice['proccess_date'])).'/'.$keyinvoice['nama_majalah'].'/'.$keyinvoice['no_invoice'] ?></td>
						<td><?php echo date('d-m-Y',strtotime($keyinvoice['proccess_date']))?></td>
						<td><?php echo $keyinvoice['nama_agent']  ?></td>
						<td><?php echo number_format($keyinvoice['total'],0,',','.')  ?></td>
						<td><?php echo ($keyinvoice['npwp'] != '') ? 'kena Pajak' : 'Tidak'  ?></td>
						<td style="text-align:center" ><a href="tagihan/invoice_konsinyasi/detail/<?php echo $keyinvoice['invoice_id'] ?>" class="btn btn-primary btn-sm" >Detail</a> <a class="btn btn-primary btn-sm" onclick="cetak(<?php echo $keyinvoice['invoice_id'] ?>)" ><span class="glyphicon glyphicon-print"></span> Invoice</a></td>
					</tr>
				<?php }
			?>
		</tbody>
	</table>
	<?php echo $pagination; ?>
</fieldset>
<script type="text/javascript">
	<?php echo (isset($select_agent_category))?"$('#agent_category').val(".$select_agent_category.");":''?>
	<?php echo (isset($select_agent))?"$('#agent').val(".$select_agent.");":''?>
	function cetak(id){
		var pajak = document.getElementById("pajak").value;
		window.open("<?php echo base_url();?>tagihan/invoice_konsinyasi/cetak?id="+id+"&pajak="+pajak, "", "width=400, height=500");
	};
</script>