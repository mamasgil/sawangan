<?php
    include '../../config/Config.php';
    $page       = "Ubah Hak Akses";
    $menu       = "Hak Akses";
    $submenu    = "Pengaturan";
    $config = new Config();

    include "hak-akses.php";

// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {
    include "../../layout/header.php";
    $id = $_GET['id'];
    $result = $config->getData("SELECT * FROM tbl_hak_akses WHERE level_pegawai='$id'");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."page/hak-akses';
                </script>");
    }

    foreach ($result as $r):    
?> 
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="<?= $base_url; ?>">Home</a></li>
        <li><?= $submenu; ?></li>    
        <li class="active"><?= $page; ?></li>
    </ul>
    <!-- END BREADCRUMB -->   

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
    
        <div class="row">
            <div class="col-md-12">
                
                <form class="form-horizontal" action="_action.php" method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $page; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Level Pegawai</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="level_pegawai" placeholder="Masukan Level Pegawai" required="" value="<?= $r['level_pegawai']; ?>"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Hak Akses</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="hak_akses">
                                    <?php 
                                        if($r['hak_akses']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jurusan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="jurusan">
                                    <?php 
                                        if($r['jurusan']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kelas</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="kelas">
                                    <?php 
                                        if($r['kelas']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Pengguna</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="pengguna">
                                    <?php 
                                        if($r['pengguna']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Siswa</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="siswa">
                                    <?php 
                                        if($r['siswa']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Laporan Jenis Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="laporan_jenis_pembayaran">
                                    <?php 
                                        if($r['laporan_jenis_pembayaran']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Laporan Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="laporan_pembayaran">
                                    <?php 
                                        if($r['laporan_pembayaran']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Laporan Siswa</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="laporan_siswa">
                                    <?php 
                                        if($r['laporan_siswa']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Laporan Jurusan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="laporan_jurusan">
                                    <?php 
                                        if($r['laporan_jurusan']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Laporan Kelas</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="laporan_kelas">
                                    <?php 
                                        if($r['laporan_kelas']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Laporan Pengguna</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="laporan_pengguna">
                                    <?php 
                                        if($r['laporan_pengguna']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Backup</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="backup">
                                    <?php 
                                        if($r['backup']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="pembayaran">
                                    <?php 
                                        if($r['pembayaran']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Transaksi</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="transaksi">
                                    <?php 
                                        if($r['transaksi']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Hapus Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="hapus_pembayaran">
                                    <?php 
                                        if($r['hapus_pembayaran']=='0') { 
                                            echo '<option value="0" selected="">Tidak</option>';
                                            echo '<option value="1">Ya</option>'; 
                                             
                                        } else {
                                            echo '<option value="0">Tidak</option>';
                                            echo '<option value="1" selected="">Ya</option>'; 
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>
                    </div>

                    
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" name="update">Ubah</button>
                    </div>
                </div>
                </form>
                
            </div>
        </div>                    
        
    </div>
    <!-- END PAGE CONTENT WRAPPER -->                                                
<?php
    endforeach;
    include "../../layout/footer.php";
} else {
    header("Location:" . $base_url . "login.php");
}
  

?>          


