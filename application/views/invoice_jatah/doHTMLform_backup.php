
<html>
<head>
<title>Cetak Do</title>
</head>
<body topMargin="0" leftMargin="1">
    <div>
      <h2 style="margin:0px" ><b><?php echo $cetak_invoice['nama'] ?></b></h2>
      <table width="710" cellpadding="1" cellspacing="0" border="0">
        <tr>
          <td width="450" height="20" class="txtPrint1"><?php echo $cetak_invoice['alamat'] ?></td>
          <td width="70" valign="top" align="right" class="txtPrint1">No.</td>
          <td width="40" valign="top" align="right" class="txtPrint1">:</td>
          <td width="150" valign="top" align="right" class="txtPrint1"><b><?php echo date('y',strtotime($cetak_invoice['proccess_date'])).'/'.date('m',strtotime($cetak_invoice['proccess_date'])).'/'.$cetak_invoice['nama_majalah'].'/'.$cetak_invoice['no_invoice']  ?></b></b></td>
        </tr>
        <tr>
          <td height="20" class="txtPrint1"><?php echo $cetak_invoice['phone_penerbit'] ?></td>
          <td valign="top" align="right" class="txtPrint1">Date</td>
          <td valign="top" align="right" class="txtPrint1">:</td>
          <td valign="top" align="right" class="txtPrint1"><b><?php echo date('d-m-Y',strtotime($cetak_invoice['proccess_date'])) ?></b></td>
        </tr>
        <tr>
          <td width="25" valign="top" class="txtPrint1"><?php echo "N.P.W.P : ".$cetak_invoice['npwp_penerbit'] ?></td>
          <td valign="top" align="right" class="txtPrint1">Due Date</td>
          <td valign="top" align="right" class="txtPrint1">:</td>
          <td valign="top" align="right" class="txtPrint1"><b><?php echo date('d-m-Y',$duedate) ?></b></td>
        </tr>
        <tr>
          <td width="25" valign="top" class="txtPrint1"><?php echo "Tanggal Pengukuhan PKP : ".$cetak_invoice['pkp'] ?></td>
        </tr>
        <tr>
          <td width="25" valign="top" class="txtPrint1"><b>TO : <?php echo $cetak_invoice['nama_agent'] ?></b></td>
        </tr>
        <tr>
          <td width="25" valign="top" class="txtPrint1" rowspan="2"><?php echo $cetak_invoice['address'] ?></td>
        </tr>
        <tr></tr>
        <tr>
          <td width="25" valign="top" class="txtPrint1" rowspan="2"><?php echo "N.P.W.P : ".($cetak_invoice['npwp'] == '') ? "00.000.000.00.0.-000.000" : $cetak_invoice['npwp'] ?></td>
        </tr>
      </table><br>
      <table width="710" cellpadding="1" cellspacing="0" border="0">
        <tr>
          <td height="20" align="center"><b>INVOICE</b></td>
        </tr>
      </table>
      <table width="710" cellpadding="1" cellspacing="0" style="border: double">
        <tr>
          <td width="200" height="10" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Quantity</b></td>
          <td width="250" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Description</b></td>
          <td width="250" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Price</b></td>
          <td width="250" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Gross</b></td>
          <td width="250" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Rebate</b></td>
          <td width="250" height="10" align="center" align="center" class="txtPrint1" style="border-bottom: double; border-left: 1px solid;"><b>Nett</b></td>
        </tr>
        <tr>
          <td width="200" height="60" valign="center" align="center" class="txtPrint1" style="border-left: 1px solid">
            <p style="margin: 0;"><?php echo $total_quantity ?></p>
          </td>
          <td width="250" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            <?php echo $cetak_invoice['nama_majalah'] ?>
          </td>
          <td width="250" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
          </td>
          <td width="250" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            Rp. <?php echo number_format($gross,0,'.','.')  ?>
          </td>
          <td width="250" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            Rp. <?php echo number_format($rebate,0,'.','.') ?>
          </td>
          <td width="250" height="60" align="center" align="center" class="txtPrint1" style="border-left: 1px solid;">
            Rp. <?php echo number_format($cetak_invoice['total'],0,'.','.') ?>
          </td>
        </tr>
        <tr>
          <td style="border-left: 1px solid; border-top: 1px solid" colspan="6">
          <b>Terbilang:</b><br>
          <p><?php echo ($cetak_invoice['total'] < 0 ) ? 'Minus' : ''; echo $terbilang.' Rupiah' ?></p>
          </td>
        </tr>
      </table>
      <table width="710" cellpadding="1" cellspacing="0" border="0" style="margin-top: 10px">
        <tr>
          <td rowspan="3"></td>
        </tr>
        <tr >
          <td height="75" width="250" align="center" valign="bottom"><?php echo $cetak_invoice['authorized_signature'] ?></td>
        </tr>
      </table>
    </div>
</body>
</html>
