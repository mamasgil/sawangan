<link rel="stylesheet" type="text/css" id="theme" href="../assets/css/alert/sweetalert.css"/>
<script type="text/javascript" src="../assets/js/alert/jquery-1.9.1.min.js"></script>        
<script type="text/javascript" src="../assets/js/alert/sweetalert-dev.js"></script>

<?php

    session_start();
    include_once("../config/Config.php");

    $config = new Config();

    // untuk mengecek data tersebut sudah diset / tidak jika sudah maka bernilai true jika belum maka false
    if (isset($_POST['masuk'])){
		$email_user    = stripslashes($_REQUEST['email_user']); 
		$password_user = stripslashes($_REQUEST['password_user']);
		
        $enskripsi = hash("sha1" , (hash("sha1",$password_user)));
        $query = $config->getData("SELECT * FROM tbl_pegawai WHERE email_pegawai='" . $email_user . "' AND password_pegawai='". $enskripsi ."' AND aktif_pegawai='1'");

		$rows = count($query); 

        if($rows==1){

            foreach ($query as $r) {
                $_SESSION['id_pegawai'] = $r['id_pegawai'];
                $_SESSION['nip'] = $r['nip'];
                $_SESSION['nama_pegawai'] = $r['nama_pegawai'];
                $_SESSION['alamat_pegawai'] = $r['alamat_pegawai'];
                $_SESSION['telp_pegawai'] = $r['telp_pegawai'];
                $_SESSION['foto_pegawai'] = $r['foto_pegawai'];
                $_SESSION['email_pegawai'] = $r['email_pegawai'];
    			$_SESSION['password_pegawai']   = $r['password_pegawai'];
    			$_SESSION['level_pegawai'] = $r['level_pegawai'];
    			$_SESSION['aktif_pegawai'] = $r['aktif_pegawai'];
    			
    			$_SESSION['kodeakses'] = $key;
            }

            $config->getHistory("Telah Login");
			?>
				<script type="text/javascript">
					$( document ).ready(function() {
						swal({title: "Selamat!", text: "Selamat anda berhasil login!", type: "success"},
						   function(){ 
							   document.location='<?php echo $base_url;?>page/dashboard'
						   }
						);
					});
				</script>
			<?php 
            
        }
        else{
		?>
		<script type="text/javascript">
			$( document ).ready(function() {
				swal({title: "Maaf!", text: "Password atau Email yang anda masukan salah!", type: "error"},
				   function(){ 
					   document.location='<?php echo $base_url;?>login.php'
				   }
				);
			});
		</script>
		<?php 
		}
            
    } else {
        header("Location: " . $base_url);
    }
?>


