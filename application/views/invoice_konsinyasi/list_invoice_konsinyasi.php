<fieldset>
	<legend>List Invoice Konsinyasi</legend>
	<form action="<?php echo $href ?>" method="post">
		<legend>Detail</legend>
		<div class="col-xs-6">
			<div class="col-xs-4">
				<label>Agent</label>
			</div>
			<div class="col-xs-8">
				<p><?php echo $agent['nama_agent'] ?></p>
				<input type="hidden" name="agent_id" value="<?php echo $agent['agent_id'] ?>">
			</div>
			<div class="col-xs-4">
				<label>Majalah</label>
			</div>
			<div class="col-xs-8">
				<p><?php echo $majalah['nama_majalah'] ?></p>
				<input type="hidden" name="majalah_id" value="<?php echo $majalah['majalah_id'] ?>">
			</div>
			<div class="col-xs-4">
				<label>Date</label>
			</div>
			<div class="col-xs-8">
				<p><?php echo $date?></p>
				<input type="hidden" name="proccess_date" value="<?php echo $date ?>">
			</div>
		</div>
		<legend>List Data</legend>
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
					//INVOICE UNTUK DO
					$quantity = 0;
					$gross = 0;
					$rebate = 0;
					$nett = 0;
					foreach ($list_do as $keylist_do) 
					{ 
						$quantity = $keylist_do['consigned'];
						$gross = $keylist_do['harga'] * $quantity;
						$rebate = ($keylist_do['disc_total'] / 100) * $gross;
						$nett = $gross - $rebate;
						?>
						<tr>
							<td><input type="checkbox" name="inv_do[]" value="<?php echo $keylist_do['distribution_realization_detail_id'] ?>" <?php echo (isset($checked) && $checked == TRUE) ? 'checked' : '' ?> ></td>
							<td style="text-align:center"><?php echo $quantity ?></td>
							<td><?php echo $keylist_do['nama_majalah'].' '.$keylist_do['kode_edisi'].' DO : '.date('y',strtotime($keylist_do['date_created'])).'/'.$keylist_do['nama_majalah'].'/0'.$keylist_do['distribution_realization_detail_id'] ?></td>
							<td style="text-align:right"><?php echo number_format($keylist_do['harga'],0,',','.')  ?></td>
							<td style="text-align:right"><?php echo number_format($gross,0,',','.') ?></td>
							<td style="text-align:center"><?php echo $keylist_do['disc_total'] ?></td>
							<td style="text-align:right"><?php echo number_format($rebate,0,',','.') ?></td>
							<td style="text-align:right"><?php echo number_format($nett,0,',','.')?></td>
						</tr>
					<?php }
				?>
				<?php 
					//INVOICE UNTUK RETUR
					$quantity = 0;
					foreach ($list_retur as $keylist_retur) 
					{ 
						$quantity = -$keylist_retur['jumlah'];
						$gross = $keylist_retur['harga'] * $quantity;
						$rebate = ($keylist_retur['disc_total'] / 100) * $gross;
						$nett = $gross - $rebate;
						?>
						<tr style="color:red">
							<td><input type=checkbox name="inv_retur[]" value="<?php echo $keylist_retur['return_item_id'] ?>" <?php echo (isset($checked) && $checked == TRUE) ? 'checked' : '' ?> > </td>
							<td style="text-align:center"><?php echo $quantity ?></td>
							<td><?php echo 'RETUR '.$keylist_retur['nama_majalah'].' '.$keylist_retur['kode_edisi'].' DO : '.date('y',strtotime($keylist_retur['date_created'])).'/'.$keylist_retur['nama_majalah'].'/0'.$keylist_retur['distribution_realization_id'] ?></td>
							<td style="text-align:right"><?php echo number_format($keylist_retur['harga'],0,',','.') ?></td>
							<td style="text-align:right"><?php echo number_format($gross,0,',','.') ?></td>
							<td style="text-align:center"><?php echo $keylist_retur['disc_total'] ?></td>
							<td style="text-align:right"><?php echo number_format($rebate,0,',','.') ?></td>
							<td style="text-align:right"><?php echo number_format($nett,0,',','.') ?></td>
						</tr>
					<?php }
				?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
	</form>
</fieldset>