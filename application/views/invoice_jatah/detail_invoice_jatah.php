<fieldset>
	<legend>Detail Invoice Jatah</legend>
	<div class="col-xs-6">
		<div class="col-xs-4">
			<label>Majalah</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo $invoice['nama_majalah'] ?></p>
		</div>
		<div class="col-xs-4">
			<label>Nama Agent</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo $invoice['nama_agent'] ?></p>
		</div>
		<div class="col-xs-4">
			<label>No Invoice</label>
		</div>
		<div class="col-xs-8">
			<p><?php echo date('y',strtotime($invoice['proccess_date'])).'/'.date('m',strtotime($invoice['proccess_date'])).'/'.$invoice['nama_majalah'].'/'.$invoice['no_invoice'] ?></p>
		</div>
		<form action="<?php echo base_url();?>tagihan/invoice_konsinyasi/hapus/<?php echo $id?>" method="post" id="form">
		<div class="col-xs-4">
			<label>Password</label>
		</div>
		<div class="col-xs-8">
			<input class="form-control" type="password" name="password" id="password">
		</div>
	</div>
	<div class="col-xs-6">
		<div class="btn-group navbar-right" role="group">
		    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Action <span class="caret"></span></button>
		    <ul class="dropdown-menu">
		      	<li><a id="hapus"><span class="glyphicon glyphicon-trash"></span> Hapus Invoice</a></li>
	    	</ul>
	  	</div>
	</div>
		</form>
</fieldset>
<fieldset>
	<table class="table">
		<thead>
			<th width="2%">#</th>
				<th style="text-align:center">Quantity</th>
				<th>Description</th>
				<th style="text-align:center">Price</th>
				<th style="text-align:center">Gross Amount</th>
				<th style="text-align:center">% Rebate</th>
				<th style="text-align:center">Rebate</th>
				<th style="text-align:center">Nett</th>
		</thead>
		<tbody>
			<?php
				$total_quantity = 0;
				$total_gross = 0;
				$total_rebate = 0;
				//INVOICE UNTUK DO
				$quantity = 0;
				$gross = 0;
				$rebate = 0;
				$nett = 0;
				$no = 1;
				foreach ($list_do as $keylist_do) 
				{ 
					$quantity = $keylist_do['quota'] ;
					$gross = $keylist_do['harga'] * $quantity;
					$rebate = ($keylist_do['disc_total'] / 100) * $gross;
					$nett = $gross - $rebate;
					$total_quantity = $total_quantity + $quantity;
					$total_gross = $total_gross + $gross;
					$total_rebate = $total_rebate + $rebate;
					?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td style="text-align:center"> <?php echo $quantity ?> </td>
						<td><?php echo $keylist_do['nama_majalah'].' '.$keylist_do['kode_edisi'].' DO : '.date('y',strtotime($keylist_do['date_created'])).'/'.$keylist_do['nama_majalah'].'/0'.$keylist_do['distribution_realization_detail_id'] ?></td>
						<td style="text-align:right"><?php echo number_format($keylist_do['harga'],0,',','.')  ?></td>
						<td style="text-align:right"><?php echo number_format($gross,0,',','.') ?></td>
						<td style="text-align:center"><?php echo $keylist_do['disc_total'] ?></td>
						<td style="text-align:right"><?php echo number_format($rebate,0,',','.') ?></td>
						<td style="text-align:right"><?php echo number_format($nett,0,',','.')?></td>
					</tr>
				<?php }
			?>
			<tr>
				<td>Total</td>
				<td style="text-align:center"><?php echo $total_quantity ?></td>
				<td colspan="2"></td>
				<td style="text-align:right"><?php echo number_format($total_gross,0,',','.') ?></td>
				<td></td>
				<td style="text-align:right"><?php echo number_format($total_rebate,0,',','.') ?></td>
				<td style="text-align:right"><?php echo number_format($invoice['total'],0,',','.') ?></td>
			</tr>
		</tbody>
	</table>
</fieldset>
<script type="text/javascript" src="<?php echo base_url()?>assets/jquery/md5.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#hapus').click(function(){
			var password = $('#password').val();
		    if (password != '') {
		    	$('#form').submit();
		    	//password = md5(password);
		        //window.location.assign("<?php echo base_url();?>tagihan/invoice_konsinyasi/hapus/<?php echo $id?>?password="+password);
		    } else {
		    	alert('Password Harus Di isi');
		    }
		});
	})
</script>