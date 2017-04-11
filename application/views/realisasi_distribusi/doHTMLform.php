
<html>
<head>
<title>Cetak Do</title>
<style type="text/css">
  *{
    font-size: 12px;
  }
</style>
</head>
<body topMargin="0" leftMargin="1" onload="print()"> 
<?php 
  foreach ($majalah as $majalah) {
  	 $date[] = $majalah['date_created'];
  	 $distribution_realization_detail_id[] = $majalah['distribution_realization_detail_id'];
     $quota[] = $majalah['quota'];
     $consigned[] = $majalah['consigned'];
     $gratis[] = $majalah['gratis'];
     $nama_agent[] = $majalah['nama_agent'];
     $alamat_agent[] = $majalah['address'];
     $npwp[] = $majalah['npwp'];
   } 
?>
<?php 
  for ($i=0; $i < count($nama_agent); $i++) 
  { ?>
    <div>
      <p style="font-size:20px; margin:0"><?php echo $detail['nama'] ?></p> 
      <table width="100%" cellpadding="1" cellspacing="0" border="0">
        <tr>
          <td width="60%" height="0" class="txtPrint1"><?php echo $detail['alamat'] ?></td>
          <td width="5%" valign="top" align="right" class="txtPrint1">No.</td>
          <td width="2%" valign="top" align="right" class="txtPrint1">:</td>
          <td width="33%" valign="top" align="right" class="txtPrint1"><b><?php echo date('y',strtotime($date[$i]))."/".$detail['nama_majalah']."/0".$distribution_realization_detail_id[$i] ?></b></b></td>
        </tr>
        <tr>
          <td height="0" class="txtPrint1"><?php echo "N.P.W.P ".$detail['npwp']?></td>
          <td valign="top" align="right" class="txtPrint1">Tgl Kirim</td>
          <td valign="top" align="right" class="txtPrint1">:</td>
          <td valign="top" align="right" class="txtPrint1"><b><?php echo date('d/m/Y') ?></b></td>
        </tr>
        <tr >
          <td width="50%" height="20" valign="top" class="txtPrint1"><?php echo "Tanggal Pengukuhan pkp ".$detail['pkp']?></td>
        </tr>
        <tr>
          <td width="50%" valign="top" class="txtPrint1"><b>TO : <?php echo $nama_agent[$i]?></b></td>
        </tr>
        <tr>
          <td width="50%" valign="top" class="txtPrint1" rowspan="2"><?php echo $alamat_agent[$i]?></td>
        </tr>
        <tr>
        </tr>
        <tr>
          <td width="50%%" valign="top" class="txtPrint1" rowspan="2"><?php echo "N.P.W.P : ".($npwp[$i] == '') ? "00.000.000.00.0.-000.000" : $npwp[$i] ?></td>
        </tr>
      </table><br>
      <table width="100%" cellpadding="1" cellspacing="0" border="0">
        <tr>
          <td height="20" align="center"><b>DELIVERY ORDER (DO)</b></td>
        </tr>
      </table>
      <table width="100%" cellpadding="1" cellspacing="0" style="border: double">
        <tr>
          <td width="30%" height="10" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Jumlah</b></td>
          <td width="35%" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Majalah</b></td>
          <td width="35%" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Keterangan</b></td>
        </tr>
        <tr>
          <td width="30%" height="60" valign="center" align="center" class="txtPrint1" style="border-left: 1px solid">
            <p style="margin: 0;">Quota : <?php echo $quota[$i] ;?></p>
            <p style="margin: 0;">Consigned : <?php echo $consigned[$i] ;?></p>
            <p style="margin: 0;">Gratis : <?php echo $gratis[$i] ;?></p>
            <p style="margin: 0;">Total : <?php echo $quota[$i] + $consigned[$i] + $gratis[$i]; ?></p>
          </td>
          <td width="35%" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            <?php echo $detail['nama_majalah'] ?> Edisi <?php echo $detail['kode_edisi'] ?>
          </td>
          <td width="35%" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            Rp. <?php echo number_format($detail['harga'],0,',','.')  ?>
          </td>
        </tr>
        <tr>
          <td style="border-left: 1px solid; border-top: 1px solid" colspan="3">
          <b>Note :</b>
          <p style="margin:0px">Apabila Dalam Waktu 3 x 24 Jam Setelah Barang diterima tidak ada klaim, maka barang dianggap sesuai dengan DO ( Delivery Order ).</p>
          </td>
        </tr>
      </table>
      <table width="100%" cellpadding="1" cellspacing="0" border="0" style="margin-top: 10px">
        <tr>
          <td width="50%" align="center"> Diterima Oleh </td>
          <td></td>
          <td width="50%" align="center"> Dicek Oleh </td>
        </tr>
        <tr >
          <td height="75" width="50%" align="center" valign="bottom" >(...................................)</td>
          <td></td>
          <td height="75" width="50%" align="center" valign="bottom">(...................................)</td>
        </tr>
        <tr>
          <td><b>Nama Jelas :</b></td>
        </tr>
        <tr>
          <td><b>Tanggal :</b></td>
        </tr>
      </table>
    </div>
    <footer style="page-break-after:always;"></footer>
  <?php }
?>
</body>
</html>
