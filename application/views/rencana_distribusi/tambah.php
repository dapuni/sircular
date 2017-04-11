<?php 
	if ($this->session->flashdata('confirm')) 
	{ ?>
		<div class="alert alert-info" role="alert"> <?php echo $this->session->flashdata('confirm') ?></div>
	<?php }
?>
<div class="row">
	<div class="x_panel">
	    <h2><i class="fa fa-bars"></i> Tambah Rencana Distribusi</h2>
	 
	    <div class="" role="tabpanel" data-example-id="togglable-tabs">
	      	<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
	        	<li role="presentation" class="active">
	        		<a href="#tab_content1" id="master-tab" role="tab" data-toggle="tab" aria-expanded="true">Rencana Distribusi Berdasarkan Master Data</a>
	        	</li>
	        	<li role="presentation" class="">
	        		<a href="#tab_content2" role="tab" id="-tab" data-toggle="tab" aria-expanded="false">Rencana Distribusi Berdasarkan Edisi Sebelumnya</a>
	        	</li>
	      	</ul>
	      <div id="myTabContent" class="tab-content">
	        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="master-tab">
	          	<fieldset>
					<legend>Rencana Distribusi Berdasarkan Master Data</legend>
					<form action="sirkulasi/rencana_distribusi/simpan" method="post">
						<div class="form-group">
						    <label for="city">Majalah</label>
						    <select class="form-control" name="majalahy" id="majalahy">
						    	<option value="0">---</option>
						   		<?php 
					    			foreach ($majalah as $majalahy) 
					    			{ ?>
					    				<option value="<?php echo $majalahy['majalah_id']?>"><?php echo $majalahy['nama_majalah']?></option>
					    			<?php }
					    		?>
				            </select>
						</div>
						<div class="form-group">
						    <label>Edisi</label>
						    <select class="form-control" name="edisiy" id="edisiy">
						    	<option value="0">---</option>
						    	<?php
						    		if ($edisi) {
						    			foreach ($edisi as $edisiy) { ?>
						    				<option value="<?php echo $edisiy['edisi_id']?>"><?php echo $edisiy['kode_edisi']?></option>
						    			<?php }
						    		}
						    	?>
						    </select>
						    <p class="help-block"><em>e.g. 185/DESEMBER/2011</em></p>
						</div>
						<div class="form-group">
						    <label>Publish Date</label>
						    <input type="text" name="publish_date" class="form-control date" value="">
						</div>
						<div class="form-group">
						    <label>Plant Print</label>
						    <input type="text" name="plan_print" class="form-control" value="">
						</div>
						<button type="submit" class="btn btn-primary" id="subnew" > Submit </button>
					</form>
				</fieldset> 
	        </div>
	        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="exciting-tab">
	        	<fieldset>
					<legend>Rencana Distribusi Berdasarkan Edisi Sebelumnya</legend>
					<form action="sirkulasi/rencana_distribusi/simpan_from_prev" method="post">
						<div class="form-group">
						    <label for="city">Majalah</label>
						    <select class="form-control" name="majalahx" id="majalah">
						    	<option value="0">---</option>
						   		<?php 
					    			foreach ($majalah as $majalahx) 
					    			{ ?>
					    				<option value="<?php echo $majalahx['majalah_id']?>"><?php echo $majalahx['nama_majalah']?></option>
					    			<?php }
					    		?>
				            </select>
						</div>
						<div class="form-group">
						    <label>Edisi</label>
						    <select class="form-control" name="edisix">
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
						<div class="form-group">
						    <label>Publish Date</label>
						    <input type="text" name="publish_date" class="form-control date" value="">
						</div>
						<div class="form-group">
						    <label for="city">Previous Edition</label>
						    <select class="form-control" name="prev_edition" id="prev_majalah">
						   		<?php
						   			if ($prev_majalah) {
						   				foreach ($prev_majalah as $prev_majalah){ ?>
						    				<option value="<?php echo $prev_majalah['edisi_id']?>"><?php echo $prev_majalah['kode_edisi']?></option>
						    			<?php }
						   			}
					    		?>
				            </select>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</fieldset>
	        </div>
	      </div>
	    </div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		//For auto select
		$("#majalah").change(function()
		{
		    document.location.href ="<?php echo base_url();?>sirkulasi/rencana_distribusi/edisi_majalah/"+$(this).val();
		});
		$("#majalahy").change(function()
		{
		    document.location.href ="<?php echo base_url();?>sirkulasi/rencana_distribusi/edisi_majalah/"+$(this).val();
		});
		//autoselect
		<?php echo (isset($select_majalah))?"$('#majalah').val(".$select_majalah.");":''?>
		<?php echo (isset($select_majalah))?"$('#majalahy').val(".$select_majalah.");":''?>
		//check submit new
		$('#subnew').click(function(){
			var majalah = $('#majalahy').val();
			var edisi = $('#edisiy').val();
			if (majalah != 0 && edisi != 0) {
				return true;
			} else {
				alert('Silahkan isi data Majalah atau Edisi')
				return false;
			}
		})
	});
</script>