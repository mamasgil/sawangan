<?php
    include '../../config/Config.php';
    $page       = "Laporan Kelas";
    $menu       = "Laporan Kelas";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    
    
    $urutkan = "ORDER BY k.id_kelas " .  $_POST['urutkan'];

    $query = "SELECT * FROM tbl_kelas k, tbl_jurusan j WHERE j.id_jurusan = k.id_jurusan $urutkan";
    $result = $config->getData($query);

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
                <?= @$_SESSION['status']; 
                    unset($_SESSION['status']);
                ?>
                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title">Data <?= $page; ?></h3>

                        <ul class="panel-controls">
                            <a href="cetak.php?urutkan=<?= $_POST['urutkan']; ?>"  class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Cetak</a>

                            <a href="download.php?urutkan=<?= $_POST['urutkan']; ?>" target="_blank" class="btn btn-danger"><i class="fa fa-external-link"></i>Download PDF</a>
                        </ul>

                                                       
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><center>No</center></th>
                                    <th><center>Nama Kelas</center></th>
                                    <th><center>Jurusan</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    foreach ($result as $r) {
                                ?>

                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $config->format_romawi($r['tingkat_kelas']); ?> <?= ucfirst($r['nama_kelas']); ?></td>
                                    <td><?= ucfirst($r['nama_jurusan']); ?></td>
                                </tr>

                                <?php
                                    $i++;
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END DEFAULT DATATABLE -->
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