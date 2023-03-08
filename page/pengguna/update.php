<?php
    include '../../config/Config.php';
    $page       = "Ubah Pengguna";
    $menu       = "Pengguna";
    $submenu    = "Pengaturan";
    $config = new Config();

    include "hak-akses.php";
    
// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {
    include "../../layout/header.php";
    $id = $_GET['id'];
    $result = $config->getData("SELECT * FROM tbl_pegawai WHERE id_pegawai='$id'");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."page/pengguna';
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
                        <input type="hidden" class="form-control" name="id_pegawai" required="" value="<?= $r['id_pegawai']; ?>" />
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Induk Pegawai</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nip" placeholder="Masukan Nomor Induk Pegawai" required="" value="<?= $r['nip']; ?>" onkeypress="return isNumberKey(event)" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Pegawai</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_pegawai" placeholder="Masukan Nama Lengkap Pegawai" required="" value="<?= $r['nama_pegawai']; ?>"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Alamat Lengkap</label>
                            <div class="col-md-6 col-xs-12">   
                                <textarea class="form-control" rows="5" name="alamat_pegawai" placeholder="Masukan Alamat Lengkap Pegawai" required=""><?= $r['alamat_pegawai']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Telepon</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="telp_pegawai" placeholder="Masukan Telepon Pegawai" required="" value="<?= $r['telp_pegawai']; ?>" onkeypress="return isNumberKey(event)"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Foto</label>
                            <div class="col-md-6 col-xs-12">
                                <img src="<?= $base_url . 'assets/img/pegawai/' . $r['foto_pegawai']; ?>" width='200' height='300'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Level</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="level_pegawai">
                                    <?php 
                                        if($r['level_pegawai']=='Pegawai') { 
                                            echo '<option value="Pegawai" selected="">Pegawai</option>';
                                            echo '<option value="Admin">Admin</option>';
                                            echo '<option value="Wali Kelas">Wali Kelas</option>'; 
                                             
                                        } 
                                        else if($r['level_pegawai']=='Admin') { 
                                            echo '<option value="Pegawai">Pegawai</option>';
                                            echo '<option value="Admin" selected="">Admin</option>'; 
                                            echo '<option value="Wali Kelas">Wali Kelas</option>';
                                             
                                        }else {
                                            echo '<option value="Pegawai">Pegawai</option>';
                                            echo '<option value="Admin">Admin</option>'; 
                                            echo '<option value="Wali Kelas" selected="">Wali Kelas</option>'; 
                                            
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Aktif</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_pegawai">
                                    <?php 
                                        if($r['aktif_pegawai']=='1') { 
                                            echo '<option value="1" selected="">Aktif</option>';
                                            echo '<option value="0">Tidak Aktif</option>'; 
                                             
                                        } else {
                                            echo '<option value="1">Aktif</option>';
                                            echo '<option value="0" selected="">Tidak Aktif</option>'; 
                                            
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


