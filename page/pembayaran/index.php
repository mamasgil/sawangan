<?php
    include '../../config/Config.php';
    $page       = "Pembayaran";
    $menu       = "Pembayaran";
    $submenu    = "";
    $config = new Config();
    include "hak-akses.php";
    
    $query = "SELECT * FROM tbl_pembayaran ORDER BY id_pembayaran DESC";
    $result = $config->getData($query);

// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {   
    include "../../layout/header.php";    
?>      
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="<?= $base_url; ?>">Home</a></li>
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
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                            <ul class="dropdown-menu">
                                <li><a href="export.php">Export Excel</a></li>
                                <li><a href="import.php">Import Excel</a></li>
                            </ul>
                        </div>

                        <ul class="panel-controls">
                            <a href="add.php" class="btn btn-info"><i class="fa fa-plus"></i>Tambah Data</a>
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
                                    <th><center>Opsi</center></th>
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
                                    <td align="center">
										<?php 
											$id1 =base64_encode($r['id_pembayaran']);
											$id2 =base64_encode($id1);
											$id3 =base64_encode($id2);
										?>
                                        <a href="update.php?id=<?= $id3; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="_action.php?id=<?= $id3; ?>" class="btn btn-danger" onClick="return confirm('Apakah Anda Yakin Ingin Menghapus Ini?')"><i class="fa fa-times"></i></a>
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