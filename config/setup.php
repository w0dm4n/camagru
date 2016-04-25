<?php
	require_once("database.php");
	require_once("../includes/class/database.php");
	if (isset($_GET["installation"]))
	{
		Database::StartConnection($DB_DSN, $DB_USER, $DB_PASSWORD);
		Database::Query("DROP TABLE IF EXISTS accounts");
		Database::Query("DROP TABLE IF EXISTS comments");
		Database::Query("DROP TABLE IF EXISTS gallery");
		Database::Query("DROP TABLE IF EXISTS images");
		Database::Query("DROP TABLE IF EXISTS reset");
		Database::Query(file_get_contents("tables/accounts.sql"));
		Database::Query(file_get_contents("tables/comments.sql"));
		Database::Query(file_get_contents("tables/gallery.sql"));
		Database::Query(file_get_contents("tables/images.sql"));
		Database::Query(file_get_contents("tables/reset.sql"));
		$content = file_get_contents("tables/images_data.sql");
		$i = 0;
		$query = NULL;
		while ($content[$i] != NULL)
		{
			if ($content[$i] == "\n")
			{
				Database::Query($query);
				$query = NULL;
			}
			$query = ''.$query.''.$content[$i].'';
			$i++;
		}
		echo '<center>La base de donnée a été installé avec succès !</center>';
	}
	else
	{
		echo '<center>Cliquez <a href="?installation">ici</a> pour installer la base de donnée avec les informations disponible dans <i>database.php<i/></center>';
	}
?>