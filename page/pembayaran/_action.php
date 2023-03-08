<?php
	session_start();
	error_reporting(0);
	include_once("../../config/Config.php");

	$config = new Config();

	include "hak-akses.php";
	
	$nama_pembayaran = "'" . $config->escape_string($_POST['nama_pembayaran']) . "'";
	$nominal_pembayaran = "'" . str_replace('.','', $config->escape_string($_POST['nominal_pembayaran'])) . "'";
	$jumlah_cicilan = "'" . str_replace('.','',$config->escape_string($_POST['jumlah_cicilan'])) . "'";
	$aktif_pembayaran = "'" . $config->escape_string($_POST['aktif_pembayaran']) . "'";
	$id_rumah = "'" . json_encode($_POST['id_rumah']) . "'";
	

if(isset($_POST['simpan'])) {
	$result = $config->execute("
		INSERT INTO tbl_pembayaran(
			nama_pembayaran,
			nominal_pembayaran,
			jumlah_cicilan,
			id_rumah,
			aktif_pembayaran) 
		VALUES(
			$nama_pembayaran,
			$nominal_pembayaran,
			$jumlah_cicilan,
			$id_rumah,
			$aktif_pembayaran)
		");

	if($result) {
		$config->getHistory("Menambahkan Pembayaran " . $_POST['nama_pembayaran']);
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
	$idj1 =base64_decode($_POST['id_pembayaran']);
	$idj2 =base64_decode($idj1);
	$idj3 =base64_decode($idj2);
	$id_pembayaran 	= "'" . $config->escape_string($idj3) . "'";

	$result = $config->execute("
		UPDATE tbl_pembayaran SET 
			nama_pembayaran		= $nama_pembayaran,
			nominal_pembayaran	= $nominal_pembayaran,
			jumlah_cicilan		= $jumlah_cicilan,
			id_rumah			= $id_rumah,
			aktif_pembayaran	= $aktif_pembayaran
		WHERE 
			id_pembayaran		= $id_pembayaran
	");

	if($result) {
		$config->getHistory("Mengubah Pembayaran " . $_POST['nama_pembayaran']);
		$_SESSION['status'] = '<div class="alert alert-success" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Selamat !</strong> Data berhasil diubah
	    </div>';
		header("Location: index.php");
	} else {
		$_SESSION['status'] = '<div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <strong>Gagal !</strong> Data gagal disimpan, mungkin data yang anda masukan salah
	    </div>';
	}

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
	    //$config->execute("DELETE FROM tbl_jurusan");
		$sql = "REPLACE INTO tbl_pembayaran VALUES 
				(
				'".$rowData[0][0]."',
				'".$rowData[0][1]."',
				'".$rowData[0][2]."',
				'".$rowData[0][3]."',
				'".$rowData[0][4]."'
				)";

		if ($config->execute($sql)) {

			$exceldata[] = $rowData[0];
		} else {
			//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

	$config->getHistory("Mengimport Pembayaran");
	$_SESSION['status'] = '<div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Selamat !</strong> Data berhasil diimport
    </div>';
	echo ("<script LANGUAGE='JavaScript'>
	        window.location.href='index.php';
	        </script>");
}
else {
	$id1 =base64_decode($_GET['id']);
	$id2 =base64_decode($id1);
	$id3 =base64_decode($id2);
	$result = $config->execute("
		DELETE FROM tbl_pembayaran WHERE id_pembayaran='". $id3 ."'");

	if($result) {
		$config->getHistory("Menghapus Pembayaran");
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
