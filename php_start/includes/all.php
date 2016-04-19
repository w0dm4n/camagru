<?php
	/* DATABASE CONFIGURATION */
	require_once("config/database.php");
	/* DATABASE CONFIGURATION */

/* CLASS */
	require_once("class/database.php");
/* CLASS */

Database::StartConnection($DB_DSN, $DB_USER, $DB_PASSWORD);

/* FUNCTIONS */
	require_once("functions/page.php");
/* FUNCTIONS */
error_reporting(E_ALL);
?>