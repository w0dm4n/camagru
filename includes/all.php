<?php
	/* DATABASE CONFIGURATION */
	require_once("config/database.php");
	/* DATABASE CONFIGURATION */

/* CLASS */
	require_once("class/database.php");
	require_once("class/account.php");
	/* CLASS */

Database::StartConnection($DB_DSN, $DB_USER, $DB_PASSWORD);

/* FUNCTIONS */
	require_once("functions/resize_image.php");
	require_once("functions/page.php");
	require_once("functions/print.php");
	require_once("functions/redirect.php");
	require_once("functions/secure.php");
	require_once("functions/send_email.php");
	require_once("functions/randomKey.php");
	require_once("functions/check_extension.php");
/* FUNCTIONS */
error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris');
?>
