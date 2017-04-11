<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<fieldset>
	<legend>Agent</legend>
	<div class="col-xs-3">
		<p>Nama Agent</p>
	</div>
	<div class="col-xs-7">
		<p><?php echo isset($agent['nama_agent']) ? $agent['nama_agent'] :'' ?></p>
	</div>
	<div class="col-xs-3">
		<p>Kota</p>
	</div>
	<div class="col-xs-7">
		<p><?php echo isset($agent['name']) ? $agent['name'] :'' ?></p>
	</div>
	<div class="col-xs-3">
		<p>Kategori</p>
	</div>
	<div class="col-xs-7">
		<p><?php echo isset($agent['nama_agent_cat']) ? $agent['nama_agent_cat'] :'' ?></p>
	</div>
</fieldset>
<fieldset>
	<legend>Majalah</legend>
	<form action="masterdata/agent/simpan_relation/<?php echo $id?>" method="post">
		<table class="table">
			<thead>
				<th width="3%">#</th>
				<th>Majalah</th>
				<th>jatah</th>
				<th>Konsinyasi</th>
				<th>Gratis</th>
				<th>Diskon </th>
				<th>Diskon Deposit</th>
			</thead>
			<tbody>
				<?php
				$no = 1; 
					foreach ($majalah as $majalah) 
					{ ?>
						<input type="hidden" name="majalah[]" value="<?php echo $majalah['majalah_id']; ?>">
						<tr id="majalah_<?php echo $majalah['majalah_id'] ?>" >
							<td><?php echo $no++; ?></td>
							<td><?php echo $majalah['nama_majalah']; ?></td>
							<td><input type="text" name="jatah[]"></td>
							<td><input type="text" name="konsinyasi[]"></td>
							<td><input type="text" name="gratis[]"></td>
							<td><input type="text" name="disc_total[]" value="<?php echo isset($agent['discount']) ? $agent['discount'] :'' ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?> > </td>
							<td><input type="text" name="disc_simpan[]" value="<?php echo isset($agent['deposit']) ? $agent['deposit'] :'' ?>" <?php echo ($accounting == TRUE) ? '' : 'readonly' ?> ></td>
							<?php 
								if ($this->session->userdata('group') >= 1) { ?>
									<td><a href="masterdata/agent/clearstatus/<?php echo $id."/".$majalah['majalah_id'] ?>" onclick="return confirm('Anda Yakin Menghapus Data?')" ><span class="glyphicon glyphicon-remove"></span></a></td>
								<?php }
							echo "</tr>";
					}
				?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-primary" style="margin-bottom:10px;"> Simpan </button>
	</form> 
</fieldset>
<script type="text/javascript">
//AUTOCHECK IF SAVE
	$(document).ready(function(){
		<?php 
			foreach ($data_majalah as $data_majalah) 
			{
				echo "$(\"#majalah_".$data_majalah['majalah_id']." input[name~='jatah[]']\").val(".$data_majalah['jatah'].");";
				echo "$(\"#majalah_".$data_majalah['majalah_id']." input[name~='konsinyasi[]']\").val(".$data_majalah['konsinyasi'].");";
				echo "$(\"#majalah_".$data_majalah['majalah_id']." input[name~='gratis[]']\").val(".$data_majalah['gratis'].");";
				echo "$(\"#majalah_".$data_majalah['majalah_id']." input[name~='disc_total[]']\").val(".$data_majalah['disc_total'].");";
				echo "$(\"#majalah_".$data_majalah['majalah_id']." input[name~='disc_simpan[]']\").val(".$data_majalah['disc_deposit'].");";
			}
		?>
	});
</script>