<?php
	session_start();
	error_reporting(0);
	include_once("../../config/Config.php");
	include "../../config/Upload.php";

	$config = new Config();

	$nip = "'" . $config->escape_string($_POST['nip']) . "'";
	$nama_pegawai = "'" . $config->escape_string($_POST['nama_pegawai']) . "'";
	$alamat_pegawai = "'" . $config->escape_string($_POST['alamat_pegawai']) . "'";
	$telp_pegawai = "'" . $config->escape_string($_POST['telp_pegawai']) . "'";
	$email_pegawai = "'" . $config->escape_string($_POST['email_pegawai']) . "'";
	$password1 = $_POST['password_pegawai'];
	$password2 = $_POST['repassword_pegawai'];

	$password_pegawai = hash("sha1" , (hash("sha1",$password1)));

	//Upload Foto
	$lokasi_file = $_FILES['fupload']['tmp_name'];
	$nama_fileex = $_FILES['fupload']['name'];
	$nama_file   = time()."-".$nama_fileex;
	$ukuran 	 = $_FILES['fupload']['size'];

if (isset($_POST['update'])) {
	$id_pegawai 	= $_SESSION['id_pegawai'];
	
	if((empty($password1)) AND (empty($password2))) {
		if(empty($lokasi_file)) {
			$result = $config->execute("
				UPDATE tbl_pegawai SET 
					nip				= $nip,
					nama_pegawai	= $nama_pegawai,
					alamat_pegawai	= $alamat_pegawai,
					telp_pegawai	= $telp_pegawai,
					email_pegawai	= $email_pegawai
				WHERE 
					id_pegawai		= '$id_pegawai'
			");
		} else {
			UploadPegawai($nama_file);
			$result = $config->execute("
				UPDATE tbl_pegawai SET 
					nip				= $nip,
					nama_pegawai	= $nama_pegawai,
					alamat_pegawai	= $alamat_pegawai,
					telp_pegawai	= $telp_pegawai,
					foto_pegawai 	= '$nama_file',
					email_pegawai	= $email_pegawai
				WHERE 
					id_pegawai		= '$id_pegawai'
			");
			$foto_lama = $_POST['fupload_lama'];
			if ($foto_lama<>"default.jpg") {
				unlink("../../assets/img/pegawai/". $foto_lama);
			}

			$_SESSION['foto_pegawai'] = $nama_file;
			
		}

		if($result) {
			$_SESSION['status'] = '<div class="alert alert-success" role="alert">
		        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <strong>Selamat !</strong> Data berhasil diubah
		    </div>';
		}
		else {
			$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
		        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <strong>Gagal !</strong> Data gagal disimpan, mungkin data yang anda masukan salah
		    </div>';
		}
	}else {
		if($password1==$password2) {
			if(empty($lokasi_file)) {
				$result = $config->execute("
					UPDATE tbl_pegawai SET 
						nip				= $nip,
						nama_pegawai	= $nama_pegawai,
						alamat_pegawai	= $alamat_pegawai,
						telp_pegawai	= $telp_pegawai,
						email_pegawai	= $email_pegawai,
						password_pegawai= '$password_pegawai'
					WHERE 
						id_pegawai		= '$id_pegawai'
				");
			} else {
				UploadPegawai($nama_file);
				$result = $config->execute("
					UPDATE tbl_pegawai SET 
						nip				= $nip,
						nama_pegawai	= $nama_pegawai,
						alamat_pegawai	= $alamat_pegawai,
						telp_pegawai	= $telp_pegawai,
						foto_pegawai 	= '$nama_file',
						email_pegawai	= $email_pegawai,
						password_pegawai= '$password_pegawai'
					WHERE 
						id_pegawai		= '$id_pegawai'
				");
				$foto_lama = $_POST['fupload_lama'];
				if ($foto_lama<>"default.jpg") {
					unlink("../../assets/img/pegawai/". $foto_lama);
				}

				$_SESSION['foto_pegawai'] = $nama_file;
				
			}

			if($result) {
				$_SESSION['status'] = '<div class="alert alert-success" role="alert">
			        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <strong>Selamat !</strong> Data berhasil diubah
			    </div>';
			}
			else {
				$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
			        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <strong>Gagal !</strong> Data gagal disimpan, mungkin data yang anda masukan salah
			    </div>';
			}
		}
		else {
			$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
		        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <strong>Gagal !</strong> Password Tidak Sama
		    </div>';
		}
		
	}
	header("Location: index.php");
}
?>
