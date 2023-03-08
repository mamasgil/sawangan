<?php
    include '../../config/Config.php';
    $page       = "Laporan Siswa";
    $menu       = "Laporan Siswa";
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
                            <label class="col-md-3 col-xs-12 control-label">Jurusan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="id_jurusan">
                                    <option value="">Semua</option>
                                    <?php
                                        $query_jurusan = $config->getData("SELECT * FROM tbl_jurusan");

                                        foreach ($query_jurusan as $qj) {
                                    ?>
                                            <option value="<?= $qj['id_jurusan']; ?>"><?= $qj['nama_jurusan']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>     
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kelas</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="id_kelas">
                                    <option value="">Semua</option>
                                    <?php
                                        $query_kelas = $config->getData("SELECT * FROM tbl_kelas");

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
                            <label class="col-md-3 col-xs-12 control-label">Angkatan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="angkatan_siswa">
                                    <option value="">Semua</option>
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
                            <label class="col-md-3 col-xs-12 control-label">Status Siswa</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_siswa">
                                    <option value="">Semua</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                    <option value="11">Lulus</option>
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