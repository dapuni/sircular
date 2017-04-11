<div class="col-xs-12">
	<fieldset>
		<legend>Tambah Kategori Agent</legend>
			<form action="<?php echo $url; ?>" method="post">
				<div class="form-group">
				    <label for="publisher">Name</label>
				    <input type="text" name="nama_agent_cat" class="form-control" placeholder="Name" value="<?php echo isset($agent_cat['nama_agent_cat']) ? $agent_cat['nama_agent_cat'] : "" ; ?>">
				    <p class="help-block"><em>e.g. LUAR KOTA; DALAM KOTA</em></p>
				  </div>
				<div class="form-group">
				    <label>Keterangan</label>
				    <textarea class="form-control" name="description"><?php echo isset($agent_cat['description']) ? $agent_cat['description'] : "" ; ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
	</fieldset>
</div>