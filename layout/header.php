<?php
    $id_pegawai     = $_SESSION['id_pegawai'];
    $nip            = $_SESSION['nip'];
    $nama_pegawai   = $_SESSION['nama_pegawai'];
    $alamat_pegawai = $_SESSION['alamat_pegawai'];
    $telp_pegawai   = $_SESSION['telp_pegawai'];
    $foto_pegawai   = $_SESSION['foto_pegawai'];
    $email_pegawai  = $_SESSION['email_pegawai'];
    $password_pegawai     = $_SESSION['password_pegawai'];
    $level_pegawai  = $_SESSION['level_pegawai'];
    $aktif_pegawai  = $_SESSION['aktif_pegawai'];
?>


<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title><?= $page . " | " . $name_application; ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?= $base_url . $logo; ?>" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?= $base_url . 'assets/css/theme-default.css'; ?>"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <?php
                include "sidebar.php";
            ?>
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->

                    <!-- TOGGLE NAVIGATION -->
                    
                    <!-- END TOGGLE NAVIGATION -->

                    <div class="pull-right">
                        <li>
                        <a> <?= $config->ucapan() . ", " . $nama_pegawai; ?> </a>
                        </li>
                        
                        <li>
                            <a href="<?= $base_url. 'page/akun' ?>"><span class="fa fa-cogs"></span>Akun</a>                        
                        </li>

                        <li>
                            <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span>Keluar</a>                        
                        </li> 

                    </div>
                    <!-- MESSAGE BOX-->
                    <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
                        <div class="mb-container">
                            <div class="mb-middle">
                                <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                                <div class="mb-content">
                                    <p>Apakah anda yakin ingin keluar ?</p>                    
                                    <p>Jika anda yakin silahkan pilih tombol Ya</p>
                                </div>
                                <div class="mb-footer">
                                    <div class="pull-right">
                                        <a href="<?= $base_url . 'action/logout.php'; ?>" class="btn btn-success btn-lg">Ya</a>
                                        <button class="btn btn-default btn-lg mb-control-close">Tidak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               
                    
                </ul>
        