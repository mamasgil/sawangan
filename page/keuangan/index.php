<?php
    include '../../config/Config.php';
    $page       = ucfirst("Dashboard");
    $menu       = ucfirst("Dashboard");
    $submenu    = "";
    $config = new Config();

// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {   
    include "../../layout/header.php";    
?>    
    
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="<?= $base_url; ?>">Home</a></li>    
            <li class="active">Dashboard</li>
        </ul>
        <!-- END BREADCRUMB -->                
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> <?= $page; ?></h2>
        </div>                   
        
        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            
            <!-- START WIDGETS -->                    
            <div class="row">
                <div class="col-md-3">                        
                    <a href="<?= $base_url . 'page/transaksi' ?>" class="tile tile-primary">
                        <i class="fa fa-shopping-cart"></i>
                        <p>Transaksi Pembayaran</p>
                    </a>                        
                </div>

                <div class="col-md-3">                        
                    <a href="<?= $base_url . 'page/pembayaran/add.php' ?>" class="tile tile-danger">
                        <i class="fa fa-money"></i>
                        <p>Tambah Pembayaran</p>
                    </a>                        
                </div>

                <div class="col-md-3">                        
                    <a href="<?= $base_url . 'page/siswa' ?>" class="tile tile-info">
                        <i class="fa fa-user"></i>
                        <p>Daftar Siswa</p>
                    </a>                        
                </div>

                <div class="col-md-3">
                    
                    <!-- START WIDGET CLOCK -->
                    <div class="widget widget-success widget-padding-sm">
                        <br/>
                        <div class="widget-big-int plugin-clock">00:00</div>                            
                        <div class="widget-subtitle plugin-date">Loading...</div>
                                                  
                    </div>                        
                    <!-- END WIDGET CLOCK --> 
                </div>

                <div class="col-md-3">
                    
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon" onclick="location.href='#';">
                        <div class="widget-item-left">
                            <span class="fa fa-user"></span>
                        </div>                             
                        <div class="widget-data">
                            <div class="widget-int num-count">
                                <?php
                                    $pengguna = $config->getData("SELECT count(*) as total FROM tbl_pegawai WHERE aktif_pegawai='1'");
                                    foreach ($pengguna as $p) {
                                       
                                        echo $p['total'];
                                    }
                                ?>
                            </div>
                            <div class="widget-title">Pengguna</div>
                            <div class="widget-subtitle">Aplikasi Ini</div>
                        </div>      
                    </div>                            
                    <!-- END WIDGET MESSAGES -->
                    
                </div>
                <div class="col-md-3">
                    
                    <!-- START WIDGET REGISTRED -->
                    <div class="widget widget-default widget-item-icon" onclick="location.href='#';">
                        <div class="widget-item-left">
                            <span class="fa fa-users"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count">
                                <?php
                                    $siswa = $config->getData("SELECT count(*) as total FROM tbl_siswa WHERE aktif_siswa='1'");
                                    foreach ($siswa as $p) {
                                       
                                        echo $p['total'];
                                    }
                                ?>
                            </div>
                            <div class="widget-title">Siswa Aktif</div>
                            <div class="widget-subtitle"><?= $company; ?></div>
                        </div>
                                                 
                    </div>                            
                    <!-- END WIDGET REGISTRED -->                  
                </div>

                <div class="col-md-3">
                    
                    <!-- START WIDGET REGISTRED -->
                    <div class="widget widget-default widget-item-icon" onclick="location.href='#';">
                        <div class="widget-item-left">
                            <span class="fa fa-home"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count">
                                <?php
                                    $kelas = $config->getData("SELECT count(*) as total FROM tbl_kelas");
                                    foreach ($kelas as $p) {
                                       
                                        echo $p['total'];
                                    }
                                ?>
                            </div>
                            <div class="widget-title">Jumlah Kelas</div>
                            <div class="widget-subtitle"><?= $company; ?></div>
                        </div>
                                                 
                    </div>                            
                    <!-- END WIDGET REGISTRED -->
                    
                </div>

                <div class="col-md-3">
                    
                    <!-- START WIDGET REGISTRED -->
                    <div class="widget widget-default widget-item-icon" onclick="location.href='#';">
                        <div class="widget-item-left">
                            <span class="fa fa-desktop"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count">
                                <?php
                                    $jurusan = $config->getData("SELECT count(*) as total FROM tbl_jurusan");
                                    foreach ($jurusan as $p) {
                                        echo $p['total'];
                                    }
                                ?>
                            </div>
                            <div class="widget-title">Jumlah Jurusan</div>
                            <div class="widget-subtitle"><?= $company; ?></div>
                        </div>
                                                 
                    </div>                            
                    <!-- END WIDGET REGISTRED -->
                    
                </div>

                
                
            </div>
            <!-- END WIDGETS -->                    
            
            <div class="row">
                <div class="col-md-4">
                    <!-- CONTACT LIST WIDGET -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Riwayat Pembayaran</h3>
                        </div>
                        <div class="panel-body list-group list-group-contacts">
                            <?php

                                $histori = $config->getData("SELECT * FROM tbl_transaksi t, tbl_pembayaran p, tbl_siswa s WHERE t.id_siswa = s.id_siswa AND t.id_pembayaran = p.id_pembayaran ORDER BY t.id_transaksi DESC limit 5");
                                foreach ($histori as $h) {
                            ?>   
                            <a class="list-group-item">
                                <img src="<?= $base_url . 'assets/img/siswa/' . $h['foto_siswa'];  ?>" class="pull-left img-circle" alt="Brad Pitt"/>
                                <span class="contacts-title"><?= substr($h['nama_siswa'] ,0, 30)?></span>
                                <p>Membayar <?= $h['nama_pembayaran'] ?> senilai <?= $config->format_rupiah($h['nominal_transaksi']); ?></p>                               
                            </a>
                            <?php
                                }
                            ?>
                                                            
                        </div>
                    </div>
                    <!-- END CONTACT LIST WIDGET -->

                </div>

                <div class="col-md-4">
                    <!-- CONTACT LIST WIDGET -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Riwayat Aktifitas</h3>
                        </div>
                        <div class="panel-body list-group list-group-contacts">
                            <?php
                                $aktifitas = $config->getData("SELECT * FROM tbl_history t, tbl_pegawai p WHERE t.id_pegawai = p.id_pegawai ORDER BY id_history DESC limit 5");
                                foreach ($aktifitas as $h) {
                            ?>   
                            <a class="list-group-item">
                                <img src="<?= $base_url . 'assets/img/pegawai/' . $h['foto_pegawai'];  ?>" class="pull-left img-circle" alt="Brad Pitt"/>
                                <span class="contacts-title"><?= substr($h['nama_pegawai'] ,0, 30)?></span>
                                <p><?= $h['keterangan_history'] ?>  pada <i> <?= date("d-m-Y H:i:s", strtotime($h['waktu_history'])); ?></i></p>                               
                            </a>
                            <?php
                                }
                            ?>
                                                            
                        </div>
                    </div>
                    <!-- END CONTACT LIST WIDGET -->

                </div>

                <div class="col-md-4">
                    <!-- CONTACT LIST WIDGET -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Daftar Pembayaran</h3>
                        </div>
                        <div class="panel-body list-group list-group-contacts">
                            <?php

                                $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran limit 5");
                                foreach ($pembayaran as $p) {
                            ?>   
                            <a class="list-group-item">
                                <span class="contacts-title"><?= substr($p['nama_pembayaran'] ,0, 30)?></span>
                                <p><?= $config->format_rupiah($p['nominal_pembayaran']); ?></p>                               
                            </a>
                            <?php
                                }
                            ?>
                                                            
                        </div>
                    </div>
                    <!-- END CONTACT LIST WIDGET -->

                </div>
            </div>            
        </div>
        <!-- END PAGE CONTENT WRAPPER -->                
    

<?php
    include "../../layout/footer.php";
} else {
    header("Location:" . $base_url . "login.php");
}

?>






