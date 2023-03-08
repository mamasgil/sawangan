<?php

function UploadPembayaran($fupload_name){

  $vdir_upload = "../../assets/img/bukti_pembayaran/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $tipe_file   = $_FILES['fupload']['type'];
  $size      = $_FILES['fupload']['size'];
  
  if($size < 10000000) { //ukuran gambar
    move_uploaded_file($_FILES['fupload']["tmp_name"], $vfile_upload);
  } else{
    echo "Ukuran Gambar tidak sesuai";
  }
}


function UploadSiswa($fupload_name){

  $vdir_upload = "../../assets/img/siswa/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $tipe_file   = $_FILES['fupload']['type'];
  $size      = $_FILES['fupload']['size'];
  
  if($size < 10000000) { //ukuran gambar
    move_uploaded_file($_FILES['fupload']["tmp_name"], $vfile_upload);
  } else{
    echo "Ukuran Gambar tidak sesuai";
  }
}

function UploadPegawai($fupload_name){

  $vdir_upload = "../../assets/img/pegawai/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $tipe_file   = $_FILES['fupload']['type'];
  $size      = $_FILES['fupload']['size'];
  
  if($size < 10000000) { //ukuran gambar
    move_uploaded_file($_FILES['fupload']["tmp_name"], $vfile_upload);
  } else{
    echo "Ukuran Gambar tidak sesuai";
  }
}

?>
