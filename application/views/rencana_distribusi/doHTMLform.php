
<html>
<head>
<title>Cetak Do</title>
</head>
<body onload="window.print()" topMargin="0" leftMargin="1">
<?php 
  foreach ($majalah as $majalah) {
     $quota[] = $majalah['quota'];
     $consigned[] = $majalah['consigned'];
     $gratis[] = $majalah['gratis'];
     $nama_agent[] = $majalah['nama_agent'];
     $alamat_agent[] = $majalah['address'];
   } 
?>
<?php 
  for ($i=0; $i < count($nama_agent); $i++) 
  { ?>
    <div style="page-break-before:always;">
      <?php echo $detail['nama'] ?>
      <table width="710" cellpadding="1" cellspacing="0" border="0">
        <tr>
          <td width="450" height="20" class="txtPrint1"><?php echo $detail['alamat'] ?></td>
          <td width="70" valign="top" align="right" class="txtPrint1">No.</td>
          <td width="40" valign="top" align="right" class="txtPrint1">:</td>
          <td width="150" valign="top" align="right" class="txtPrint1"><b><?php echo date('y',strtotime($majalah['date_created']))."/0".$majalah['distribution_plan_detail_id'] ?></b></b></td>
        </tr>
        <tr>
          <td height="20" class="txtPrint1"><?php echo $detail['phone'] ?></td>
          <td valign="top" align="right" class="txtPrint1">Tgl Kirim</td>
          <td valign="top" align="right" class="txtPrint1">:</td>
          <td valign="top" align="right" class="txtPrint1"><b><?php echo date('d/m/Y') ?></b></td>
        </tr>
        <tr>
          <td width="25" valign="top" class="txtPrint1"><b>TO : <?php echo $nama_agent[$i]?></b></td>
        </tr>
        <tr>
          <td width="25" valign="top" class="txtPrint1" rowspan="2"><?php echo $alamat_agent[$i]?></td>
        </tr>
      </table><br>
      <table width="710" cellpadding="1" cellspacing="0" border="0">
        <tr>
          <td height="20" align="center"><b>DELIVERY ORDER (DO)</b></td>
        </tr>
      </table>
      <table width="710" cellpadding="1" cellspacing="0" style="border: double">
        <tr>
          <td width="200" height="10" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Jumlah</b></td>
          <td width="250" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Majalah</b></td>
          <td width="250" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Keterangan</b></td>
        </tr>
        <tr>
          <td width="200" height="60" valign="center" align="center" class="txtPrint1" style="border-left: 1px solid">
            <p style="margin: 0;">Quota : <?php echo $quota[$i] ;?></p>
            <p style="margin: 0;">Consigned : <?php echo $consigned[$i] ;?></p>
            <p style="margin: 0;">Gratis : <?php echo $gratis[$i] ;?></p>
            <p style="margin: 0;">Total : <?php echo $quota[$i] + $consigned[$i] + $gratis[$i]; ?></p>
          </td>
          <td width="250" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            <?php echo $detail['nama_majalah'] ?> Edisi <?php echo $detail['kode_edisi'] ?>
          </td>
          <td width="250" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            Rp. <?php echo $detail['harga'] ?>
          </td>
        </tr>
        <tr>
          <td style="border-left: 1px solid; border-top: 1px solid" colspan="3">
          <b>Note :</b><br>
          <p>Apabila Dalam Waktu 3 x 24 Jam Setelah Barang diterima tidak ada klaim, maka barang dianggap sesuai dengan DO ( Delivery Order ).</p>
          </td>
        </tr>
      </table>
      <table width="710" cellpadding="1" cellspacing="0" border="0" style="margin-top: 10px">
        <tr>
          <td width="250" align="center"> Diterima Oleh </td>
          <td></td>
          <td width="250" align="center"> Dicek Oleh </td>
        </tr>
        <tr >
          <td height="75" width="250" align="center" valign="bottom" >(...................................)</td>
          <td></td>
          <td height="75" width="250" align="center" valign="bottom">(...................................)</td>
        </tr>
        <tr>
          <td><b>Nama Jelas :</b></td>
        </tr>
        <tr>
          <td><b>Tanggal :</b></td>
        </tr>
      </table>
    </div>
  <?php }
?>
</body>
</html>
