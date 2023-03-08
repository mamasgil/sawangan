<?php
    include '../../config/Config.php';
    $page       = "Ubah Jurusan";
    $menu       = "Jurusan";
    $submenu    = "Data Master";
    $config = new Config();
    include "hak-akses.php";
    
// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {
    include "../../layout/header.php";
	$id1 =base64_decode($_GET['id']);
	$id2 =base64_decode($id1);
	$id3 =base64_decode($id2);
    $result = $config->getData("SELECT * FROM tbl_jurusan WHERE id_jurusan='$id3'");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."page/jurusan';
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
                        <input type="hidden" class="form-control" name="id_jurusan" required="" value="<?= $en3 ?>" />
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Jurusan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_jurusan" placeholder="Masukan Nama Jurusan" required="" value="<?= $r['nama_jurusan']; ?>"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Diskripsi</label>
                            <div class="col-md-6 col-xs-12">   
                                <textarea class="form-control" rows="5" name="diskripsi_jurusan" placeholder="Masukan Diskripsi" required=""><?= $r['diskripsi_jurusan']; ?></textarea>
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


