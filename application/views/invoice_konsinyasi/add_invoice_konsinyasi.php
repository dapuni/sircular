<fieldset>
	<legend>Tambah Invoice Konsinyasi</legend>
	<form action="<?php echo base_url()?>tagihan/invoice_konsinyasi/list_data" method="post">
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
			<input type="text" class="form-control date" name="proccess_date" id="startdate" value="<?php echo date('Y-m-d',strtotime('now')) ?>">
		</div>
		<div class="col-xs-2">
			<button type="submit" class="btn btn-default" id="button" >Buat Invoice Konsinyasi</button>			
		</div>
		<div class="col-xs-12">
			<table class="table">
				<thead>
					<th width="2%">#</th>
					<th>Majalah</th>
				</thead>
				<tbody>
					<?php 
						foreach ($majalah as $keymajalah) 
						{ ?>
							<tr>
								<td><input type="radio" name="majalah_id" id="radio" value="<?php echo $keymajalah['majalah_id'] ?>" ></td>
								<td><?php echo $keymajalah['nama_majalah'] ?></td>
							</tr>
						<?php }
					?>
				</tbody>
			</table>
		</div>
	</form>
</fieldset>
<script type="text/javascript">
	$( document ).ready(function() {
     	$('#button').click(function(){
     		var agent = $('#agent').val();
     		if (agent == 0) {
     			alert('Please select agent');
     			return false;
     		}
     	});
	});
</script>