<?php
    include '../../config/Config.php';
    $page       = "Laporan Kelas";
    $menu       = "Laporan Kelas";
    $submenu    = "Laporan";
    $config = new Config();

    include "hak-akses.php";
 
    
    $urutkan = "ORDER BY k.id_kelas " .  $_GET['urutkan'];

    $query = "SELECT * FROM tbl_kelas k, tbl_jurusan j WHERE j.id_jurusan = k.id_jurusan $urutkan";
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
                    <th><center>Nama Kelas</center></th>
                    <th><center>Jurusan</center></th>
                </tr>
            </thead>
            <tbody>';
                $i = 1;
                foreach ($result as $r) {

                $html .= '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . $config->format_romawi($r['tingkat_kelas']) . " " . ucfirst($r['nama_kelas']) . '</td>
                    <td>' . ucfirst($r['nama_jurusan']) . '</td>
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
