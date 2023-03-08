<?php
	session_start();
	error_reporting(0);
	include_once("../../config/Config.php");
	include "../../config/Upload.php";

	$config = new Config();

	include "hak-akses.php";
	
	$nis = "'" . $config->escape_string($_POST['nis']) . "'";
	$nama_warga = "'" . $config->escape_string($_POST['nama_warga']) . "'";
	$jekel_warga = "'" . $config->escape_string($_POST['jekel_warga']) . "'";
	$alamat_warga = "'" . $config->escape_string($_POST['alamat_warga']) . "'";
	$id_rumah 	= "'" . $config->escape_string($_POST['id_rumah']) . "'";
	$aktif_warga 	= "'" . $config->escape_string($_POST['aktif_warga']) . "'";
	$angkatan_warga 	= "'" . $config->escape_string($_POST['angkatan_warga']) . "'";
	
	//Upload Foto
	$lokasi_file = $_FILES['fupload']['tmp_name'];
	$nama_fileex = $_FILES['fupload']['name'];
	$nama_file   = time()."-".$nama_fileex;
	$ukuran 	 = $_FILES['fupload']['size'];

if(isset($_POST['simpan'])) {
	if(empty($lokasi_file)) {
		$result = $config->execute("
			INSERT INTO tbl_warga(
				nis,
				nama_warga,
				jekel_warga,
				alamat_warga,
				foto_warga,
				id_rumah,
				aktif_warga,
				angkatan_warga) 
			VALUES(
				$nis,
				$nama_warga,
				$jekel_warga,
				$alamat_warga,
				'default.jpg',
				$id_rumah,
				$aktif_warga,
				$angkatan_warga)
			");
	}
	else {	
		Uploadwarga($nama_file);
		$result = $config->execute("
			INSERT INTO tbl_warga(
				nis,
				nama_warga,
				jekel_warga,
				alamat_warga,
				foto_warga,
				id_rumah,
				aktif_warga,
				angkatan_warga) 
			VALUES(
				$nis,
				$nama_warga,
				$jekel_warga,
				$alamat_warga,
				'$nama_file',
				$id_rumah,
				$aktif_warga,
				$angkatan_warga)
			");
	}

	if($result) {
		$config->getHistory("Menambahkan Warga " . $_POST['nama_warga']);
		$_SESSION['status'] = '<div class="alert alert-success" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Selamat !</strong> Data berhasil disimpan
	    </div>';
	}
	else {
		$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Gagal !</strong> Data gagal disimpan, mungkin data yang anda masukan salah
	    </div>';
	}

	header('Location: index.php');
}

else if (isset($_POST['update'])) {
	$idj1 =base64_decode($_POST['id_warga']);
	$idj2 =base64_decode($idj1);
	$idj3 =base64_decode($idj2);
	$id_warga 	= "'" . $config->escape_string($idj3) . "'";
	if(empty($lokasi_file)) {
		$result = $config->execute("
			UPDATE tbl_warga SET 
				nis				= $nis,
				nama_warga		= $nama_warga,
				jekel_warga		= $jekel_warga,
				alamat_warga	= $alamat_warga,
				id_rumah		= $id_rumah,
				aktif_warga		= $aktif_warga,
				angkatan_warga	= $angkatan_warga
			WHERE 
				id_warga		= $id_warga
		");
	} else {
		UploadWarga($nama_file);
		$result = $config->execute("
			UPDATE tbl_warga SET 
				nis				= $nis,
				nama_warga		= $nama_warga,
				jekel_warga		= $jekel_warga,
				alamat_warga	= $alamat_warga,
				foto_warga		= '$nama_file',
				id_rumah		= $id_rumah,
				aktif_warga		= $aktif_warga,
				angkatan_warga	= $angkatan_warga
			WHERE 
				id_warga		= $id_warga
		");
		$foto_lama = $_POST['fupload_lama'];
		if ($foto_lama<>"default.jpg") {
			unlink("../../assets/img/warga/". $foto_lama);
		}
		
	}

	if($result) {
		$config->getHistory("Mengubah Warga " . $_POST['nama_warga']);
		$_SESSION['status'] = '<div class="alert alert-success" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Selamat !</strong> Data berhasil disimpan
	    </div>';
	}
	else {
		$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Gagal !</strong> Data gagal disimpan, mungkin data yang anda masukan salah
	    </div>';
	}
	header("Location: index.php");
}
else if (isset($_POST['import'])) {
	set_time_limit(0);
 
	require '../../config/PHPExcel/PHPExcel/IOFactory.php';
	$inputfilename = $_FILES["url_file"]["tmp_name"];
	$exceldata = array();

	//  Read your Excel workbook
	try
	{
	    $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
	    $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
	    $objPHPExcel = $objReader->load($inputfilename);
	}
	catch(Exception $e)
	{
	    die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
	}

	//  Get worksheet dimensions
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow(); 
	$highestColumn = $sheet->getHighestColumn();

	//  Loop through each row of the worksheet in turn
			
	for ($row = 2; $row <= $highestRow; $row++) //baris ke 2 (tanpa judul kolom)
	{ 
		// Calculate the percentation http://stackoverflow.com/questions/15298071/progress-bar-with-mysql-query-with-php
		$percent = intval($row/$highestRow * 100)."%";

		// Javascript for updating the progress bar and information
	  echo '<script language="javascript">
	  document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
	  document.getElementById("information").innerHTML="'.$row.' data pegawai sedang diproses.";
	  </script>';

	  // This is for the buffer achieve the minimum size in order to flush data
	  echo str_repeat(' ',1024*64);

	  // Send output to browser immediately
	  flush();

	  // Sleep one second so we can see the delay
	  sleep(0);
	  
	    //  Read a row of data into an array
	    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
		
	    //  Insert row data array into your database of choice here
		$sql = "REPLACE INTO tbl_warga VALUES 
				(
				'".$rowData[0][0]."',
				'".$rowData[0][1]."',
				'".$rowData[0][2]."',
				'".$rowData[0][3]."',
				'".$rowData[0][4]."',
				'".$rowData[0][5]."',
				'".$rowData[0][6]."',
				'".$rowData[0][7]."',
				'".$rowData[0][8]."'
				)";

		if ($config->execute($sql)) {

			$exceldata[] = $rowData[0];
		} else {
			//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

	$config->getHistory("Mengimport Warga " . $_POST['nama_warga']);
	
	$_SESSION['status'] = '<div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Selamat !</strong> Data berhasil diimport
    </div>';
	echo ("<script LANGUAGE='JavaScript'>
	        window.location.href='index.php';
	        </script>");
}

else if($_GET['kenaikanrumah']=='TRUE') {
	$lengkap = '';
	$cek_rumah = $config->getData("SELECT count(*) as total FROM tbl_rumah");
	foreach ($cek_rumah as $ck) {
		$total_rumah = $ck['total'];
		$cek_rumah2 = $config->getData("SELECT count(DISTINCT nama_rumah) as total FROM tbl_rumah");
		foreach ($cek_rumah2 as $ck2) {
			$total_rumah2 = $ck2['total'] * 3;
			if($total_rumah == $total_rumah2) {
				$cek_rumah = $config->getData("SELECT * FROM tbl_warga");
				foreach ($cek_rumah as $ck) {
					$id_rumah = $ck['id_rumah'];
					$cek_nama_rumah = $config->getData("SELECT * FROM tbl_rumah WHERE id_rumah='". $id_rumah ."'");
					foreach ($cek_nama_rumah as $cnk) {
						$tingkat_rumah = $cnk['tingkat_rumah']+1;
						$nama_rumah = $cnk['nama_rumah'];

						if($tingkat_rumah<=12) {
							$cek_id_rumah = $config->getData("SELECT * FROM tbl_rumah WHERE tingkat_rumah='". $tingkat_rumah ."' AND nama_rumah='". $nama_rumah ."'");
							foreach ($cek_id_rumah as $cik) {
								$ganti_id = $cik['id_rumah'];
								$result = $config->execute("UPDATE tbl_warga SET id_rumah='". $ganti_id . "' WHERE id_rumah='". $id_rumah ."'");
							}
						} else {
							$result = $config->execute("UPDATE tbl_warga SET aktif_warga='11' WHERE id_rumah='". $id_rumah ."'");
						}	

					}	
				}

				if($result) {
					$config->getHistory("Menaikan Seluruh rumah ");
					$_SESSION['status'] = '<div class="alert alert-success" role="alert">
				        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <strong>Selamat !</strong> rumah berhasil dinaikkan
				    </div>';
				}
				else {
					$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
				        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <strong>Gagal !</strong> rumah Gagal dinaikkan
				    </div>';
				}
				header("Location: index.php");
			}
			else {
				$lengkap = 'TIDAK';
			}	
		}
	}

	if($lengkap=='TIDAK') {
		$_SESSION['status'] = '';
		$rumah_lengkap = $config->getData("SELECT * FROM tbl_rumah");
		foreach ($rumah_lengkap as $kl) {
			for ($i=10; $i <= 12; $i++) { 
				$rumah_lengkap2 = $config->getData("SELECT count(*) as total FROM tbl_rumah WHERE tingkat_rumah='". $i . "' AND nama_rumah='". $kl['nama_rumah'] ."'");

				foreach ($rumah_lengkap2 as $kl2) {
					if($kl2['total']==0) {
						$_SESSION['status'] .= '<div class="alert alert-danger" role="alert">
					        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					        <strong>Gagal !</strong> rumah '. $config->format_romawi($i) . ' ' . $kl['nama_rumah'].' Tidak ada, Mohon ditambahkan kedata rumah
					    </div>';
						
					}
					
				}
			}
		}
		header("Location: index.php");
	}
}
		

else {
	$id1 =base64_decode($_GET['id']);
	$id2 =base64_decode($id1);
	$id3 =base64_decode($id2);
	$result = $config->execute("
		DELETE FROM tbl_warga WHERE id_warga='". $id3 ."'");
	if ($_GET['foto_warga']<>"default.jpg") {
		unlink("../../assets/img/warga/". $_GET['foto_warga']);
	}

	if($result) {
		$config->getHistory("Menghapus warga " . $_POST['nama_warga']);
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
