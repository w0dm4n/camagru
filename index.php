<?php
	session_start();
	require_once("includes/all.php");
	require_once("includes/templates/header.php");
	Page((isset($_GET["page"]) ? $_GET["page"] : "home"));
	require_once("includes/templates/footer.php");
?>
