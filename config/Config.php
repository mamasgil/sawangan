<?php
@session_start();
include_once 'DbConfig.php';

// Settings
$base_url 			= "http://localhost/sawangan/";
$name_application 	= "Aplikasi Pembarayaran Iuran Warga";
$company			= "Aplikasi Pembarayaran Iuran Warga";
$address			= "Jalan Raya Bekasi Timur No.20 Sisi Jalan Layang Klender Jakarta Timur 13250";
$logo				= "assets/logo2.png";
$copyright			= "&copy; 2023 Giji Project";
$copyright_link		= "http://smkgaruda.ezyro.com";
$key				= "sdfkgsdjsmenqeufdvxbnsdjskaklslwhksfjxfnmsdkwei";

// Setting Waktu
date_default_timezone_set("Asia/Bangkok");


// Library
class Config extends DbConfig
{
	public function __construct()
	{
		parent::__construct();
		
		// Untuk Statistik Pengunjung
		$ip = $_SERVER['REMOTE_ADDR'];
		$tgl = date('Y-m-d');

		$this->connection->query("INSERT INTO statistik(ip, tanggal)VALUES('$ip','$tgl')");
	}
	
	public function getData($query)
	{		
		$result = $this->connection->query($query);
		
		if ($result == false) {
			return false;
		} 
		
		$rows = array();
		
		while ($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}
		
		return $rows;
	}

	public function getHistory($keterangan)
	{		
		$id_pegawai = "'" . $_SESSION['id_pegawai'] . "'";
		$waktu_history = "'" . date('Y-m-d H:i:s') . "'";
		$result = $this->connection->query("INSERT INTO tbl_history (id_pegawai, waktu_history, keterangan_history) VALUES ($id_pegawai, $waktu_history, '$keterangan')");

		if ($result == false) {
			echo 'Error: cannot execute the command';
			return false;
		} else {
			return true;
		}
	}
		
	public function execute($query) 
	{
		$result = $this->connection->query($query);
		
		if ($result == false) {
			echo 'Error: cannot execute the command';
			return false;
		} else {
			return true;
		}		
	}

	public function escape_string($value)
	{
		$data = htmlspecialchars($value);
		return $this->connection->real_escape_string($data);
	}


	// Helper
	function cetak($str){
        return strip_tags(htmlentities($str, ENT_QUOTES, 'UTF-8'));
    }

    function tgl_indo($tgl){
        $tanggal = substr($tgl,8,2);
        $bulan = $this->getBulan(substr($tgl,5,2));
        $tahun = substr($tgl,0,4);
        return $tanggal.' '.$bulan.' '.$tahun;       
    } 

    function format_rupiah($angka){
     $rupiah=number_format($angka,0,',','.');
     return "Rp. ".$rupiah;
    }

    function format_ribuan($angka){
     $ribuan=number_format($angka,0,',','.');
     return $ribuan;
    }

    function tgl_simpan($tgl){
            $tanggal = substr($tgl,0,2);
            $bulan = substr($tgl,3,2);
            $tahun = substr($tgl,6,4);
            return $tahun.'-'.$bulan.'-'.$tanggal;       
    }

    function tgl_view($tgl){
            $tanggal = substr($tgl,8,2);
            $bulan = substr($tgl,5,2);
            $tahun = substr($tgl,0,4);
            return $tanggal.'-'.$bulan.'-'.$tahun;       
    }

    function tgl_grafik($tgl){
            $tanggal = substr($tgl,8,2);
            $bulan = $this->getBulan(substr($tgl,5,2));
            $tahun = substr($tgl,0,4);
            return $tanggal.'-'.$bulan;       
    }   

    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    } 

    function hari_ini($w){
        $seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $hari_ini = $seminggu[$w];
        return $hari_ini;
    }

    function getBulan($bln){
        switch ($bln){
            case 1: 
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Agu";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    } 

	function cek_terakhir($datetime, $full = false) {
		 $today = time();    
	     $createdday= strtotime($datetime); 
	     $datediff = abs($today - $createdday);  
	     $difftext="";  
	     $years = floor($datediff / (365*60*60*24));  
	     $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
	     $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
	     $hours= floor($datediff/3600);  
	     $minutes= floor($datediff/60);  
	     $seconds= floor($datediff);  
	     //year checker  
	     if($difftext=="")  
	     {  
	       if($years>1)  
	        $difftext=$years." Tahun";  
	       elseif($years==1)  
	        $difftext=$years." Tahun";  
	     }  
	     //month checker  
	     if($difftext=="")  
	     {  
	        if($months>1)  
	        $difftext=$months." Bulan";  
	        elseif($months==1)  
	        $difftext=$months." Bulan";  
	     }  
	     //month checker  
	     if($difftext=="")  
	     {  
	        if($days>1)  
	        $difftext=$days." Hari";  
	        elseif($days==1)  
	        $difftext=$days." Hari";  
	     }  
	     //hour checker  
	     if($difftext=="")  
	     {  
	        if($hours>1)  
	        $difftext=$hours." Jam";  
	        elseif($hours==1)  
	        $difftext=$hours." Jam";  
	     }  
	     //minutes checker  
	     if($difftext=="")  
	     {  
	        if($minutes>1)  
	        $difftext=$minutes." Menit";  
	        elseif($minutes==1)  
	        $difftext=$minutes." Menit";  
	     }  
	     //seconds checker  
	     if($difftext=="")  
	     {  
	        if($seconds>1)  
	        $difftext=$seconds." Detik";  
	        elseif($seconds==1)  
	        $difftext=$seconds." Detik";  
	     }  
	     return $difftext;  
	}

	function arab($string) {
	    $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
	    $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

	    $str = str_replace($western_arabic, $eastern_arabic, $string);

	    return $str;
	}

	public function ucapan() {
		$b = time();
		$hour = date("G",$b);
		$ucapan = "";
		if ($hour>=0 && $hour<=11)
		{
			$ucapan = "Selamat Pagi ";
		}
		elseif ($hour >=12 && $hour<=14)
		{
			$ucapan = "Selamat Siang ";
		}
		elseif ($hour >=15 && $hour<=17)
		{
			$ucapan = "Selamat Sore ";
		}
		elseif ($hour >=17 && $hour<=18)
		{
			$ucapan = "Selamat Petang ";
		}
		elseif ($hour >=19 && $hour<=23)
		{
			$ucapan = "Selamat Malam ";
		}

		return $ucapan;

	}
	function waktu( $ptime )
	{
	    $estimate_time = time() - $ptime;

	    if( $estimate_time < 1 )
	    {
	        return 'beberapa menit yang lalu';
	    }

	    $condition = array( 
	                12 * 30 * 24 * 60 * 60  =>  'tahun',
	                30 * 24 * 60 * 60       =>  'bulan',
	                24 * 60 * 60            =>  'hari',
	                60 * 60                 =>  'jam',
	                60                      =>  'menit',
	                1                       =>  'detik'
	    );

	    foreach( $condition as $secs => $str )
	    {
	        $d = $estimate_time / $secs;

	        if( $d >= 1 )
	        {
	            $r = round( $d );
	            return 'sekitar ' . $r . ' ' . $str . ( $r > 1 ? '' : '' ) . ' lalu';
	        }
	    }
	}

	// untuk menghilangkan spesial charackter
	function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	function get_times( $default = '19:00', $interval = '+60 minutes' ) {

	    $output = '';

	    $current = strtotime( '07:00' );
	    $end = strtotime( '17:00' );

	    while( $current <= $end ) {
	        $time = date( 'H:i', $current );
	        $sel = ( $time == $default ) ? ' selected' : '';

	        $output .= "<option value=\"{$time}\"{$sel}>" . date( 'H.i', $current ) .'</option>';
	        $current = strtotime( $interval, $current );
	    }

	    return $output;
	}

	function custom_number_format($n, $precision = 0) {
	    if ($n < 1000000) {
	        // Anything less than a million
	        $n_format = number_format($n/1000) . 'Rb';
	    } else if ($n < 1000000000) {
	        // Anything less than a billion
	        $n_format = number_format($n / 1000000, $precision) . 'Jt';
	    } else {
	        // At least a billion
	        $n_format = number_format($n / 1000000000, $precision) . 'M';
	    }

	    return $n_format;
	}


	// Kode otomatis transaksi
	function kode_transaksi(){          
		$query = $this->connection->query('SELECT RIGHT(id_transaksi, 12) as kode FROM tbl_transaksi ORDER BY id_transaksi DESC limit 1');
		$kode = 1;    
		foreach ($query as $q) {
		    $kode = intval($q['kode']) + 1;
		}      

		$kodemax = str_pad($kode, 12, "0", STR_PAD_LEFT);     
		$kodejadi = "TR-".$kodemax;      
		return $kodejadi;   
	}

	//Kode Otomatis Cicilan
	function kode_cicilan($id_warga, $id_rumah, $id_pembayaran){          
		$query = $this->connection->query("SELECT count(*) as kode FROM tbl_transaksi, tbl_warga WHERE tbl_transaksi.id_warga = tbl_warga.id_warga AND tbl_transaksi.id_warga='$id_warga' AND tbl_transaksi.id_pembayaran='$id_pembayaran' AND tbl_transaksi.id_rumah = '$id_rumah' AND tbl_transaksi.id_rumah = tbl_warga.id_rumah ORDER BY tbl_transaksi.id_transaksi DESC"); 

		$kode = 1;     
		foreach ($query as $q) {
		    $kode = intval($q['kode']) + 1; 
		}      
		return $kode;   
	}


	// Untuk nominal uang menjadi terbilang

	public function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return ucfirst($hasil) ." rupiah";
	}

	function format_romawi($integer)
	{
	 // Convert the integer into an integer (just to make sure)
	 $integer = intval($integer);
	 $result = '';
	 
	 // Create a lookup array that contains all of the Roman numerals.
	 $lookup = array('M' => 1000,
	 'CM' => 900,
	 'D' => 500,
	 'CD' => 400,
	 'C' => 100,
	 'XC' => 90,
	 'L' => 50,
	 'XL' => 40,
	 'X' => 10,
	 'IX' => 9,
	 'V' => 5,
	 'IV' => 4,
	 'I' => 1);
	 
	 foreach($lookup as $roman => $value){
	  // Determine the number of matches
	  $matches = intval($integer/$value);
	 
	  // Add the same number of characters to the string
	  $result .= str_repeat($roman,$matches);
	 
	  // Set the integer to be the remainder of the integer and the value
	  $integer = $integer % $value;
	 }
	 
	 // The Roman numeral should be built, return it
	 return $result;
	}

	//clean json
	function clean_json($string) {
	   return str_replace( array('"','[',']' ), array('\'','','' ), $string);

	}
}
?>
