<?php
    include '../../config/Config.php';
    $page       = "Import Pembayaran";
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
                            <label class="col-md-3 col-xs-12 control-label">File (.xlsx)</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="file" class="fileinput btn-primary" name="url_file" title="Browse file" accept=".xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                            </div>
                        </div>

                        
                    </div>

                    
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" name="import">Import</button>
                    </div>
                </div>
                </form>
                
            </div>
        </div>                    
        
    </div>
    <!-- END PAGE CONTENT WRAPPER -->                                                
<?php
    include "../../layout/footer.php";
    
} else {
    header("Location:" . $base_url . "login.php");
}

?>          




