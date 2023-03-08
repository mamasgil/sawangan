<?php
    include '../../config/Config.php';
    $page       = "Ubah Akun";
    $menu       = "Akun";
    $submenu    = "Pengaturan";
    $config = new Config();

// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {
    include "../../layout/header.php";
    $id = $id_pegawai;
    $result = $config->getData("SELECT * FROM tbl_pegawai WHERE id_pegawai='$id'");
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
                <?= @$_SESSION['status']; 
                    unset($_SESSION['status']);
                ?>
                <form class="form-horizontal" action="_action.php" method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $page; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Induk Pegawai</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nip" placeholder="Masukan Nomor Induk Pegawai" required="" value="<?= $r['nip']; ?>" onkeypress="return isNumberKey(event)" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Lengkap</label>
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
                                <input type="text" class="form-control" name="telp_pegawai" placeholder="Masukan Nomor Telepon" required="" value="<?= $r['telp_pegawai']; ?>" onkeypress="return isNumberKey(event)"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Foto</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="file" accept='image/*' class="fileinput btn-primary" name="fupload" title="Browse file"/><br/>
                                <input type="hidden" name="fupload_lama" value="<?= $r['foto_pegawai']; ?>" />
                                <img src="<?= $base_url . 'assets/img/pegawai/' . $r['foto_pegawai']; ?>" width='200' height='300'>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Email</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="email" class="form-control" name="email_pegawai" placeholder="Masukan Email Pegawai" required="" value="<?= $r['email_pegawai']; ?>"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Password</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="password" class="form-control" name="password_pegawai" placeholder="Masukan Password Jika Ingin Mengganti"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Ulangi Password</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="password" class="form-control" name="repassword_pegawai" placeholder="Masukan Password Jika Ingin Mengganti"/>    
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


