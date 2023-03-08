<?php
    include '../../config/Config.php';
    $page       = "Jurusan";
    $menu       = "Jurusan";
    $submenu    = "Data Master";
    $config = new Config();
    include "hak-akses.php";
    
    $query = "SELECT * FROM tbl_jurusan ORDER BY id_jurusan DESC";
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
                                    <th><center>Nama Blok</center></th>
                                    <th><center>Deskripsi Blok</center></th>
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
                                    <td><?= ucfirst($r['nama_jurusan']); ?></td>
                                    <td><?= ucfirst($r['diskripsi_jurusan']); ?></td>
                                    <td align="center">
										<?php 
											$id1 =base64_encode($r['id_jurusan']);
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