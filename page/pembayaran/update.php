<?php
    include '../../config/Config.php';
    $page       = "Tambah Pembayaran";
    $menu       = "Pembayaran";
    $submenu    = "";
    $config = new Config();

    include "hak-akses.php";
    
// Jika Sudah Login
if(!empty($_SESSION['kodeakses'])) {
    include "../../layout/header.php";
    $id1 =base64_decode($_GET['id']);
	$id2 =base64_decode($id1);
	$id3 =base64_decode($id2);
    $result = $config->getData("SELECT * FROM tbl_pembayaran WHERE id_pembayaran='$id3'");

    if($result==false) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."page/pembayaran';
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
                        <input type="hidden" class="form-control" name="id_pembayaran" required="" value="<?= $en3; ?>" />
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_pembayaran" placeholder="Masukan Nama Pembayaran" required="" value="<?= $r['nama_pembayaran']; ?>" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nominal</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nominal_pembayaran" placeholder="Masukan Nominal Pembayaran" required="" value="<?= $config->format_ribuan($r['nominal_pembayaran']); ?>" onkeyup="convertToRupiah(this);" />    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jumlah Cicilan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="jumlah_cicilan" placeholder="Masukan Jumlah Cicilan" required="" value="<?= $config->format_ribuan($r['jumlah_cicilan']); ?>" onkeyup="convertToRupiah(this);"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Untuk rumah</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select"  multiple name="id_rumah[]" >
                                    <?php
                                        $id_rumah = json_decode($r['id_rumah'], TRUE );

                                        $rumah = $config->getData("SELECT * FROM tbl_rumah ");

                                         $i=0;
                                            foreach ($rumah as $k) {  
                                    ?>

                                        <option <?php
                                            for ($index=0; $index < count($id_rumah) ; $index++) { 
                                                
                                            if($id_rumah[$index]==$k['id_rumah']) {echo "selected";}
                                            }
                                            ?> value="<?= $k['id_rumah']; ?>"><?= $k['tingkat_rumah']; ?>-<?= $k['nama_rumah']; ?></option>
                                    <?php
                                                $i++;
                                            }

                                            
                                    ?>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Aktif</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_pembayaran">
                                    <?php 
                                        if($r['aktif_pembayaran']=='1') { 
                                            echo '<option value="1" selected="">Aktif</option>';
                                            echo '<option value="0">Tidak Aktif</option>'; 
                                             
                                        } else {
                                            echo '<option value="1">Aktif</option>';
                                            echo '<option value="0" selected="">Tidak Aktif</option>'; 
                                            
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


