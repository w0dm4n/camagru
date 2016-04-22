<?php
		if (isset($_GET["action"]))
		{
			if (!empty($_SESSION["email"]))
			{
				if (isset($_GET["id"]))
				{
					$action = secure($_GET["action"], 1);
					$id = secure($_GET["id"], 0);
					
					Database::Query('SELECT * FROM gallery WHERE id = "'.$id.'"');
					if (Database::Get_Rows(NULL))
					{
						Database::Fetch_Assoc(NULL);
						switch ($action)
						{
							case "like":
								Database::Query('UPDATE gallery SET like_img = "'.(intval(Database::$assoc["like_img"]) + 1).'" WHERE id = "'.$id.'"');
								Redirect("gallery", 0);
							break ;
						
							case "dislike":
								Database::Query('UPDATE gallery SET dontlike_img = "'.(intval(Database::$assoc["dontlike_img"]) + 1).'" WHERE id = "'.$id.'"');
								Redirect("gallery", 0);
							break ;
						}
					}
					else
						Redirect("gallery", 0);
				}
				else
					Redirect("gallery", 0);
			}
			else
			{
				 echo '<div class="middle">
                		<h1 style="margin-top: 400px;color:#BD2727;">Erreur 403 - Vous devez être connecter pour accéder a cette page</h1>
            		 </div>';
			}
		}
		else
		{
			Database::Query('SELECT * FROM gallery ORDER BY date_creation DESC');
			if (Database::Get_Rows(NULL))
			{
				echo '<div class="middle_galerie">';
				while (Database::Fetch_Assoc(NULL))
				{
					 echo '<div id="galerie">
							<a href=""><img class="img_gal" src="'.Database::$assoc["image_path"].'" /></a>
							<form style="text-align: right; margin-right: 10px; margin-top: 6px;">
							<br/>
							<a href="" style="text-decoration: none;"><font style="margin-right: 570px; margin-top: -20px; text-decoration: none; display: inline-block;"><a style="text-decoration:none;" href="?page=gallery&action=like&id='.Database::$assoc["id"].'"> &#128077</a> '.Database::$assoc["like_img"].'</font></a>
							<a href="" style="text-decoration: none;"><font style="margin-right: 515px; margin-top: -26px; display: inline-block;"><a style="text-decoration:none;" href="?page=gallery&action=dislike&id='.Database::$assoc["id"].'">&#128078</a> '.Database::$assoc["dontlike_img"].'</font></a>
							</form>
						</div>';
				}
				echo '</div>';
			}
			else
			{
				echo '<div class="middle">
						<h1 style="margin-top: 30px;">Galerie</h1>
						Désolé, il n\'y a aucune image dans la galerie pour le moment !
					</div>';
			}
		}
?>