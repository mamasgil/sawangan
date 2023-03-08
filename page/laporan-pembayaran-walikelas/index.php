<?php
    include '../../config/Config.php';
    $page       = "Laporan Pembayaran";
    $menu       = "Laporan Pembayaran";
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
                            <label class="col-md-3 col-xs-12 control-label">NIS</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input class="form-control" type="text" name="nis" placeholder="Masukan Nomor Induk Siswa" onkeypress="return isNumberKey(event)">     
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kelas</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="id_kelas">
                                    <?php
                                        $query_kelas = $config->getData("SELECT * FROM tbl_kelas WHERE id_pegawai='". $_SESSION['id_pegawai'] ."'");

                                        foreach ($query_kelas as $qk) {
                                    ?>
                                            <option value="<?= $qk['id_kelas']; ?>"><?= $config->format_romawi($qk['tingkat_kelas']); ?> <?= $qk['nama_kelas']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>     
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Pilih Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="id_pembayaran">
                                    <?php
                                        $query_pembayaran = $config->getData('SELECT * FROM tbl_pembayaran');

                                        foreach ($query_pembayaran as $qp) {
                                    ?>
                                            <option value="<?= $qp['id_pembayaran']; ?>"><?= $qp['nama_pembayaran']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>     
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Status Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="status_lunas">
                                    <option value="all">Semua</option>
                                    <option value="LUNAS">Lunas</option>
                                    <option value="BELUM LUNAS">Belum Lunas</option>
                                </select>    
                            </div>
                        </div>
                    </div>

                    
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" type="submit" name="simpan">Cari</button>
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