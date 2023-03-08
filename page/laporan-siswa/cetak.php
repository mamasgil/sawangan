<?php
    include '../../config/Config.php';
    $page       = "Laporan Siswa";
    $menu       = "Laporan Siswa";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    

    if(empty($_GET['id_jurusan'])) {
        $id_jurusan = "";
    }

    else {
        $id_jurusan = "AND tbl_kelas.id_jurusan='" . $_GET['id_jurusan'] ."'";
    }

    if(empty($_GET['id_kelas'])) {
        $id_kelas = "";
    }

    else {
        $id_kelas = "AND tbl_siswa.id_kelas='" . $_GET['id_kelas'] ."'";
    }

    if(empty($_GET['angkatan'])) {
        $angkatan = "";
    }

    else {
        $angkatan = "AND tbl_siswa.angkatan_siswa='" . $_GET['angkatan_siswa'] ."'";
    }
    if(empty($_GET['aktif_siswa'])) {
        $aktif_siswa = "";
    }

    else {
        $aktif_siswa = "AND tbl_siswa.aktif_siswa='" . $_GET['aktif_siswa'] ."'";
    }
    
    $urutkan = "ORDER BY tbl_siswa.id_siswa " .  $_GET['urutkan'];


    $query = "SELECT * FROM tbl_siswa, tbl_kelas, tbl_jurusan WHERE tbl_siswa.id_kelas = tbl_kelas.id_kelas AND tbl_jurusan.id_jurusan = tbl_kelas.id_jurusan $id_jurusan $id_kelas $angkatan $aktif_siswa $urutkan";
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
                    <th><center>NIS</center></th>
                    <th><center>Nama</center></th>
                    <th><center>Jenis Kelamin</center></th>
                    <th><center>Jurusan</center></th>
                    <th><center>Kelas</center></th>
                    <th><center>Angkatan</center></th>
                </tr>
            </thead>
            <tbody>';
                $i = 1;
                foreach ($result as $r) {

                $html .= '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . ucfirst($r['nis']) . '</td>
                    <td>' . ucfirst($r['nama_siswa']) . '</td>
                    <td>' . ucfirst($r['jekel_siswa']) . '</td>
                    <td>' . ucfirst($r['nama_jurusan']) . '</td>
                    <td>' . $config->format_romawi($r['tingkat_kelas']) . " " . ucfirst($r['nama_kelas']) . '</td>
                    <td>' . ucfirst($r['angkatan_siswa']) . '</td>
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
