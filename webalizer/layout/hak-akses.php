<?php
    $level_pegawai = $_SESSION['level_pegawai'];
    $hak_akses = $config->getData("SELECT * FROM tbl_hak_akses WHERE level_pegawai = '". $level_pegawai ."'");
?>