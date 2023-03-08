<?php
	session_start();

	if(empty($_SESSION['kodeakses'])) {
		header("location: login.php");
	}
	else {
		header("location: page/dashboard");
	}
    
?>