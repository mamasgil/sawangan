<?php
    include '../../config/Config.php';
    $page       = "Laporan Pengguna";
    $menu       = "Laporan Pengguna";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    

    if(empty($_POST['aktif_pegawai'])) {
        $aktif_pegawai = "";
    }
    if($_POST['aktif_pegawai']=="0") {
        $aktif_pegawai = "WHERE aktif_pegawai='0'";
    }
    if($_POST['aktif_pegawai']=="1") {
        $aktif_pegawai = "WHERE aktif_pegawai='1'";
    }
    
    $urutkan = "ORDER BY id_pegawai " .  $_POST['urutkan'];

    $query = "SELECT * FROM tbl_pegawai $aktif_pegawai $urutkan";
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
                            <a href="cetak.php?aktif_pegawai=<?= $_POST['aktif_pegawai']; ?>&urutkan=<?= $_POST['urutkan']; ?>"  class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Cetak</a>

                            <a href="download.php?aktif_pegawai=<?= $_POST['aktif_pegawai']; ?>&urutkan=<?= $_POST['urutkan']; ?>" target="_blank" class="btn btn-danger"><i class="fa fa-external-link"></i>Download PDF</a>
                        </ul>

                                                       
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><center>No</center></th>
                                    <th><center>NIP</center></th>
                                    <th><center>Nama</center></th>
                                    <th><center>Telepon</center></th>
                                    <th><center>Level</center></th>
                                    <th><center>Aktif</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    foreach ($result as $r) {
                                ?>

                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= ucfirst($r['nip']); ?></td>
                                    <td><?= ucfirst($r['nama_pegawai']); ?></td>
                                    <td><?= ucfirst($r['telp_pegawai']); ?></td>
                                    <td><?= ucfirst($r['level_pegawai']); ?></td>
                                    <td>
                                        <?php
                                            if($r['aktif_pegawai']=='1') {
                                                echo "Aktif";
                                            } else {
                                                echo "Tidak Aktif";
                                            }
                                        ?>
                                    </td>

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