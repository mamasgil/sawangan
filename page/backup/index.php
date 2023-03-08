

<?php
    include '../../config/Config.php';
    $page       = "Backup Database";
    $menu       = "Backup";
    $submenu    = "Pengaturan";
    $config = new Config();
    include "hak-akses.php";


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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Filter <?= $page; ?></h3>
                    </div>
                    <div class="panel-body form-group-separated">
                    <?php
    					include "function.php";

    					$para = array(
    						'db_host'=> 'mysql.hostinger.co.id',  //mysql host
    						'db_uname' => 'u170538644_unsur',  //user
    						'db_password' => 'unsur123', //pass
    						'db_to_backup' => 'u170538644_unsur', //database name
    						'db_backup_path' => '/backup/', //where to backup
    						//'db_exclude_tables' => array('wp_comments','wp_w3tc_cdn_queue') //tables to exclude
    					);
    					__backup_mysql_database($para);

    				?>
                    </div>
                </div>
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