<?php
session_start();
include_once("../config/Config.php");
$config = new Config();

$config->getHistory("Telah Logout");
if(session_destroy()) // Destroying All Sessions
{
	header("Location: ../login.php"); // Redirecting To Home Page

}


?>