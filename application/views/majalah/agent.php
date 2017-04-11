<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>

<fieldset>
	<legend>Select Agent for <?php echo $majalah['nama_majalah']; ?></legend>
	<form action="masterdata/majalah/relasi_agent/<?php echo $id ?>" method="post">
	<input type="hidden" name="majalah" value="<?php echo $majalah['majalah_id']; ?>">
		<?php 
			foreach ($agent_cat as $agent_cat)
			{ ?>
				<legend><?php echo $agent_cat['nama_agent_cat'] ?></legend>
				<table class="table">
					<thead>
						<th width="3%">#</th>
						<th>Nama Agent</th>
						<th>Jatah</th>
						<th>Konsinyasi</th>
						<th>Gratis</th>
						<th>Disc</th>
						<th>Disc Deposit</th>
					</thead>
					<tbody>
						<?php
						$no = 1; 
							foreach ($agent as $agent_x) 
							{
								if ($agent_x['agent_category'] == $agent_cat['agent_category_id']) 
								{ 
								//set every id for agent
								echo "<tr id='agent_".$agent_x['agent_id']."'>";
									?>
									<input type="hidden" name="agent[]" value="<?php echo $agent_x['agent_id']; ?>">
									<td><?php echo $no++; ?></td>
									<td><?php echo $agent_x['nama_agent'] ?></td>
									<td><input type="text" name="jatah[]"></td>
									<td><input type="text" name="konsinyasi[]"></td>
									<td><input type="text" name="gratis[]"></td>
									<td><input type="text" name="disc_total[]" value="<?php echo $agent_x['discount']; ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?> ></td>
									<td><input type="text" name="disc_simpan[]" value="<?php echo $agent_x['deposit']; ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?> ></td>
									<?php 
										if ($this->session->userdata('group') >= 1) { ?>
											<td><a href="masterdata/majalah/clearstatus/<?php echo $id."/".$agent_x['agent_id'] ?>" onclick="return confirm('Anda Yakin Menghapus Data?')" ><span class="glyphicon glyphicon-remove"></span></a></td>
										<?php }
									}
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			<?php }
		?>
		<button class="btn btn-primary" type="submit">Simpan Agen</button>
	</form>
</fieldset>
<script type="text/javascript">
	$(document).ready(function(){
		<?php 
			foreach ($agent_magazine_detail as $agent_magazine_detail) 
			{
				echo "$(\"#agent_".$agent_magazine_detail['agent_id']." input[name~='jatah[]']\").val(".$agent_magazine_detail['jatah'].");";
				echo "$(\"#agent_".$agent_magazine_detail['agent_id']." input[name~='konsinyasi[]']\").val(".$agent_magazine_detail['konsinyasi'].");";
				echo "$(\"#agent_".$agent_magazine_detail['agent_id']." input[name~='gratis[]']\").val(".$agent_magazine_detail['gratis'].");";
				echo "$(\"#agent_".$agent_magazine_detail['agent_id']." input[name~='disc_total[]']\").val(".$agent_magazine_detail['disc_total'].");";
				echo "$(\"#agent_".$agent_magazine_detail['agent_id']." input[name~='disc_simpan[]']\").val(".$agent_magazine_detail['disc_deposit'].");";
			}
		?>
		//
	});
</script>