<?php
	session_start();
	error_reporting(0);
	include_once("../../config/Config.php");
	include "../../config/Upload.php";

	$config = new Config();

	include "hak-akses.php";
	
	$id_transaksi = "'" . $_POST['id_transaksi'] . "'";
	$waktu_transaksi = date('Y-m-d H:i:s');
	$id_warga = "'" . $config->escape_string($_POST['id_warga']) . "'";
	$id_rumah = "'" . $config->escape_string($_POST['id_rumah']) . "'";
	$id_pegawai = $_SESSION['id_pegawai'];
	$id_pembayaran = "'" . $config->escape_string($_POST['id_pembayaran']) . "'";
	$nominal_transaksi = "'" . str_replace('.','', $config->escape_string($_POST['nominal_transaksi'])) . "'";
	$pembayaran_melalui = "'" . $config->escape_string($_POST['pembayaran_melalui']) . "'";
	$cicilan_transaksi = "'" . $config->escape_string($_POST['jumlah_cicilan']) . "'";
	
	//Upload Foto
	$lokasi_file = $_FILES['fupload']['tmp_name'];
	$nama_fileex = $_FILES['fupload']['name'];
	$nama_file   = time()."-".$nama_fileex;
	$ukuran 	 = $_FILES['fupload']['size'];

if(isset($_POST['bayar'])) {
	if(empty($lokasi_file)) {
		$result = $config->execute("
			INSERT INTO tbl_transaksi(
				id_transaksi,
				waktu_transaksi,
				id_warga,
				id_rumah,
				id_pegawai,
				id_pembayaran,
				nominal_transaksi,
				pembayaran_melalui,
				file_foto,
				cicilan_transaksi) 
			VALUES(
				$id_transaksi,
				'$waktu_transaksi',
				$id_warga,
				$id_rumah,
				$id_pegawai,
				$id_pembayaran,
				$nominal_transaksi,
				$pembayaran_melalui,
				'0',
				$cicilan_transaksi)
			");
	} else {
		UploadPembayaran($nama_file);
		$result = $config->execute("
			INSERT INTO tbl_transaksi(
				id_transaksi,
				waktu_transaksi,
				id_warga,
				id_pegawai,
				id_pembayaran,
				nominal_transaksi,
				pembayaran_melalui,
				file_foto,
				cicilan_transaksi) 
			VALUES(
				$id_transaksi,
				'$waktu_transaksi',
				$id_warga,
				$id_pegawai,
				$id_pembayaran,
				$nominal_transaksi,
				$pembayaran_melalui,
				'$nama_file',
				$cicilan_transaksi)
			");
	}

	if($result) {
		$config->getHistory("Melakukan Transaksi");
		$id_transaksi	= base64_encode(base64_encode(base64_encode($_POST['id_transaksi'])));
		$id_warga 		= base64_encode(base64_encode(base64_encode($_POST['id_warga'])));
		$id_rumah 		= base64_encode(base64_encode(base64_encode($_POST['id_rumah'])));
		$id_pembayaran 	= base64_encode(base64_encode(base64_encode($_POST['id_pembayaran'])));
		$cicilan 		= base64_encode(base64_encode(base64_encode($_POST['jumlah_cicilan'])));

		$_SESSION['cetak'] = "<script>window.open('cetak.php?id=". $id_transaksi . "&warga=". $id_warga."&pembayaran=". $id_pembayaran."&cicilan=". $cicilan. "&id_rumah=". $id_rumah. "', '_blank');</script>";
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
		DELETE FROM tbl_pembayaran WHERE id_pembayaran='". $_GET['id'] ."'");

	if($result) {
		$config->getHistory("Menghapus Transaksi");
		$_SESSION['status'] = '<div class="alert alert-success" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Selamat !</strong> Data berhasil dihapus
	    </div>';
	}
	else {
		$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Gagal !</strong> Data gagal dihapus
	    </div>';
	}

	header("Location: index.php");
} 

?>
