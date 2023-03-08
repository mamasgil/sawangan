<?php
    $level_pegawai = $_SESSION['level_pegawai'];
    $hak_akses = $config->getData("SELECT * FROM tbl_hak_akses WHERE level_pegawai = '". $level_pegawai ."' AND laporan_pembayaran ='1'");
    if(empty($hak_akses)) {
        echo ("<script LANGUAGE='JavaScript'>
                window.alert('Maaf, Anda Tidak diizinkan Mengakses Halaman Ini');
                window.location.href='". $base_url ."page/dashboard';
                </script>");
    }
?>