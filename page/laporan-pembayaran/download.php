<?php
    session_start();
    include_once("../../config/Config.php");
    include "../../config/dompdf/dompdf_config.inc.php";

    $page       = "Laporan Pembayaran";
    $menu       = "Laporan Pembayaran";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    set_time_limit(0);
    if(($_GET['nis']<>'') OR ($_GET['id_kelas']<>'all') OR ($_GET['aktif_siswa']<>'all') OR ($_GET['angkatan_siswa']) OR ($_GET['tingkat_kelas']<>'all')) {

        $where = " WHERE";
        
    }

    else {
        $where = "";
    }

    if(($_GET['nis']=='')) {
        $nis = "";
    }
    else {
        $nis = " AND tbl_siswa.nis='" . $_GET['nis'] . "'";
    }

    if($_GET['id_kelas']=='all') {
        $id_kelas = "";
    }
    else {
        $id_kelas = " AND tbl_siswa.id_kelas='" . $_GET['id_kelas'] . "'";
    }

    if(($_GET['id_jurusan']=='all')) {
        $id_jurusan = "";
    }
    else {
        $id_jurusan = " AND tbl_kelas.id_jurusan='" . $_GET['id_jurusan'] . "'";
    }

    if($_GET['aktif_siswa']=='all') {
        $aktif_siswa = "";
    }
    else {
        $aktif_siswa = " AND tbl_siswa.aktif_siswa='" . $_GET['aktif_siswa'] . "'";
    }

    if($_GET['angkatan_siswa']=='all') {
        $angkatan_siswa = "";
    }
    else {
        $angkatan_siswa = " AND tbl_siswa.angkatan_siswa='" . $_GET['angkatan_siswa'] . "'";
    }

    if($_GET['tingkat_kelas']=='all') {
        $tingkat_kelas = "";
    }
    else {
        $tingkat_kelas = " AND tbl_kelas.tingkat_kelas='" . $_GET['tingkat_kelas'] . "'";
    }


$html =
'
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
        table, td, th {
            border: 1px solid black;
            padding: 10px;
            }
            table {
            border-collapse: collapse;
            width: 100%;
            }
            th {
            height: 50px;
            }
        </style>
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
                
                    <tr>
                        <th><center>NIS</center></th>
                        <th><center>Nama</center></th>
                        <th><center>Kelas</center></th>
                        <th><center>Angkatan</center></th>
                        <th><center>Nama Pembayaran</center></th>
                        <th><center>Total Pembayaran</center></th>
                        <th><center>Sisa Pembayaran</center></th>
                        <th><center>Status</center></th>
                    </tr>
                
                ';


            if($_GET['id_pembayaran']=='all') {
            $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran"); 
        } else {
            $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran WHERE id_pembayaran='". $_GET['id_pembayaran'] ."'");
        }

        foreach ($pembayaran as $p) {
            $id_kelas_pembayaran = $config->clean_json($p['id_kelas']);
            $query = "SELECT * FROM tbl_siswa INNER JOIN tbl_kelas ON tbl_kelas.id_kelas = tbl_siswa.id_kelas INNER JOIN tbl_jurusan ON tbl_kelas.id_jurusan = tbl_jurusan.id_jurusan $where tbl_siswa.foto_siswa <> 'sdjhashahsghdvhhdbagusgantengamatbshdhavhs' $id_kelas $nis $aktif_siswa $angkatan_siswa $tingkat_kelas $id_jurusan AND tbl_siswa.id_kelas IN (". $id_kelas_pembayaran .") "; 
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
                    <td>' . $config->format_romawi(ucfirst($r['tingkat_kelas'])) . " " . ucfirst($r['nama_kelas']) . '</td>
                    <td>'. ucfirst($r['angkatan_siswa']) .'</td>
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
                    <td>' . $config->format_romawi(ucfirst($r['tingkat_kelas'])). " " . ucfirst($r['nama_kelas']) . '</td>
                    <td>'. ucfirst($r['angkatan_siswa']) .'</td>
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
                
            </table>
        </center>
';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($page .' '.time().'.pdf');
?>