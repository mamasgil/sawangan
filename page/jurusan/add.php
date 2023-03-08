<?php
    include '../../config/Config.php';
    $page       = "Tambah Jurusan";
    $menu       = "Jurusan";
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
                            <label class="col-md-3 col-xs-12 control-label">Nama Jurusan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_jurusan" placeholder="Masukan Nama Jurusan" required=""/>    
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Diskripsi</label>
                            <div class="col-md-6 col-xs-12">   
                                <textarea class="form-control" rows="5" name="diskripsi_jurusan" placeholder="Masukan Diskripsi" required=""></textarea>
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


