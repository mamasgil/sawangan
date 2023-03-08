<?php
    include '../../config/Config.php';
    $page       = "Laporan Jenis Pembayaran";
    $menu       = "Laporan Jenis Pembayaran";
    $submenu    = "Laporan";
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
                <form class="form-horizontal" action="view.php" method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Filter <?= $page; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Urutkan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="urutkan">
                                    <option value="ASC">Terlama</option>
                                    <option value="DESC">Terbaru</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tampilkan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_pembayaran">
                                    <option value="">Semua</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>    
                            </div>
                        </div>
                    </div>

                    
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" name="simpan" type="submit">Cari</button>
                    </div>
                </div>
                </form>
            </div>
        </div>                                
        
    </div>
    <!-- PAGE CONTENT WRAPPER -->

<?php
    include "../../layout/footer.php";
} else {
    header("Location:" . $base_url . "login.php");
}

?>