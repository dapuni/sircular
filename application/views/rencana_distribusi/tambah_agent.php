<fieldset>
	<legend>Tambah Agent</legend>
	<form action="<?php echo $url; ?>" method="post">
		<input type="hidden" name="distribution_plan_id" value="<?php echo $id ?>">
		<div class="form-group">
             <label>Agent</label>
             <select class="form-control" name="agent_id" id="agent_id">
             	<?php 
             		foreach ($agent as $agentx) 
             		{ ?>
             			<option value="<?php echo $agentx['agent_id'] ?>"><?php echo $agentx['nama_agent'] ?></option>
             		<?php }
             	?>
             </select>  
        </div>
        <div class="form-group">
            <label for="dist-detail-quota">Quota</label>
            <input type="text" class="form-control" name="quota" value="<?php echo isset($detail_agent['quota']) ? $detail_agent['quota'] :'';?>" id="dist-detail-quota">
        </div>
        <div class="form-group">
            <label for="dist-detail-consigned">Consigned</label>
            <input type="text" class="form-control" name="consigned" value="<?php echo isset($detail_agent['consigned']) ? $detail_agent['consigned'] :'';?>" id="dist-detail-consigned">
        </div>
        <div class="form-group">
            <label for="dist-detail-gratis">Gratis</label>
            <input type="text" class="form-control" name="gratis" value="<?php echo isset($detail_agent['gratis']) ? $detail_agent['gratis'] :'';?>" id="dist-detail-gratis">
        </div>
        <button class="btn btn-primary">Submit</button>
	</form>
</fieldset>
<script type="text/javascript">
    <?php echo (isset($detail_agent))?"$('#agent_id').val(".$detail_agent['agent_id'].");":''?>
</script>