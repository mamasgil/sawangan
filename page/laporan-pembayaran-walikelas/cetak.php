<?php
    include '../../config/Config.php';
    $page       = "Laporan Pembayaran";
    $menu       = "Laporan Pembayaran";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    
    if(($_GET['nis']=='')) {
        $nis = "";
    }
    else {
        $nis = " AND tbl_siswa.nis='" . $_GET['nis'] . "'";
    }


    $id_kelas = " AND tbl_siswa.id_kelas='" . $_GET['id_kelas'] . "'";
    $aktif_siswa = " AND tbl_siswa.aktif_siswa='1'";
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
                    <th><center>NIS</center></th>
                    <th><center>Nama</center></th>
                    <th><center>Nama Pembayaran</center></th>
                    <th><center>Total Pembayaran</center></th>
                    <th><center>Sisa Pembayaran</center></th>
                    <th><center>Status</center></th>
                </tr>
            </thead>
            <tbody>';


        if($_GET['id_pembayaran']=='all') {
            $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran"); 
        } else {
            $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran WHERE id_pembayaran='". $_GET['id_pembayaran'] ."'");
        }

        foreach ($pembayaran as $p) {
            $id_kelas_pembayaran = $config->clean_json($p['id_kelas']);
            $query = "SELECT * FROM tbl_siswa INNER JOIN tbl_kelas ON tbl_kelas.id_kelas = tbl_siswa.id_kelas WHERE tbl_siswa.foto_siswa <> 'sdjhashahsghdvhhdbagusgantengamatbshdhavhs' $id_kelas $nis $aktif_siswa AND tbl_siswa.id_kelas IN (". $id_kelas_pembayaran .") "; 
            $result = $config->getData($query);
            foreach ($result as $r) {
                $transaksi = $config->getData("SELECT * FROM tbl_transaksi WHERE id_siswa='". $r['id_siswa'] ."' AND id_pembayaran='". $p['id_pembayaran'] ."' GROUP BY id_pembayaran");

                if(!empty($transaksi)) {
                    foreach ($transaksi as $t) {
                        $kurang = $config->getData("SELECT SUM(nominal_transaksi) as nominal FROM tbl_transaksi WHERE id_siswa='". $r['id_siswa'] ."' AND id_pembayaran='". $p['id_pembayaran'] ."'");
                        foreach ($kurang as $k) {
                            $nilai_pembayaran = $p['nominal_pembayaran'];
                            $sisa_pembayaran = $nilai_pembayaran  - $k['nominal'];
                            if ($sisa_pembayaran<=0) {
                               $keterangan_pembayaran = "LUNAS";
                            } 
                            else if($sisa_pembayaran>0) {
                                $keterangan_pembayaran = "BELUM LUNAS";
                            }

                            if(($_GET['status_lunas']==$keterangan_pembayaran) OR ($_GET['status_lunas']=='all')){

                $html .= '
                <tr>
                    <td>' . ucfirst($r['nis']) . '</td>
                    <td>' . ucfirst($r['nama_siswa']) . '</td>
                    <td>' . ucfirst($p['nama_pembayaran']). " (" . $config->format_rupiah(ucfirst($p['nominal_pembayaran'])) . ')</td>
                    <td>' . $config->format_rupiah($k['nominal']) . '</td>
                    <td>' . $config->format_rupiah($sisa_pembayaran) . '</td>
                    <td>' . $keterangan_pembayaran . '</td>
                </tr>
                ';
                            }
                       }
                    }
                }
                else {
                    if(($_GET['status_lunas']<>'LUNAS')){
            $html .= '
                <tr>
                    <td>' . ucfirst($r['nis']) . '</td>
                    <td>' . ucfirst($r['nama_siswa']) . '</td>
                    <td>' . ucfirst($p['nama_pembayaran']). " (" . $config->format_rupiah(ucfirst($p['nominal_pembayaran'])) . ')</td>
                    <td>Rp. 0</td>
                    <td>'. $config->format_rupiah(ucfirst($p['nominal_pembayaran'])) .'</td>
                    <td>BELUM LUNAS</td>
                </tr>';
                    }
                }
            }
        }
            $html .='
            </tbody>
        </table>
        </center>';

        echo $html;
        ?>
    </body>
    
</html>
