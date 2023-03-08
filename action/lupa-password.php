<link rel="stylesheet" type="text/css" id="theme" href="../assets/css/alert/sweetalert.css"/>
<script type="text/javascript" src="../assets/js/alert/jquery-1.9.1.min.js"></script>        
<script type="text/javascript" src="../assets/js/alert/sweetalert-dev.js"></script>
<?php
session_start();

include_once("../config/Config.php");
$config = new Config();

if(isset($_POST['submit'])) {
	

	$email_pegawai 	= $_POST['email_pegawai'];

	// Cek apakah sudah daftar
	$cek_daftar = $config->getData("SELECT * FROM tbl_pegawai WHERE email_pegawai='$email_pegawai'");

	$rows = count($cek_daftar);

	if($rows==1){

		foreach ($cek_daftar as $pwd) {
			$password_pegawai = $pwd['password_pegawai'];
		}

		$to= $email_pegawai;
		$from="fastforit@gmail.com";
		$from_name= "SPP Unsur";
		$msg="Klik link untuk untuk mengubah password <br/>
		" . $base_url . "konfirmasi-password.php?email=" . base64_encode($email_pegawai) ."&password=" . base64_encode($password_pegawai);

		$subject="Verifikasi Perubahan Kata Sandi";
		/*End Config*/

		include("../config/phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();

		$mail->From = $from;
		$mail->FromName= $from_name;
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $msg;
		$mail->addAddress($to);
		if(!$mail->send()){
		 	echo "Mailer Error: " . $mail->ErrorInfo;
		 	echo $msg;
		}
		else {
		?>
			<script type="text/javascript">
				$( document ).ready(function() {
					swal({title: "Congrats!", text: "Verifikasi Perubahan Password Berhasil Dikirim, Silahkan cek Email anda", type: "success"},
					   function(){ 
						   document.location='<?php echo $base_url;?>index.php'
					   }
					);
				});
			</script>
		<?php
		/*
			echo ("<script LANGUAGE='JavaScript'>
		    window.alert('Verifikasi Perubahan Password Berhasil Dikirim, Silahkan cek Email anda');
		    window.location.href='". $base_url ."index.php';</script>");
		*/
		}

	} else {
	?>
		<script type="text/javascript">
			$( document ).ready(function() {
				swal({title: "Sorry!", text: "Email ini Belum pernah mendaftar, silahkan mendaftar terlebih dahulu", type: "error"},
				   function(){ 
					   document.location='<?php echo $base_url;?>index.php'
				   }
				);
			});
		</script>
	
	<?php 
	/*
		echo ("<script LANGUAGE='JavaScript'>
			    window.alert('Email ini Belum pernah mendaftar, silahkan mendaftar terlebih dahulu');
			    window.location.href='". $base_url ."index.php';</script>");
	*/
	} 
}
if(isset($_POST['konfirmasi_password'])) {
	if(($_POST['password_baru'])==($_POST['repassword_baru'])) {
		$email_pegawai 	= $_POST['email_pegawai'];
		$password_pegawai 	= hash("sha1", (hash("sha1",$_POST['password_baru'])));
		$config->execute("
			UPDATE tbl_pegawai SET password_pegawai='$password_pegawai' WHERE email_pegawai='$email_pegawai'
		");
		?>
			<script type="text/javascript">
				$( document ).ready(function() {
					swal({title: "Congrats!", text: "Password Berhasil Diubah, Silahkan Login", type: "success"},
					   function(){ 
						   document.location='<?php echo $base_url;?>index.php'
					   }
					);
				});
			</script>
		<?php 
		/*
		echo ("<script LANGUAGE='JavaScript'>
			    window.alert('Password Berhasil Diubah, Silahkan Login');
			    window.location.href='". $base_url ."index.php';</script>");
		*/
	} else {
		?>
			<script type="text/javascript">
				$( document ).ready(function() {
					swal({title: "Sorry!", text: "Password Tidak Sama", type: "error"},
					   function(){ 
						   document.location='<?php echo $base_url;?>index.php'
					   }
					);
				});
			</script>
		<?php 
		/*
		echo ("<script LANGUAGE='JavaScript'>
			    window.alert('');
			    window.location.href='". $base_url ."index.php';</script>");
		*/
	}
}
?>
