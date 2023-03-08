<?php
    include '../../config/Config.php';
    $page       = "Laporan Pembayaran";
    $menu       = "Laporan Pembayaran";
    $submenu    = "Laporan";
    $config = new Config();
    include "hak-akses.php";
    

    if(($_POST['nis']<>'') OR ($_POST['id_kelas']<>'all') OR ($_POST['aktif_siswa']<>'all') OR ($_POST['angkatan_siswa']) OR ($_POST['tingkat_kelas']<>'all')) {

        $where = " WHERE";
        
    }

    else {
        $where = "";
    }

    if(($_POST['nis']=='')) {
        $nis = "";
    }
    else {
        $nis = " AND tbl_siswa.nis='" . $_POST['nis'] . "'";
    }

    if($_POST['id_kelas']=='all') {
        $id_kelas = "";
    }
    else {
        $id_kelas = " AND tbl_siswa.id_kelas='" . $_POST['id_kelas'] . "'";
    }

    if(($_POST['id_jurusan']=='all')) {
        $id_jurusan = "";
    }
    else {
        $id_jurusan = " AND tbl_kelas.id_jurusan='" . $_POST['id_jurusan'] . "'";
    }

    if($_POST['aktif_siswa']=='all') {
        $aktif_siswa = "";
    }
    else {
        $aktif_siswa = " AND tbl_siswa.aktif_siswa='" . $_POST['aktif_siswa'] . "'";
    }

    if($_POST['angkatan_siswa']=='all') {
        $angkatan_siswa = "";
    }
    else {
        $angkatan_siswa = " AND tbl_siswa.angkatan_siswa='" . $_POST['angkatan_siswa'] . "'";
    }

    if($_POST['tingkat_kelas']=='all') {
        $tingkat_kelas = "";
    }
    else {
        $tingkat_kelas = " AND tbl_kelas.tingkat_kelas='" . $_POST['tingkat_kelas'] . "'";
    }

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
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Opsi</button>
                            <ul class="dropdown-menu">
                                <li><a href="cetak.php?nis=<?= $_POST['nis']; ?>&tingkat_kelas=<?= $_POST['tingkat_kelas']; ?>&id_kelas=<?= $_POST['id_kelas']; ?>&id_jurusan=<?= $_POST['id_jurusan']; ?>&angkatan_siswa=<?= $_POST['angkatan_siswa']; ?>&id_pembayaran=<?= $_POST['id_pembayaran']; ?>&aktif_siswa=<?= $_POST['aktif_siswa']; ?>&status_lunas=<?= $_POST['status_lunas']; ?>" target="_blank">Cetak</a>
                                </li>
                                <li><a href="#" onClick ="$('#pembayaran').tableExport({type:'excel',escape:'false', tableName: 'Pembayaran'});">Download Excel</a></li>
                                <li><a href="download.php?nis=<?= $_POST['nis']; ?>&tingkat_kelas=<?= $_POST['tingkat_kelas']; ?>&id_kelas=<?= $_POST['id_kelas']; ?>&id_jurusan=<?= $_POST['id_jurusan']; ?>&angkatan_siswa=<?= $_POST['angkatan_siswa']; ?>&id_pembayaran=<?= $_POST['id_pembayaran']; ?>&aktif_siswa=<?= $_POST['aktif_siswa']; ?>&status_lunas=<?= $_POST['status_lunas']; ?>" target="_blank">Download PDF</a></li>
                            </ul>
                        </div>

                                                       
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table datatable" id="pembayaran">
                            <thead>
                                <tr>
                                    <th><center>NIS</center></th>
                                    <th><center>Nama</center></th>
                                    <th><center>Kelas</center></th>
                                    <th><center>Angkatan</center></th>
                                    <th><center>Nama Pembayaran</center></th>
                                    <th><center>Total Pembayaran</center></th>
                                    <th><center>Sisa Pembayaran</center></th>
                                    <th><center>Status</center></th>
                                </tr>
                            </thead>
                            <tbody>
                
    <?php
        if($_POST['id_pembayaran']=='all') {
            $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran"); 
        } else {
            $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran WHERE id_pembayaran='". $_POST['id_pembayaran'] ."'");
        }

        foreach ($pembayaran as $p) {
            $id_kelas_pembayaran = $config->clean_json($p['id_kelas']);
            $query = "SELECT * FROM tbl_siswa INNER JOIN tbl_kelas ON tbl_kelas.id_kelas = tbl_siswa.id_kelas INNER JOIN tbl_jurusan ON tbl_kelas.id_jurusan = tbl_jurusan.id_jurusan $where tbl_siswa.foto_siswa <> 'sdjhashahsghdvhhdbagusgantengamatbshdhavhs' $id_kelas $nis $aktif_siswa $angkatan_siswa $tingkat_kelas $id_jurusan AND tbl_siswa.id_kelas IN (". $id_kelas_pembayaran .") "; 
            $result = $config->getData($query);
            foreach ($result as $r) {
                $transaksi = $config->getData("SELECT * FROM tbl_transaksi WHERE id_siswa='". $r['id_siswa'] ."' AND id_pembayaran='". $p['id_pembayaran'] ."' GROUP BY id_pembayaran");

                if(!empty($transaksi)) {
                    foreach ($transaksi as $t) {
                        $kurang = $config->getData("SELECT SUM(nominal_transaksi) as nominal FROM tbl_transaksi WHERE id_siswa='". $r['id_siswa'] ."' AND id_kelas='". $r['id_kelas'] ."' AND id_pembayaran='". $p['id_pembayaran'] ."'");
                        foreach ($kurang as $k) {
                            $nilai_pembayaran = $p['nominal_pembayaran'];
                            $sisa_pembayaran = $nilai_pembayaran  - $k['nominal'];
                            if ($sisa_pembayaran<=0) {
                               $keterangan_pembayaran = "LUNAS";
                            } 
                            else if($sisa_pembayaran>0) {
                                $keterangan_pembayaran = "BELUM LUNAS";
                            }

                            if(($_POST['status_lunas']==$keterangan_pembayaran) OR ($_POST['status_lunas']=='all')){
                
    ?>

    <tr>
        <td><?= ucfirst($r['nis']); ?></td>
        <td><?= ucfirst($r['nama_siswa']); ?></td>
        <td><?= $config->format_romawi(ucfirst($r['tingkat_kelas'])); ?> <?= ucfirst($r['nama_kelas']); ?></td>
        <td><?= ucfirst($r['angkatan_siswa']); ?></td>
        <td><?= ucfirst($p['nama_pembayaran']); ?> (<?= $config->format_rupiah(ucfirst($p['nominal_pembayaran'])); ?>)</td>
        <td><?= $config->format_rupiah($k['nominal']); ?></td>
        <td><?= $config->format_rupiah($sisa_pembayaran); ?></td>
        <td><?= $keterangan_pembayaran; ?></td>
    </tr>

    <?php
                            }
                        }
                    }
                }
                else {

                   if(($_POST['status_lunas']<>'LUNAS')){
    ?>

    <tr>
        <td><?= ucfirst($r['nis']); ?></td>
        <td><?= ucfirst($r['nama_siswa']); ?></td>
        <td><?= $config->format_romawi(ucfirst($r['tingkat_kelas'])); ?> <?= ucfirst($r['nama_kelas']); ?></td>
        <td><?= ucfirst($r['angkatan_siswa']); ?></td>
        <td><?= ucfirst($p['nama_pembayaran']); ?> (<?= $config->format_rupiah(ucfirst($p['nominal_pembayaran'])); ?>)</td>
        <td>Rp. 0</td>
        <td><?= $config->format_rupiah(ucfirst($p['nominal_pembayaran'])); ?></td>
        <td>BELUM LUNAS</td>
    </tr>

    <?php 
                    }
                }
            }
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