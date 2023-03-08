<?php
	session_start();
	error_reporting(0);
	include_once("../../config/Config.php");
	include "../../config/Upload.php";

	$config = new Config();

	include "hak-akses.php";

	$hak_akses = "'" . $config->escape_string($_POST['hak_akses']) . "'";
	$jurusan = "'" . $config->escape_string($_POST['jurusan']) . "'";
	$kelas = "'" . $config->escape_string($_POST['kelas']) . "'";
	$pengguna = "'" . $config->escape_string($_POST['pengguna']) . "'";
	$siswa = "'" . $config->escape_string($_POST['siswa']) . "'";
	$laporan_jenis_pembayaran = "'" . $config->escape_string($_POST['laporan_jenis_pembayaran']) . "'";
	$laporan_pembayaran = "'" . $config->escape_string($_POST['laporan_pembayaran']) . "'";
	$laporan_siswa = "'" . $config->escape_string($_POST['laporan_siswa']) . "'";
	$laporan_jurusan = "'" . $config->escape_string($_POST['laporan_jurusan']) . "'";
	$laporan_kelas = "'" . $config->escape_string($_POST['laporan_kelas']) . "'";
	$laporan_pengguna = "'" . $config->escape_string($_POST['laporan_pengguna']) . "'";
	$backup = "'" . $config->escape_string($_POST['backup']) . "'";
	$pembayaran = "'" . $config->escape_string($_POST['pembayaran']) . "'";
	$transaksi = "'" . $config->escape_string($_POST['transaksi']) . "'";
	$hapus_pembayaran = "'" . $config->escape_string($_POST['hapus_pembayaran']) . "'";

	if (isset($_POST['update'])) {
		$level_pegawai 	= "'" . $config->escape_string($_POST['level_pegawai']) . "'";

		$result = $config->execute("
			UPDATE tbl_hak_akses SET 
				hak_akses = $hak_akses,
				jurusan	= $jurusan,
				kelas	= $kelas,
				pengguna= $pengguna,
				siswa	= $siswa,
				laporan_jenis_pembayaran	= $laporan_jenis_pembayaran,
				laporan_pembayaran	= $laporan_pembayaran,
				laporan_siswa	= $laporan_siswa,
				laporan_jurusan	= $laporan_jurusan,
				laporan_kelas	= $laporan_kelas,
				laporan_pengguna	= $laporan_pengguna,
				backup	= $backup,
				pembayaran	= $pembayaran,
				transaksi	= $transaksi,
				hapus_pembayaran	= $hapus_pembayaran
			WHERE 
				level_pegawai		= $level_pegawai
		");
		
		if($result) {
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


?>
