<?php
    include '../../config/Config.php';
    $page       = "Ubah Warga";
    $menu       = "Warga";
    $submenu    = "Data Master";
    $config = new Config();

    include "hak-akses.php";
// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {
    include "../../layout/header.php";
    $id1 =base64_decode($_GET['id']);
	$id2 =base64_decode($id1);
	$id3 =base64_decode($id2);
    $result = $config->getData("SELECT * FROM tbl_warga WHERE id_warga='$id3'");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."page/warga';
                </script>");
    }
    foreach ($result as $r):    
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
                
                <form class="form-horizontal" action="_action.php" method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $page; ?></h3>
                    </div>
                    <div class="panel-body">
						<?php 
							$en1 =base64_encode($id3);
							$en2 =base64_encode($en1);
							$en3 =base64_encode($en2);
						?>
                        <input type="hidden" class="form-control" name="id_warga" required="" value="<?= $en3; ?>" />
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Induk warga</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="niw" placeholder="Masukan Nomor Induk warga" required="" value="<?= $r['niw']; ?>" onkeypress="return isNumberKey(event)" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Lengkap</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_warga" placeholder="Masukan Nama Lengkap warga" required="" value="<?= $r['nama_warga']; ?>"/>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jeniw Kelamin</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="jekel_warga">
                                    <?php 
                                        if($r['jekel_warga']=='Laki-Laki') { 
                                            echo '<option value="Laki-Laki" selected="">Laki-Laki</option>';
                                            echo '<option value="Perempuan">Perempuan</option>'; 
                                             
                                        } else {
                                            echo '<option value="Laki-Laki">Laki-Laki</option>';
                                            echo '<option value="Perempuan" selected="">Perempuan</option>'; 
                                            
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Alamat Lengkap</label>
                            <div class="col-md-6 col-xs-12">   
                                <textarea class="form-control" rows="5" name="alamat_warga" placeholder="Masukan Alamat Lengkap warga" required=""><?= $r['alamat_warga']; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Foto</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="file" accept='image/*' class="fileinput btn-primary" name="fupload" title="Browse file"/>
                                <input type="hidden" name="fupload_lama" title="Browse file" value="<?= $r['foto_warga']; ?>" />
                                <br/>
                                <img src="<?= $base_url . 'assets/img/warga/' . $r['foto_warga']; ?>" width='200' height='300'>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">rumah</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="id_rumah">
                                    <?php
                                        $query_rumah = $config->getData("SELECT * FROM tbl_rumah ORDER BY tingkat_rumah ASC");

                                        foreach ($query_rumah as $qk) {
                                    ?>
                                            <option value="<?= $qk['id_rumah']; ?>" <?php if($r['id_rumah']==$qk['id_rumah']) { echo "selected=''"; } ?>><?= $config->format_romawi($qk['tingkat_rumah']); ?> <?= $qk['nama_rumah']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Angkatan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="angkatan_warga">
                                    <?php
                                        $date = date('Y');
                                        $datelimit = $date - 10;
                                        for ($i=$date; $i > $datelimit; $i--) { 
                                            echo "<option value='" . $date . "'";
                                            if($r['angkatan_warga']==$date) { echo "selected=''"; }
                                            echo ">" . $date . "</option>";

                                            $date--;
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Aktif</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_warga">
                                    <?php 
                                        if($r['aktif_warga']=='1') { 
                                            echo '<option value="1" selected="">Aktif</option>';
                                            echo '<option value="0">Tidak Aktif</option>';
                                            echo '<option value="11">Lulus</option>'; 
                                        }
                                        else if($r['aktif_warga']=='0') {
                                            echo '<option value="1">Aktif</option>';
                                            echo '<option value="0" selected="">Tidak Aktif</option>';
                                            echo '<option value="11">Lulus</option>'; 
                                              
                                        } else {
                                            echo '<option value="1">Aktif</option>';
                                            echo '<option value="0">Tidak Aktif</option>';
                                            echo '<option value="11" selected="">Lulus</option>'; 
                                            
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>
                    </div>

                    
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" name="update">Ubah</button>
                    </div>
                </div>
                </form>
                
            </div>
        </div>                    
        
    </div>
    <!-- END PAGE CONTENT WRAPPER -->                                                
<?php
    endforeach;
    include "../../layout/footer.php";
} else {
    header("Location:" . $base_url . "login.php");
}
  

?>          


