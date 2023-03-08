<?php
    include '../../config/Config.php';
    $page       = "Ubah Rumah";
    $menu       = "Rumah";
    $submenu    = "Data Master";
    $config = new Config();

    include "hak-akses.php";
// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {
    include "../../layout/header.php";
    $id1 =base64_decode($_GET['id']);
	$id2 =base64_decode($id1);
	$id3 =base64_decode($id2);
    $result = $config->getData("SELECT * FROM tbl_rumah, tbl_jurusan WHERE tbl_jurusan.id_jurusan = tbl_rumah.id_jurusan AND tbl_rumah.id_rumah='$id3'");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."page/rumah';
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
                        <input type="hidden" class="form-control" name="id_rumah" required="" value="<?= $en3; ?>" />
                        
                       
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jurusan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="id_jurusan" data-live-search="true">
                                    <?php
                                        $query_jurusan = $config->getData("SELECT * FROM tbl_jurusan");

                                        foreach ($query_jurusan as $qj) {
                                    ?>
                                            <option value="<?= $qj['id_jurusan']; ?>" 
                                                <?php if($r['id_jurusan']==$qj['id_jurusan']) { echo "selected=''"; } ?>><?= $qj['nama_jurusan']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tingkat</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="tingkat_rumah" >

                                    <?php
                                        if($r['tingkat_rumah']=='10') {
                                            echo '
                                                <option value="10" selected="">X</option>
                                                <option value="11">XI</option>
                                                <option value="12">XII</option>
                                            ';
                                        }
                                        else if($r['tingkat_rumah']=='11') {
                                            echo '
                                                <option value="10">X</option>
                                                <option value="11" selected="">XI</option>
                                                <option value="12">XII</option>
                                            ';
                                        }
                                        else {
                                            echo '
                                                <option value="10">X</option>
                                                <option value="11">XI</option>
                                                <option value="12" selected="">XII</option>
                                            ';
                                        }
                                    ?>
                                    
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Rumah</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_rumah" placeholder="Masukan Nama rumah" required="" value="<?= $r['nama_rumah']; ?>"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Wali Rumah</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="id_pegawai" data-live-search="true">
                                    <?php
                                        $query_pegawai = $config->getData("SELECT * FROM tbl_pegawai WHERE level_pegawai='Wali rumah' AND aktif_pegawai='1'");

                                        foreach ($query_pegawai as $qj) {
                                    ?>
                                            <option value="<?= $qj['id_pegawai']; ?>" 
                                                <?php if($r['id_pegawai']==$qj['id_pegawai']) { echo "selected=''"; } ?>><?= $qj['nama_pegawai']; ?></option>
                                    <?php
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


