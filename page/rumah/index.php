<?php
    include '../../config/Config.php';
    $page       = "Rumah";
    $menu       = "Rumah";
    $submenu    = "Data Master";
    $config = new Config();

    include "hak-akses.php";

    $query = "SELECT * FROM tbl_rumah LEFT JOIN tbl_jurusan ON tbl_rumah.id_jurusan = tbl_jurusan.id_jurusan INNER JOIN tbl_pegawai ON tbl_rumah.id_pegawai = tbl_pegawai.id_pegawai ORDER BY tbl_rumah.id_rumah DESC";
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
                                    <th><center>No Rumah</center></th>
                                    <th><center>Jurusan</center></th>
                                    <th><center>Wali rumah</center></th>
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
                                    <td><?= $config->format_romawi(ucfirst($r['tingkat_rumah'])); ?> <?= ucfirst($r['nama_rumah']); ?></td>
                                    <td><?= ucfirst($r['nama_jurusan']); ?></td>
                                    <td><?= ucfirst($r['nama_pegawai']); ?></td>
                                    <?php 
										$id1 =base64_encode($r['id_rumah']);
										$id2 =base64_encode($id1);
										$id3 =base64_encode($id2);
									?>
                                    <td align="center">
                                        <a href="update.php?id=<?= $id3; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="_action.php?id=<?= $id3; ?>" class="btn btn-danger" onClick="return confirm('Data warga yang ada dirumah ini akan terhapus juga, Apakah Anda Yakin ingin menghapusnya ?')"><i class="fa fa-times"></i></a>
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