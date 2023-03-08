<?php
    include '../../config/Config.php';
    $page       = "Laporan Jenis Pembayaran";
    $menu       = "Laporan Jenis Pembayaran";
    $submenu    = "Laporan";
    $config = new Config();

    include "hak-akses.php";
    
    if(empty($_GET['aktif_pembayaran'])) {
        $aktif_pembayaran = "";
    }
    if($_GET['aktif_pembayaran']=="0") {
        $aktif_pembayaran = "WHERE aktif_pembayaran='0'";
    }
    if($_GET['aktif_pembayaran']=="1") {
        $aktif_pembayaran = "WHERE aktif_pembayaran='1'";
    }
    
    $urutkan = "ORDER BY id_pembayaran " .  $_GET['urutkan'];

    $query = "SELECT * FROM tbl_pembayaran $aktif_pembayaran $urutkan";
    $result = $config->getData($query);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cetak <?= $page; ?></title>

        <style>
        #watermark { position: fixed; bottom: 0px; right: 0px; width: 500px; height: 450px; opacity: .1; }
        @page { margin-top: 30px; }
        img{ text-align: right; } table {
        border-collapse: collapse;
        }
        body {
        font-family: "Arial";
        font-size:9;
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

        th {
        height: 50px;
        }
        </style>

    </head>

    <body onload="window.print()">
        <?php
        $html ='
        <div id="watermark">
            <img src="'. $base_url . 'assets/logo.png" height="100%" width="100%">
        </div>
        <div class="footer">
            
        </div>
        <div class="footer2"><i>Dicetak pada : '.  date("d-m-Y H:i:s").'</i></div>
        <center>
            <img src="'. $base_url . 'assets/logo.png" height="100" width="100">
        <h3>'. $page .'</h3>
        
        <table border="1" align="center" width="100%" cellpadding="10">
            <thead>
                <tr>
                    <th><center>No</center></th>
                    <th><center>Nama Pembayaran</center></th>
                    <th><center>Nominal</center></th>
                    <th><center>Jumlah Cicilan</center></th>
                </tr>
            </thead>
            <tbody>';
                $i = 1;
                foreach ($result as $r) {

                $html .= '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . ucfirst($r['nama_pembayaran']) . '</td>
                    <td>' . $config->format_rupiah(ucfirst($r['nominal_pembayaran'])) . '</td>
                    <td>' . ucfirst($r['jumlah_cicilan']) . ' x</td>
                </tr>
                ';
                $i++;
                }
            $html .= '</tbody>
        </table>
        </center>';
        echo $html;
        ?>
    </body>
    
</html>
