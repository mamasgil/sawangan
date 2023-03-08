<?php
	session_start();
	error_reporting(0);
	include_once("../../config/Config.php");

	$config = new Config();

	include "hak-akses.php";
	

	$id1 =base64_decode($_GET['id']);
	$id2 =base64_decode($id1);
	$id3 =base64_decode($id2);
	$result = $config->execute("
		DELETE FROM tbl_transaksi WHERE id_transaksi='". $id3 ."'");

	$config->getHistory("Menghapus Pembayaran");
	$_SESSION['status'] = '<div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Selamat !</strong> Data berhasil dihapus
    </div>';


	header("Location: index.php");

?>
