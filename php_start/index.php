<?php
	session_start();
	require_once("includes/all.php");
	Database::Query("SELECT * from accounts");
	while (Database::Fetch_Assoc(NULL))
	{
		echo Database::$assoc["email"] . "<br/>";
	}
	Page((isset($_GET["page"]) ? $_GET["page"] : "home"));
?>
