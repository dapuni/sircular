<?php echo validation_errors(); ?>
<?php
	//make string to array and make sure data array
	$phone = explode(",", isset($data['phone']) ? $data['phone'] :',');
	$contact = explode(",",isset($data['contact']) ? $data['contact'] :',');
	$jabatan = explode(",", isset($data['jabatan']) ? $data['jabatan'] :',');
	$bank = explode(",", isset($data['bank']) ? $data['bank'] :',');
	$rekening = explode(",", isset($data['rekening']) ? $data['rekening'] :',');
?>
<div class="col-xs-12">
	<fieldset>
		<legend><?php echo $label?></legend>
		<form action="<?php echo $url; ?>" method="post">
			<legend>Informasi Umum</legend>
			<div class="form-group col-xs-6">
			    <label for="publisher">Publisher Name</label>
			    <input type="text" name="nama" class="form-control" placeholder="Publisher Name" value="<?php echo isset($data['nama']) ? $data['nama'] : ""?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="publisher">NPWP</label>
			    <input type="text" name="npwp" class="form-control" placeholder="NPWP" value="<?php echo isset($data['npwp']) ? $data['npwp'] : ""?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="publisher">Tanggal Pengukuhan PKP</label>
			    <input type="text" name="pkp" class="form-control" placeholder="Tanggah Pengukuhan PKP" value="<?php echo isset($data['pkp']) ? $data['pkp'] : ""?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="publisher">Authorized Signature</label>
			    <input type="text" name="authorized_signature" class="form-control" placeholder="Authorized Signature" value="<?php echo isset($data['authorized_signature']) ? $data['authorized_signature'] : ""?>">
			</div>
			<legend>Alamat</legend>
			<div class="form-group col-xs-6">
			    <label for="city">Alamat</label>
			    <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?php echo isset($data['alamat']) ? $data['alamat'] : ""?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="city">City</label>
			    <select class="form-control" name="kota" id="kota">
			    	<?php 
			    		foreach ($city as $city)
			    		{ ?>
			    			<option value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
			    		<?php }
			    	?>
			    </select>
			</div>
			<div class="form-group col-xs-6">
			    <label for="province">Province</label>
			    <select class="form-control" name="provinsi" id="provinsi">
			    	<?php 
			    		foreach ($provinsi as $provinsi)
			    		{ ?>
			    			<option value="<?php echo $provinsi['id'];?>"><?php echo $provinsi['name'];?></option>
			    		<?php }
			    	?>
			    </select>
			</div>
			<div class="form-group col-xs-6">
			    <label for="city">Kode Pos</label>
			    <input type="text" name="kode_pos" class="form-control" placeholder="Kode Post" value="<?php echo isset($data['kode_pos']) ? $data['kode_pos'] : ""?>">
			</div>
			<legend>Telepon Fax, Email</legend>
			<div class="form-group col-xs-6">
			    <label for="phone">Phone Number #1</label>
			    <input type="text" name="phone_1" class="form-control" placeholder="Phone Number" value="<?php echo $phone[0] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Phone Number #2</label>
			    <input type="text" name="phone_2" class="form-control" placeholder="Phone Number" value="<?php echo $phone[1] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Fax</label>
			    <input type="text" name="fax" class="form-control" placeholder="Fax" value="<?php echo isset($data['fax']) ? $data['fax'] : ""?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Email</label>
			    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset($data['email']) ? $data['email'] : ""?>">
			</div>
			<legend>Personal Contact</legend>
			<div class="form-group col-xs-6">
			    <label for="phone">Available Contact #1</label>
			    <input type="text" name="contact_1" class="form-control" placeholder="Available Contact" value="<?php echo $contact[0] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Jabatan #1</label>
			    <input type="text" name="jabatan_1" class="form-control" placeholder="Jabatan" value="<?php echo $jabatan[0] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Available Contact #2</label>
			    <input type="text" name="contact_2" class="form-control" placeholder="Available Contact" value="<?php echo $contact[1] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Jabatan #2</label>
			    <input type="text" name="jabatan_2" class="form-control" placeholder="Jabatan" value="<?php echo $jabatan[1] ?>">
			</div>
			<legend>Bank</legend>
			<div class="form-group col-xs-6">
			    <label for="phone">Bank #1</label>
			    <input type="text" name="bank_1" class="form-control" placeholder="Bank" value="<?php echo $bank[0] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Rekening #1</label>
			    <input type="text" name="rek_1" class="form-control" placeholder="Rekening" value="<?php echo $rekening[1] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Bank #2</label>
			    <input type="text" name="bank_2" class="form-control" placeholder="Bank" value="<?php echo $bank[0] ?>">
			</div>
			<div class="form-group col-xs-6">
			    <label for="phone">Rekening #2</label>
			    <input type="text" name="rek_2" class="form-control" placeholder="Rekening" value="<?php echo $rekening[1] ?>">
			</div>
			<button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">Submit</button> 
		</form>
	</fieldset>
</div>
<script type="text/javascript">
	<?php echo (isset($data))?"$('#provinsi').val(".$data['provinsi'].");":''?>
	<?php echo (isset($data))?"$('#kota').val(".$data['kota'].");":''?>
</script>