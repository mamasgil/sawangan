<?php
	session_start();
	error_reporting(0);
	include_once("../../config/Config.php");
	include "../../config/Upload.php";

	$config = new Config();

	include "hak-akses.php";
	
	$nip = "'" . $config->escape_string($_POST['nip']) . "'";
	$nama_pegawai = "'" . $config->escape_string($_POST['nama_pegawai']) . "'";
	$alamat_pegawai = "'" . $config->escape_string($_POST['alamat_pegawai']) . "'";
	$telp_pegawai = "'" . $config->escape_string($_POST['telp_pegawai']) . "'";
	$password_pegawai = hash("sha1" , (hash("sha1",$_POST['telp_pegawai'])));
	$email_pegawai = "'" . $config->escape_string($_POST['email_pegawai']) . "'";
	$level_pegawai 	= "'" . $config->escape_string($_POST['level_pegawai']) . "'";
	$aktif_pegawai 	= "'" . $config->escape_string($_POST['aktif_pegawai']) . "'";
	
	//Upload Foto
	$lokasi_file = $_FILES['fupload']['tmp_name'];
	$nama_fileex = $_FILES['fupload']['name'];
	$nama_file   = time()."-".$nama_fileex;
	$ukuran 	 = $_FILES['fupload']['size'];

if(isset($_POST['simpan'])) {
	if(empty($lokasi_file)) {
		$result = $config->execute("
			INSERT INTO tbl_pegawai(
				nip,
				nama_pegawai,
				alamat_pegawai,
				telp_pegawai,
				foto_pegawai,
				email_pegawai,
				password_pegawai,
				level_pegawai,
				aktif_pegawai) 
			VALUES(
				$nip,
				$nama_pegawai,
				$alamat_pegawai,
				$telp_pegawai,
				'default.jpg',
				$email_pegawai,
				'$password_pegawai',
				$level_pegawai,
				$aktif_pegawai
				)
			");
	}
	else {	
		UploadPegawai($nama_file);
		$result = $config->execute("
			INSERT INTO tbl_pegawai(
				nip,
				nama_pegawai,
				alamat_pegawai,
				telp_pegawai,
				foto_pegawai,
				email_pegawai,
				password_pegawai,
				level_pegawai,
				aktif_pegawai) 
			VALUES(
				$nip,
				$nama_pegawai,
				$alamat_pegawai,
				$telp_pegawai,
				'$nama_file',
				$email_pegawai,
				'$password_pegawai',
				$level_pegawai,
				$aktif_pegawai
				)
			");
	}

	if($result) {
		$config->getHistory("Menambahkan Pengguna " . $_POST['nama_pegawai']);
		$_SESSION['status'] = '<div class="alert alert-success" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Selamat !</strong> Data berhasil disimpan
	    </div>';
	} else {
		$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Gagal !</strong> Data gagal disimpan, mungkin data yang anda masukan salah
	    </div>';
	}
	
	header('Location: index.php');
}

else if (isset($_POST['update'])) {
	$id_pegawai 	= "'" . $config->escape_string($_POST['id_pegawai']) . "'";
	$result = $config->execute("
		UPDATE tbl_pegawai SET 
			nip				= $nip,
			nama_pegawai	= $nama_pegawai,
			alamat_pegawai	= $alamat_pegawai,
			telp_pegawai	= $telp_pegawai,
			level_pegawai	= $level_pegawai,
			aktif_pegawai	= $aktif_pegawai
		WHERE 
			id_pegawai		= $id_pegawai
	");
	
	if($result) {
		$config->getHistory("Mengubah Pengguna " . $_POST['nama_pegawai']);
		$_SESSION['status'] = '<div class="alert alert-success" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Selamat !</strong> Data berhasil diubah
	    </div>';

    } else {
		$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Gagal !</strong> Data gagal disimpan, mungkin data yang anda masukan salah
	    </div>';
	}
	header("Location: index.php");
}
else {
	$result = $config->execute("
		DELETE FROM tbl_pegawai WHERE id_pegawai='". $_GET['id'] ."'");
	if ($_GET['foto_pegawai']<>"default.jpg") {
		unlink("../../assets/img/pegawai/". $_GET['foto_pegawai']);
	}

	if($result) {
		$config->getHistory("Menghapus Pengguna");
		$_SESSION['status'] = '<div class="alert alert-success" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Selamat !</strong> Data berhasil dihapus
	    </div>';
	} else {
		$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Gagal !</strong> Data gagal dihapus
	    </div>';
	}

	header("Location: index.php");
} 

?>
