<?php
    include 'config/Config.php';
    $page = "Login";

// Jika Belum Login
if(empty($_SESSION['kodeakses'])) {    
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

        <link rel="stylesheet" href="<?= $base_url . 'assets/css/bubble-style.css'; ?>">                                    
    </head>
    <body style="background:#f5f5f5;">
        
        <div class="login-container">
        
            <div class="login-box animated fadeInDown">
                <center>
                    <img src="<?= $base_url . 'assets/logo2.png'; ?>" width="150" height="150"><br/><br/>
                </center>
                <div class="login-body">
                    <div class="login-title"><strong>Selamat Datang</strong>, Silahkan Login</div>
                    <form action="<?= $base_url . "action/login.php"; ?>" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Email" name="email_user" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Password" name="password_user" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="lupa-password.php" class="btn btn-link btn-block">Lupa password?</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block" type="submit" name="masuk">Masuk</button>

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
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
			
            <ul class="bg-bubbles"  style="position:relative;">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
			
        </div>
        
    </body>
</html>

<?php
} else {
    header("Location: page/dashboard");
}
?>






