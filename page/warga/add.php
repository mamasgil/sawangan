<?php
    include '../../config/Config.php';
    $page       = "Tambah warga";
    $menu       = "warga";
    $submenu    = "Data Master";
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
                            <label class="col-md-3 col-xs-12 control-label">Nomor Induk warga</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nis" placeholder="Masukan Nomor Induk warga" required="" onkeypress="return isNumberKey(event)" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Lengkap</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_warga" placeholder="Masukan Nama Lengkap warga" required=""/>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jenis Kelamin</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="jekel_warga">
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Alamat Lengkap</label>
                            <div class="col-md-6 col-xs-12">   
                                <textarea class="form-control" rows="5" name="alamat_warga" placeholder="Masukan Alamat Lengkap warga" required=""></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Foto</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="file" accept='image/*' class="fileinput btn-primary" name="fupload" title="Browse file"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Rumah</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="id_rumah" placeholder="Masukan Nomor Rumah" required=""/>    
                            </div>
                        </div>
                        
                        

                        

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Aktif</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_warga">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                    <option value="11">Lulus</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Angkatan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="angkatan_warga">
                                    <?php
                                        $date = date('Y');
                                        $datelimit = $date - 10;
                                        for ($i=$date; $i > $datelimit; $i--) { 
                                            echo "<option value='" . $date . "'>" . $date . "</option>";

                                            $date--;
                                        }
                                    ?>
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


