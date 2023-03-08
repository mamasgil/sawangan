<?php
    include '../../config/Config.php';
    $page       = "Hapus Pembayaran";
    $menu       = "Hapus Pembayaran";
    $submenu    = "";
    $config = new Config();
    include "hak-akses.php";
    
    $query = "SELECT * FROM tbl_transaksi t, tbl_warga s, tbl_pegawai p, tbl_pembayaran pn WHERE t.id_warga = s.id_warga AND t.id_pegawai = p.id_pegawai AND t.id_pembayaran = pn.id_pembayaran ORDER BY t.id_transaksi DESC";
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
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><center>ID Transaksi</center></th>
                                    <th><center>Nama warga</center></th>
                                    <th><center>Nama Pegawai</center></th>
                                    <th><center>Pembayaran</center></th>
                                    <th><center>Nominal</center></th>
                                    <th><center>Cicilan</center></th>
                                    <th><center>Opsi</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    foreach ($result as $r) {
                                ?>

                                <tr>
                                    <td><?= ucfirst($r['id_transaksi']); ?></td>
                                    <td><?= ucfirst($r['nama_warga']); ?></td>
                                    <td><?= ucfirst($r['nama_pegawai']); ?></td>
                                    <td><?= ucfirst($r['nama_pembayaran']); ?></td>
                                    <td><?= $config->format_rupiah(ucfirst($r['nominal_transaksi'])); ?></td>
                                    <td><?= ucfirst($r['jumlah_cicilan']); ?> x</td>
                                    <td align="center">
										<?php 
											$id1 =base64_encode($r['id_transaksi']);
											$id2 =base64_encode($id1);
											$id3 =base64_encode($id2);
										?>
                                       
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