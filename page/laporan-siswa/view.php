<?php
    include '../../config/Config.php';
    $page       = "Laporan Siswa";
    $menu       = "Laporan Siswa";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    

    if(empty($_POST['id_jurusan'])) {
        $id_jurusan = "";
    }

    else {
        $id_jurusan = "AND tbl_kelas.id_jurusan='" . $_POST['id_jurusan'] ."'";
    }

    if(empty($_POST['id_kelas'])) {
        $id_kelas = "";
    }

    else {
        $id_kelas = "AND tbl_siswa.id_kelas='" . $_POST['id_kelas'] ."'";
    }

    if(empty($_POST['angkatan_siswa'])) {
        $angkatan = "";
    }

    else {
        $angkatan = "AND tbl_siswa.angkatan_siswa='" . $_POST['angkatan_siswa'] ."'";
    }

    if(empty($_POST['aktif_siswa'])) {
        $aktif_siswa = "";
    }

    else {
        $aktif_siswa = "AND tbl_siswa.aktif_siswa='" . $_POST['aktif_siswa'] ."'";
    }
    
    $urutkan = "ORDER BY tbl_siswa.id_siswa " .  $_POST['urutkan'];


    $query = "SELECT * FROM tbl_siswa, tbl_kelas, tbl_jurusan WHERE tbl_siswa.id_kelas = tbl_kelas.id_kelas AND tbl_jurusan.id_jurusan = tbl_kelas.id_jurusan $id_jurusan $id_kelas $angkatan $aktif_siswa $urutkan";
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
                            <a href="cetak.php?id_jurusan=<?= $_POST['id_jurusan']; ?>&id_kelas=<?= $_POST['id_kelas']; ?>&angkatan=<?= $_POST['angkatan_siswa']; ?>&urutkan=<?= $_POST['urutkan']; ?>&aktif_siswa=<?= $_POST['aktif_siswa']; ?>"  class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Cetak</a>

                            <a href="download.php?id_jurusan=<?= $_POST['id_jurusan']; ?>&id_kelas=<?= $_POST['id_kelas']; ?>&angkatan=<?= $_POST['angkatan_siswa']; ?>&urutkan=<?= $_POST['urutkan']; ?>&aktif_siswa=<?= $_POST['aktif_siswa']; ?>" target="_blank" class="btn btn-danger"><i class="fa fa-external-link"></i>Download PDF</a>
                        </ul>

                                                       
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><center>No</center></th>
                                    <th><center>NIS</center></th>
                                    <th><center>Nama</center></th>
                                    <th><center>Jenis Kelamin</center></th>
                                    <th><center>Jurusan</center></th>
                                    <th><center>Kelas</center></th>
                                    <th><center>Angkatan</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    foreach ($result as $r) {
                                ?>

                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= ucfirst($r['nis']); ?></td>
                                    <td><?= ucfirst($r['nama_siswa']); ?></td>
                                    <td><?= ucfirst($r['jekel_siswa']); ?></td>
                                    <td><?= ucfirst($r['nama_jurusan']); ?></td>
                                    <td><?= $config->format_romawi($r['tingkat_kelas']); ?> <?= ucfirst($r['nama_kelas']); ?></td>
                                    <td><?= ucfirst($r['angkatan_siswa']); ?></td>

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