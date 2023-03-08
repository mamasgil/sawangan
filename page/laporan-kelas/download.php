<?php
    session_start();
    include_once("../../config/Config.php");
    include "../../config/dompdf/dompdf_config.inc.php";

    $page       = "Laporan Kelas";
    $menu       = "Laporan Kelas";
    $submenu    = "Laporan";
    $config = new Config();
    
    include "hak-akses.php";
    
    $urutkan = "ORDER BY k.id_kelas " .  $_GET['urutkan'];

    $query = "SELECT * FROM tbl_kelas k, tbl_jurusan j WHERE j.id_jurusan = k.id_jurusan $urutkan";
    $result = $config->getData($query);


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
                        <th><center>No</center></th>
                        <th><center>Nama Kelas</center></th>
                        <th><center>Jurusan</center></th>
                    </tr>
                ';
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
        </center>
';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($page .' '.time().'.pdf');
?>