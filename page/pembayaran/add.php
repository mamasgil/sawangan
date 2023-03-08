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
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama Pembayaran</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nama_pembayaran" placeholder="Masukan Nama Pembayaran" required="" />    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nominal</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="nominal_pembayaran" placeholder="Masukan Nominal Pembayaran" required="" onkeyup="convertToRupiah(this);"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jumlah Cicilan</label>
                            <div class="col-md-6 col-xs-12"> 
                                <input type="text" class="form-control" name="jumlah_cicilan" placeholder="Masukan Jumlah Cicilan" required="" onkeyup="convertToRupiah(this);"/>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Untuk Rumah</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" multiple name="id_rumah[]" data-placeholder="Pilih rumah">
                                    <?php
                                        $query_rumah = $config->getData("SELECT * FROM tbl_rumah");

                                        foreach ($query_rumah as $qk) {
                                    ?>
                                            <option value="<?= $qk['id_rumah']; ?>"><?= $config->format_romawi($qk['tingkat_rumah']); ?> <?= $qk['nama_rumah']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Aktif</label>
                            <div class="col-md-6 col-xs-12"> 
                                <select class="form-control select" name="aktif_pembayaran">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>    
                            </div>
                        </div>
                    </div>

                    
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" name="simpan">Simpan</button>
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
    include "../../layout/footer.php";
} else {
    header("Location:" . $base_url . "login.php");
}

?>          


