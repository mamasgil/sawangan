<?php
    include 'config/Config.php';
    $page = "Konfirmasi Password";
    $config = new Config();
    
    // Cek apakah ada
    $email_pegawai   = base64_decode($_GET['email']);
    $password_pegawai = base64_decode($_GET['password']);
    $cek_daftar = $config->getData("SELECT * FROM tbl_pegawai WHERE email_pegawai='". $email_pegawai ."' AND password_pegawai='". $password_pegawai ."'");

    if(empty($cek_daftar)) {
        echo ("<script LANGUAGE='JavaScript'>
                window.location.href='". $base_url ."index.php';
                </script>");
    }

?>


<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title><?= $page . " | " . $name_application; ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?= $base_url . $logo; ?>" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?= $base_url . 'assets/css/theme-default.css'; ?>"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        
        <div class="login-container">
        
            <div class="login-box animated fadeInDown">
                <center>
                    <img src="<?= $base_url . 'assets/logo.png'; ?>" width="150" height="150"><br/><br/>
                </center>
                <div class="login-body">
                    <div class="login-title"><strong>Konfirmasi Perubahan Password</strong></div>
                    <form action="<?= $base_url . "action/lupa-password.php"; ?>" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="hidden" name="email_pegawai" class="form-control" placeholder="Masukan Email Pegawai" required="" value="<?= $email_pegawai?>">

                            <input type="password" class="form-control" placeholder="Masukan Password Baru" name="password_baru" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Masukan Ulang Password" name="repassword_baru" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="login.php" class="btn btn-link btn-block">Kembali ke Login</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block" type="submit" name="konfirmasi_password">Konfirmasi</button>

                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        <?= $copyright; ?>
                    </div>
                    <div class="pull-right">
                        <a href="<?= $base_url; ?>panduan">Panduan</a>
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>
</html>