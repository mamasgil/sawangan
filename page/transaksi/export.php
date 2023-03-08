<?PHP
  include_once("../../config/Config.php");

  $config = new Config();

  include "hak-akses.php";
  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "Data Warga " . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $query = "SELECT t.waktu_transaksi AS 'WAKTU', s.nama_warga AS 'NAMA WARGA', CONCAT_WS(' ', k.tingkat_rumah, k.nama_rumah) AS 'NAMA RUMAH', pn.nama_pembayaran AS 'PEMBAYARAN', t.pembayaran_melalui AS 'METODE', t.nominal_transaksi AS 'NOMINAL' FROM tbl_transaksi t, tbl_warga s, tbl_pegawai p, tbl_pembayaran pn, tbl_rumah k WHERE t.id_warga = s.id_warga AND t.id_pegawai = p.id_pegawai AND t.id_pembayaran = pn.id_pembayaran AND t.id_rumah = k.id_rumah ORDER BY t.id_transaksi DESC";
  $data = $config->getData($query);

  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;
?>