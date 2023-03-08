<?php
    include '../../config/Config.php';
    $page       = "Transaksi Tunggakan";
    $menu       = "Transaksi Tunggakan";
    $submenu    = "";
    $config = new Config();

    include "hak-akses.php";

// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {   
    include "../../layout/header.php";
    $nis = $_POST['nis'];

    $lihat_rumah = $config->getData("SELECT id_rumah FROM tbl_warga WHERE nis='". $nis ."'");
    foreach ($lihat_rumah as $lk) {
        $rumah_warga = $lk['id_rumah'];
    }
    
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $id_rumah = $_POST['id_rumah'];

    $pembayaran = $config->getData("SELECT * FROM tbl_pembayaran WHERE id_pembayaran='". $jenis_pembayaran ."'");

    foreach ($pembayaran as $pem) {
       $id_rumah_pembayaran = $config->clean_json($pem['id_rumah']);
    }

    $result = $config->getData("SELECT * FROM tbl_warga s, tbl_rumah k WHERE s.id_rumah = k.id_rumah AND s.nis='". $nis ."' AND s.id_rumah IN (". $id_rumah_pembayaran .")");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.alert('Tidak Ada Pembayaran');
                window.location.href='". $base_url ."page/transaksi';
                </script>");
    }

    foreach ($result as $r):
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
                <form class="form-horizontal" action="_action.php" method="POST" enctype="multipart/form-data">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $page; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-9 col-xs-12">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">ID Transaksi</label>
                            <div class="col-md-9 col-xs-12"> 
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="id_transaksi" placeholder="Masukan ID Transaksi" required="" readonly="" value="<?= $config->kode_transaksi()?>" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Induk warga</label>
                            <div class="col-md-9 col-xs-12">
                                <input type="hidden" class="form-control" style="background-color: white; color: black;" name="id_warga" placeholder="Masukan ID warga" required="" value="<?= $r['id_warga']; ?>" readonly=""/>  
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="nis" placeholder="Masukan Nomor Induk warga" required="" value="<?= $r['nis']; ?>" readonly=""/>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama warga</label>
                            <div class="col-md-9 col-xs-12"> 
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="nis" placeholder="Masukan Nomor Induk warga" required="" value="<?= $r['nama_warga']; ?>" readonly="" />    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">rumah</label>
                            <div class="col-md-9 col-xs-12"> 
								<?php 
                                $tk = $config->getData("SELECT * FROM tbl_rumah WHERE id_rumah='". $id_rumah ."'");
                                foreach ($tk as $t) {
                                    $rumah=$config->format_romawi($t['tingkat_rumah']);
                                }
								
								?>


                                <input type="text" class="form-control" style="background-color: white; color: black;" value="<?= $rumah ." - ".$r['nama_rumah']; ?>" required="" readonly="" />    
                            </div>
                        </div>

                        <div class="form-group hidden">
                            <label class="col-md-3 col-xs-12 control-label">Id rumah</label>
                            <div class="col-md-9 col-xs-12"> 
                                <input type="text" class="form-control" style="background-color: white; color: black;" value="<?= $id_rumah; ?>" required="" readonly="" name="id_rumah"/>    
                            </div>
                        </div>


                        <?php
                            foreach ($pembayaran as $p) {
                        ?>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Untuk Pembayaran</label>
                            <div class="col-md-9 col-xs-12">
                                <input type="hidden" class="form-control" name="id_pembayaran" placeholder="Masukan Pembayaran" required="" value="<?= $p['id_pembayaran']; ?>" /> 
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="nama_pembayaran" placeholder="Masukan Pembayaran" required="" value="<?= $p['nama_pembayaran']; ?>" readonly="" />    
                            </div>
                            
                        </div>
                        <div class="form-group hidden">
                            <label class="col-md-3 col-xs-2 control-label">Senilai</label>
                            <div class="col-md-3 col-xs-5">
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="nominal_pembayaran" placeholder="Masukan Nominal Pembayaran" required="" value="<?= $p['nominal_pembayaran']; ?>" readonly="" />    
                            </div>
                            <label class="col-md-2 col-xs-2 control-label">Kurang</label>
                            <div class="col-md-3 col-xs-5">
                                <?php
                                    $kurang = $config->getData("SELECT SUM(nominal_transaksi) as nominal FROM tbl_transaksi WHERE id_warga='". $r['id_warga'] ."' AND id_rumah = '". $id_rumah ."' AND id_pembayaran='". $p['id_pembayaran'] ."'");

                                    foreach ($kurang as $k) {
                                        $nilai_pembayaran = $p['nominal_pembayaran'];
                                        $pembayaran_kurang = $nilai_pembayaran  - $k['nominal'];
                                    }
                                ?>
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="nominal_pembayaran" placeholder="Masukan Nominal Pembayaran" required="" value="<?= $pembayaran_kurang; ?>" readonly="" />    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Cicilan ke </label>
                            <div class="col-md-3 col-xs-12"> 
                                <?php
                                    $warga = $r['id_warga'];
                                    $idpembayaran = $_POST['jenis_pembayaran'];
                                ?>
                                <input type="number" class="form-control" style="background-color: white; color: black;" name="jumlah_cicilan" placeholder="Masukan Jumlah Cicilan" required="" value="<?= $config->kode_cicilan($warga, $id_rumah, $idpembayaran)?>" readonly="" />    
                            </div>
                            <label class="col-md-2 col-xs-12 control-label">Maksimal cicilan
                            </label>
                            <div class="col-md-3 col-xs-12"> 
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="batas_cicilan" placeholder="Masukan Batas Cicilan" required="" value="<?= $p['jumlah_cicilan']; ?>x" readonly=""/>    
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Metode Pembayaran</label>
                            <div class="col-md-9 col-xs-12"> 
                                <input type="text" class="form-control" style="background-color: white; color: black;" name="pembayaran_melalui" required="" value="<?= strtoupper($metode_pembayaran); ?>" readonly="" />
                            </div>
                        </div>
                        <?php
                        if((strtoupper($metode_pembayaran))=='TRANSFER') {
                        ?>
                        <div class="form-group" >
                            <label class="col-md-3 col-xs-12 control-label">Bukti Transfer</label>
                            <div class="col-md-9 col-xs-12"> 
                                <input type="file" accept='image/*' class="fileinput btn-primary" name="fupload" title="Browse file" id="bukti_transfer" required="" />
                            </div>
                        </div>

                        <?php
                            } 
                        ?> 

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nominal Pembayaran</label>
                            <div class="col-md-9 col-xs-12"> 
                                <input type="text" class="form-control" style="background-color: white; color: black; font-size: 30pt; height:100px;" name="nominal_transaksi" placeholder="0" required="" autofocus="" id="nominal_transaksi" onkeyup="convertToRupiah(this);"/>    
                            </div>
                        </div>

                        
                        </div>
                        <div class="col-md-3">
                            <center>
                            <img src="<?= $base_url . 'assets/img/warga/' . $r['foto_warga']; ?>" width="100%" height="100%">
                            </center><br/>
                            <p>Jumlah Pembayaran :</p>
                            <h3 style="color: blue;"><b><?= $config->format_rupiah($nilai_pembayaran); ?></b></h3>
                            <p>Sisa Pembayaran:</p>
                            <h3 style="color: blue;"><b><?= $config->format_rupiah($pembayaran_kurang); ?></b></h3>
                            <p style="margin-bottom: -10px;">Status Pembayaran :</p>

                            <center>
                            <?php
                                if($pembayaran_kurang<=0) {
                                    echo '<h1 style="color: green;"><b>LUNAS</b></h1>';
                                }
                                else {
                                    echo '<h1 style="color: red;"><b>BELUM LUNAS</b></h1>';
                                }
                            ?>
                            </center>
                        </div>
                    </div>

                    <?php
                        if($pembayaran_kurang<=0) {
                            echo "<script>
                                document.getElementById('nominal_transaksi').readOnly = true;
                                document.getElementById('bukti_transfer').disabled = true;
                                </script>";
                        } else {
                    ?>
                    <div class="panel-footer">
                        <a href="<?= $base_url . 'page/transaksi'; ?>" class="btn btn-default btn-lg ">Batal</a>
                        <button class="btn btn-primary btn-lg pull-right" name="bayar">Bayar</button>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                </form>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Riwayat Pembayaran Sekarang</h3>
                    </div>
                    <div class="panel-body table-responsive">
                        

                        <table class="table">
                            <thead>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Petugas</th>
                                <th>Metode Pembayaran</th>
                                <th>Cicilan Ke</th>
                                <th>Nominal</th>
                                <th>Opsi</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    $histori = $config->getData("SELECT * FROM tbl_transaksi t, tbl_warga s, tbl_pegawai p WHERE t.id_rumah = '$id_rumah' AND t.id_warga = s.id_warga AND t.id_pegawai = p.id_pegawai AND t.id_warga='". $r['id_warga'] ."' AND t.id_pembayaran ='". $jenis_pembayaran ."'");
                                    foreach ($histori as $h) {
                                ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= date("d-m-Y H:i:s", strtotime($h['waktu_transaksi'])); ?></td>
                                    <td><?= $h['nama_pegawai']; ?></td>
                                    <?php
                                        if($h['file_foto']<>'0') {
                                    ?>
                                    <td><a href="<?= $base_url . 'assets/img/bukti_pembayaran/' . $h['file_foto']; ?>" target='_blank' ><?= $h['pembayaran_melalui']; ?></a></td>
                                    <?php
                                        } else {
                                    ?>
                                        <td><?= $h['pembayaran_melalui']; ?></td>
                                    <?php
                                        }
                                    ?>
                                    <td><?= $h['cicilan_transaksi']; ?></td>
                                    <td><?= $config->format_rupiah($h['nominal_transaksi']); ?></td>
                                    <td align="center">
									<?php 
										$enidtransaksi1=base64_encode($h['id_transaksi']);
										$enidtransaksi2=base64_encode($enidtransaksi1);
										$enidtransaksi3=base64_encode($enidtransaksi2);
										
										$enidwarga1=base64_encode($h['id_warga']);
										$enidwarga2=base64_encode($enidwarga1);
										$enidwarga3=base64_encode($enidwarga2);
										
                                        $id_rumah = $config->getData("SELECT id_rumah FROM tbl_transaksi WHERE id_transaksi='". $h['id_transaksi'] ."'");
                                        foreach ($id_rumah as $ik) {
                                            $enidrumah=base64_encode(base64_encode(base64_encode($ik['id_rumah'])));
                                        }
                                        
										$enidpembayaran1=base64_encode($h['id_pembayaran']);
										$enidpembayaran2=base64_encode($enidpembayaran1);
										$enidpembayaran3=base64_encode($enidpembayaran2);
										
										$encicilan1=base64_encode($h['cicilan_transaksi']);
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
            </div>
        </div>                    
        
    </div>
<script type="text/javascript">
    function convertToRupiah(objek) {
      separator = ".";
      a = objek.value;
      b = a.replace(/[^\d]/g,"");
      c = "";
      panjang = b.length;
      j = 0;
      for (i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
          c = b.substr(i-1,1) + separator + c;
        } else {
          c = b.substr(i-1,1) + c;
        }
      }
      objek.value = c;

    } 
</script>
                                         
<?php
    endforeach;
    include "../../layout/footer.php";
} else {
    header("Location:" . $base_url . "login.php");
}

?>          


