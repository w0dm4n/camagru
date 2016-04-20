<?php
echo '<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru !</title>
		<link rel="stylesheet" type="text/css" href="camagru.css">
	</head>
	<body>
		<center>
			<div id="Centre">
				<div class="header">
                    <form class="button">
                        <a href="?page=gallery"><input style="width: 110px; height: 60px; font-size: 100px;" type="button" value="Galerie"></input></a>
                    </form>
					<h1 style="display: inline-block;">Camagru</h1>
                    <form style="text-align: right; margin-top: -50px; margin-right: 15px;">';
                    if (empty($_SESSION["email"]))
                    {
                       echo '<a href="?page=login"><input style="width: 110px; height: 60px; font-size: 100px;" type="button" value="Connexion"></input></a>
                       <a href="?page=register"><input style="width: 110px; height: 60px; font-size: 100px;" type="button" value="Inscription"></input></a>';
                  	}
                  	else
                  	{
                  		echo '<a href="?page=upload"><input style="width: 110px; height: 60px; font-size: 100px;" type="button" value="Ajouter"></input></a>
                  		<a href="?page=logout"><input style="width: 110px; height: 60px; font-size: 100px;" type="button" value="Déconnexion"></input></a>';
             		}
                  echo '</form>
						</div>';
?>