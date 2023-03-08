<?php
    include '../../config/Config.php';
    $page       = "Laporan Jenis Pembayaran";
    $menu       = "Laporan Jenis Pembayaran";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    

    if(empty($_POST['aktif_pembayaran'])) {
        $aktif_pembayaran = "";
    }
    if($_POST['aktif_pembayaran']=="0") {
        $aktif_pembayaran = "WHERE aktif_pembayaran='0'";
    }
    if($_POST['aktif_pembayaran']=="1") {
        $aktif_pembayaran = "WHERE aktif_pembayaran='1'";
    }
    
    $urutkan = "ORDER BY id_pembayaran " .  $_POST['urutkan'];

    $query = "SELECT * FROM tbl_pembayaran $aktif_pembayaran $urutkan";
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
                            <a href="cetak.php?aktif_pembayaran=<?= $_POST['aktif_pembayaran']; ?>&urutkan=<?= $_POST['urutkan']; ?>"  class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Cetak</a>

                            <a href="download.php?aktif_pembayaran=<?= $_POST['aktif_pembayaran']; ?>&urutkan=<?= $_POST['urutkan']; ?>" target="_blank" class="btn btn-danger"><i class="fa fa-external-link"></i>Download PDF</a>
                        </ul>

                                                       
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><center>No</center></th>
                                    <th><center>Nama Pembayaran</center></th>
                                    <th><center>Nominal</center></th>
                                    <th><center>Jumlah Cicilan</center></th>
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
                                    <td><?= ucfirst($r['nama_pembayaran']); ?></td>
                                    <td><?= $config->format_rupiah(ucfirst($r['nominal_pembayaran'])); ?></td>
                                    <td><?= ucfirst($r['jumlah_cicilan']); ?> x</td>
                                    <td>
                                        <?php
                                            if($r['aktif_pembayaran']=='1') {
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