<?php
    include '../../config/Config.php';
    $page       = "Pengguna";
    $menu       = "Pengguna";
    $submenu    = "Pengaturan";
    $config = new Config();

    include "hak-akses.php";
    $query = "SELECT * FROM tbl_pegawai ORDER BY id_pegawai DESC";
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
                            <a href="add.php" class="btn btn-info"><i class="fa fa-plus"></i>Tambah Data</a>
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
                                    <th><center>Email</center></th>
                                    <th><center>Level</center></th>
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
                                    <td><?= ucfirst($r['nip']); ?></td>
                                    <td><?= ucfirst($r['nama_pegawai']); ?></td>
                                    <td><?= ucfirst($r['telp_pegawai']); ?></td>
                                    <td><?= ucfirst($r['email_pegawai']); ?></td>
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
                                    <td align="center">
                                        <img src="<?= $base_url . 'assets/img/pegawai/' . $r['foto_pegawai']; ?>" width='100' height='150'><br/>
                                        <a href="update.php?id=<?= $r['id_pegawai']; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> | 
                                        <a href="_action.php?id=<?= $r['id_pegawai']; ?>&foto_pegawai=<?= $r['foto_pegawai']; ?>" class="btn btn-danger" onClick="return confirm('Apakah Anda Yakin Ingin Menghapus Ini?')"><i class="fa fa-times"></i></a>
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