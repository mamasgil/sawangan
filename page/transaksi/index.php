<?php
    include '../../config/Config.php';
    $page       = "Transaksi";
    $menu       = "Transaksi";
    $submenu    = "";
    $config = new Config();
    include "hak-akses.php";
    
    $query = "SELECT * FROM tbl_transaksi t, tbl_warga s, tbl_pegawai p, tbl_pembayaran pn, tbl_rumah k WHERE t.id_warga = s.id_warga AND t.id_pegawai = p.id_pegawai AND t.id_pembayaran = pn.id_pembayaran AND t.id_rumah = k.id_rumah ORDER BY t.id_transaksi DESC";
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
            <?= @$_SESSION['cetak']; 
                unset($_SESSION['cetak']);
            ?>
            <div class="btn-group pull-right">
                <a class="btn btn-danger btn-lg" href="export.php"><i class="fa fa-file"></i> Download Excell</a>
            </div>
            <button class="btn btn-info btn-lg" data-toggle="collapse" data-target="#pembayaran"><i class='fa fa-plus'></i> Tambah Transaksi</button><br/><br/>

                <form class="form-horizontal collapse" action="add.php" method="POST" enctype="multipart/form-data" id="pembayaran">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $page; ?> Pembayaran</h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Warga</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="niw" placeholder="Masukan Nomor Induk warga" required="" onkeypress="return isNumberKey(event)" />    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Untuk Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="jeniw_pembayaran" data-live-search="true">
                                <?php
                                    $query_pembayaran = $config->getData("SELECT * FROM tbl_pembayaran WHERE aktif_pembayaran='1' ORDER BY id_pembayaran DESC");
                                    foreach ($query_pembayaran as $qp) {
                            
                                    echo "<option value='". $qp['id_pembayaran'] ."'>". $qp['nama_pembayaran'] ."</option>";
                                    }
                                ?>

                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Metode Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="metode_pembayaran">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Transfer">Transfer</option>
                                </select>    
                            </div>
                        </div>
                    </div>

                    
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" name="simpan">Cari</button>
                    </div>
                </div>
                </form>

                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Riwayat <?= $page; ?></h3>
                        <ul class="panel-controls">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table datatable ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th><center>Waktu</center></th>
                                    <th><center>Nama Warga</center></th>
                                    <th><center>No Rumah</center></th>
                                    <th><center>Pembayaran</center></th>
                                    <th><center>Metode</center></th>
                                    <th><center>Nominal</center></th>
                                    <th><center>Opsi</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    foreach ($result as $r) {
									$rumah=$config->format_romawi($r['tingkat_rumah']);
                                ?>

                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= date("d-m-Y H:i:s", strtotime(ucfirst($r['waktu_transaksi']))); ?></td>
                                    <td><?= ucfirst($r['nama_warga']); ?></td>
                                    <td><?= $rumah." - ".ucfirst($r['nama_rumah']); ?></td>
                                    <td><?= ucfirst($r['nama_pembayaran']); ?></td>
                                    <?php
                                        if($r['file_foto']<>'0') {
                                    ?>
                                    <td><a href="<?= $base_url . 'assets/img/bukti_pembayaran/' . $r['file_foto']; ?>" target='_blank' ><?= $r['pembayaran_melalui']; ?></a></td>
                                    <?php
                                        } else {
                                    ?>
                                        <td><?= $r['pembayaran_melalui']; ?></td>
                                    <?php
                                        }
                                    ?>

                                    <td><?= $config->format_rupiah($r['nominal_transaksi']); ?></td>
                                    <td align="center">
									<?php 
										$enidtransaksi1=base64_encode($r['id_transaksi']);
										$enidtransaksi2=base64_encode($enidtransaksi1);
										$enidtransaksi3=base64_encode($enidtransaksi2);
										
										$enidwarga1=base64_encode($r['id_warga']);
										$enidwarga2=base64_encode($enidwarga1);
										$enidwarga3=base64_encode($enidwarga2);
										

										$enidrumah=base64_encode(base64_encode(base64_encode($r['id_rumah'])));

										$enidpembayaran1=base64_encode($r['id_pembayaran']);
										$enidpembayaran2=base64_encode($enidpembayaran1);
										$enidpembayaran3=base64_encode($enidpembayaran2);
										
										$encicilan1=base64_encode($r['cicilan_transaksi']);
										$encicilan2=base64_encode($encicilan1);
										$encicilan3=base64_encode($encicilan2);
									?>
                                        <a href="cetak.php?id=<?= $enidtransaksi3; ?>&warga=<?= $enidwarga3; ?>&pembayaran=<?= $enidpembayaran3; ?>&cicilan=<?= $encicilan3; ?>&id_rumah=<?= $enidrumah; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i></a>
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
    
<?php
    include "../../layout/footer.php";
} else {
    header("Location:" . $base_url . "login.php");
}

?>