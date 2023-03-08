
<?php
    include '../../config/Config.php';
    $page       = "TANDA BUKTI PEMBAYARAN";
    $menu       = "Transaksi";
    $submenu    = "";
    $config = new Config();

    include "hak-akses.php";
    $id_transaksi1 = base64_decode($_GET['id']);
    $id_transaksi2 = base64_decode($id_transaksi1);
    $id_transaksi = base64_decode($id_transaksi2);
	
    $id_warga1 = base64_decode($_GET['warga']);
    $id_warga2 = base64_decode($id_warga1);
    $id_warga = base64_decode($id_warga2);

    $id_rumah = base64_decode(base64_decode(base64_decode($_GET['id_rumah'])));
	
    $id_pembayaran1 = base64_decode($_GET['pembayaran']);
    $id_pembayaran2 = base64_decode($id_pembayaran1);
    $id_pembayaran = base64_decode($id_pembayaran2);
	
    $cicilan1 = base64_decode($_GET['cicilan']);
    $cicilan2 = base64_decode($cicilan1);
    $cicilan = base64_decode($cicilan2);

    

    $result = $config->getData("SELECT * FROM  tbl_transaksi t, tbl_pembayaran pn, tbl_jurusan j, tbl_warga s, tbl_pegawai p, tbl_rumah k WHERE t.id_warga = s.id_warga AND t.id_pegawai = p.id_pegawai AND t.id_pembayaran = pn.id_pembayaran AND k.id_jurusan = j.id_jurusan AND s.id_rumah = k.id_rumah AND t.id_transaksi='". $id_transaksi ."'");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."page/dashboard';
                </script>");
    }

    foreach ($result as $r):
        $kurang = $config->getData("SELECT SUM(nominal_transaksi) as nominal FROM tbl_transaksi WHERE id_rumah='". $id_rumah ."' AND id_warga='". $id_warga."' AND id_pembayaran='". $id_pembayaran ."' AND cicilan_transaksi<='". $cicilan ."'");
        foreach ($kurang as $k):
            $nilai_pembayaran = $r['nominal_pembayaran'];
            $sisa_pembayaran = $nilai_pembayaran  - $k['nominal'];
            if ($sisa_pembayaran<=0) {
               $keterangan_pembayaran = "<b style='color:green;'>LUNAS</b>";
            } else {
                $keterangan_pembayaran = "<b style='color:red;'>BELUM LUNAS</b>";
            }
			$rumah=$config->format_romawi($r['tingkat_rumah']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cetak <?= $page; ?></title>
        <style>
        #watermark { position: absolute; bottom: 0px; right: 0px; opacity: .1; }
        @page { }
        img{ text-align: right; } table {
        border-collapse: collapse;
        }
        body {
        font-family: "Arial";
        font-size:9;
		width:100%;
		height:100%;
        }
        .header, .footer {
        width: 100%;
        text-align: right;
        position: fixed;
        }
        .footer2 {
        width: 100%;
        text-align: left;
        position: fixed;
        }
        .header {
        top: 0px;
        }
        .footer {
        bottom: 0px;
        }
        .footer2 {
        bottom: 0px;
        }
        .pagenum:before {
        content: counter(page);
        }
		table{
			font-size:10px;
		}
        th {
        height: 10px;
        }
		.bagiansetengah{
			width:50%;
			float:left;
			margin:0px;
			padding:0px;
		}
		.tes{
			width:47%;
			position:relative;
			float:left;
			padding:10px;
			border:1px;
			border-style:dashed;
			border-color:#000;
		}
        </style>

    </head>
	 
    <body onload="window.print()">
        <?php
        $html ='
        <div class="tes">
			<div id="watermark">
				<img src="'. $base_url . 'assets/logo.png" height="100%" width="100%">
			</div>
			<div class="bagiansetengah" >
				<h6 style="margin:0px; padding:5px 0px;">'. $page .'</h6>
				<h6 style="margin:0px; padding:5px 0px;">Kode : '. $id_transaksi .'</h6>
			</div>
			<div class="bagiansetengah">
				<img src="'. $base_url . 'assets/logo.png" height="50" width="50" align="right">
			</div>
			<div style="clear:both;"></div>
			<b><h6 style="margin:0px; padding:0px; padding-bottom:10px;">Telah Terima Dari :</h6></b>
			<div class="bagiansetengah">
				<table style="width:100%; ">
					<tr>
						<td>NIS</td><td>: '. $r['niw'] .'</td>
					</tr>
					<tr>
						<td>Nama</td><td>: '. $r['nama_warga'] .'</td>
					</tr>
					<tr>
						<td>Nomor Rumah</td><td>: '.$rumah." - ". $r['nama_rumah'] .'</td>
					</tr>
				</table>
			</div>
			<div class="bagiansetengah" >
				<table style="width:100%;">
					<tr>
						<td>Jurusan</td><td>: '. $r['nama_jurusan'] .'</td>
					</tr>
					<tr>
						<td>Tanggal</td><td>: '. $r['waktu_transaksi'] .'</td>
					</tr>
					<tr>
						<td>Metode</td><td>: '. $r['pembayaran_melalui'] .'</td>
					</tr>
				</table>
			</div>
			<div style="clear:both;"></div>
			<b><h6 style="margin:0px; padding:5px 0px;;">Rincian Pembayaran :</h6></b>
			<table width="100%" border="1" cellpadding="5">
				<tr>
					<th align="center">No</th>
					<th align="center">Cicilan ke-</th>
					<th align="center">Pembayaran</th>
					
					<th align="center">Nominal</th>
				</tr>
				<tr>
					<td align="center">1</td>
					<td align="center">'. $cicilan .'x</td>
					<td>'. $r['nama_pembayaran'] .'</td>
					<td>'. $config->format_rupiah($r['nominal_transaksi']) .'</td>
				</tr>
				<tr>
					<td colspan="3" align="right">Total :</td>
					<td colspan="">'. $config->format_rupiah($r['nominal_transaksi']) .'</td>

				</tr>
				<tr>
					<td colspan="3" align="right">Sisa Pembayaran :</td>
					<td colspan="">'. $config->format_rupiah($sisa_pembayaran)  .'</td>
				</tr>
				<tr>
					<td colspan="3" align="right">Keterangan :</td>
					<td colspan="">'. $keterangan_pembayaran .'</td>
				</tr>
			</table>
			<h6 style="margin:0px; padding:3px 0px;">
			<i>Dicetak pada : '.  date("d-m-Y H:i:s").'</i>
			</h6>
			<br/>
			<br/>
			<table width="100%" style="margin-top:-25px;">
				<tr>
					<td align="center">Yang Menyerahkan</td>
					<td align="center">
					Mengetahui Petugas
					</td>
				</tr>

				<tr>
					<td align="center">
						<br/><br/><br/><br/><br/><br/>
						(..............................................)
					</td>
					<td align="center">
						<br/><br/><br/><br/><br/><br/>
						'. $r['nama_pegawai'] .'
						<br/>
						'. $r['nip'] .'
					</td>
				</tr>
			</table>
		</div>
		
		<div class="tes">
			<div id="watermark">
				<img src="'. $base_url . 'assets/logo.png" height="100%" width="100%">
			</div>
			<div class="bagiansetengah" >
				<h6 style="margin:0px; padding:5px 0px;">'. $page .'</h6>
				<h6 style="margin:0px; padding:5px 0px;">Kode : '. $id_transaksi .'</h6>
			</div>
			<div class="bagiansetengah">
				<img src="'. $base_url . 'assets/logo.png" height="50" width="50" align="right">
			</div>
			<div style="clear:both;"></div>
			<b><h6 style="margin:0px; padding:0px; padding-bottom:10px;">Telah Terima Dari :</h6></b>
			<div class="bagiansetengah">
				<table style="width:100%; ">
					<tr>
						<td>NIS</td><td>: '. $r['niw'] .'</td>
					</tr>
					<tr>
						<td>Nama</td><td>: '. $r['nama_warga'] .'</td>
					</tr>
					<tr>
						<td>Nomor Rumah</td><td>: '.$rumah." - ". $r['nama_rumah'] .'</td>
					</tr>
				</table>
			</div>
			<div class="bagiansetengah" >
				<table style="width:100%;">
					<tr>
						<td>Jurusan</td><td>: '. $r['nama_jurusan'] .'</td>
					</tr>
					<tr>
						<td>Tanggal</td><td>: '. $r['waktu_transaksi'] .'</td>
					</tr>
					<tr>
						<td>Metode</td><td>: '. $r['pembayaran_melalui'] .'</td>
					</tr>
				</table>
			</div>
			<div style="clear:both;"></div>
			<b><h6 style="margin:0px; padding:5px 0px;;">Rincian Pembayaran :</h6></b>
			<table width="100%" border="1" cellpadding="5">
				<tr>
					<th align="center">No</th>
					<th align="center">Cicilan ke-</th>
					<th align="center">Pembayaran</th>
					
					<th align="center">Nominal</th>
				</tr>
				<tr>
					<td align="center">1</td>
					<td align="center">'. $cicilan .'x</td>
					<td>'. $r['nama_pembayaran'] .'</td>
					<td>'. $config->format_rupiah($r['nominal_transaksi']) .'</td>
				</tr>
				<tr>
					<td colspan="3" align="right">Total :</td>
					<td colspan="">'. $config->format_rupiah($r['nominal_transaksi']) .'</td>

				</tr>
				<tr>
					<td colspan="3" align="right">Sisa Pembayaran :</td>
					<td colspan="">'. $config->format_rupiah($sisa_pembayaran)  .'</td>
				</tr>
				<tr>
					<td colspan="3" align="right">Keterangan :</td>
					<td colspan="">'. $keterangan_pembayaran .'</td>
				</tr>
			</table>
			<h6 style="margin:0px; padding:3px 0px;">
			<i>Dicetak pada : '.  date("d-m-Y H:i:s").'</i>
			</h6>
			<br/>
			<br/>
			<table width="100%" style="margin-top:-25px;">
				<tr>
					<td align="center">Yang Menyerahkan</td>
					<td align="center">
					Mengetahui Petugas
					</td>
				</tr>

				<tr>
					<td align="center">
						<br/><br/><br/><br/><br/><br/>
						(..............................................)
					</td>
					<td align="center">
						<br/><br/><br/><br/><br/><br/>
						'. $r['nama_pegawai'] .'
						<br/>
						'. $r['nip'] .'
					</td>
				</tr>
			</table>
		</div>
		
			
        ';
        echo $html;
        ?>
    </body>
    
</html>

<?php
    endforeach;
endforeach;
?>