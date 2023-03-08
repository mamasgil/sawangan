<?php
    include '../../config/Config.php';
    $page       = "Tambah Pengguna";
    $menu       = "Pengguna";
    $submenu    = "Pengaturan";
    $config = new Config();

    include "hak-akses.php";
// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {   
    include "../../layout/header.php";    
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
                            <label class="col-md-3 col-xs-12 control-label">Nomor Induk Pegawai</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nip" placeholder="Masukan Nomor Induk Pegawai" required="" onkeypress="return isNumberKey(event)" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Lengkap</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_pegawai" placeholder="Masukan Nama Lengkap Pegawai" required=""/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Alamat Lengkap</label>
                            <div class="col-md-6 col-xs-12">   
                                <textarea class="form-control" rows="5" name="alamat_pegawai" placeholder="Masukan Alamat Lengkap Pegawai" required=""></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Telepon</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="telp_pegawai" placeholder="Masukan Telepon Pegawai" required=""/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Foto</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="file" accept='image/*' class="fileinput btn-primary" name="fupload" title="Browse file"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Email</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="email" class="form-control" name="email_pegawai" placeholder="Masukan Email Pegawai" required=""/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Password</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" placeholder="Password Sama dengan Nomor Telepon" required="" readonly="" />    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Level</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="level_pegawai">
                                    <option value="Wali rumah">Wali rumah</option>
                                    <option value="Pegawai">Pegawai</option>
                                    <option value="Admin">Admin</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Aktif</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_pegawai">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" name="simpan">Simpan</button>
                    </div>
                </div>
                </form>
                
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


