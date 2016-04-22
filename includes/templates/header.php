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
                        <ul><li><a href="?page=gallery"><br/><br/>Galerie</a></li></ul>
                    </form>
					       <img style="position:absolute;margin-left:-105px;margin-top:15px;max-height:200px;max-width:200px;" src="img/logo.png"/>
                    <form style="text-align: right; margin-top: -16px;">';
                    if (empty($_SESSION["email"]))
                    {
                       echo '<ul><li><a href="?page=login"><br/><br/>Connexion</a></li></ul>
                             <ul><li><a href="?page=register"><br/><br/>Inscription</a></li></ul>';
                  	}
                  	else
                  	{
                  		echo '<ul><li><a href="?page=upload"><br/><br/>Ajouter</a></li></ul>
                  		      <ul><li><a href="?page=logout"><br/><br/>Déconnexion</a></li></ul>';
             		}
                  echo '</form>
						</div>';
?>