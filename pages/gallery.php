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
			$trie = 1;
			$article_max = 4;
			if (isset($_GET['trie']))
				$trie = intval($_GET['trie']);
			Database::Query('SELECT * FROM gallery');
			if (Database::Get_Rows(NULL))
			{
				$max_page = Database::$rows / $article_max;
				if (($max_page - floor($max_page)) > 0.00)
					$max_page++;
			}
			else
				$max_page = 1;
			if ($trie < 1 || $trie > $max_page)
				$trie = 1;
			$nbr = $article_max;
			Database::Query('SELECT * FROM gallery ORDER BY date_creation DESC LIMIT '.(($trie * $article_max) - $article_max).','.($trie * $article_max).'');
			if (Database::Get_Rows(NULL))
			{
				echo '<div class="middle_galerie">';
				while (Database::Fetch_Assoc(NULL))
				{
					if ($nbr == 0)
						break ;
					$nbr--;
					 echo '<div id="galerie">
							<a href="?page=comment&id='.Database::$assoc["id"].'"><img class="img_gal" src="'.Database::$assoc["image_path"].'" /></a>
							<form style="text-align: right; margin-right: 10px; margin-top: 6px;">
							<br/>
							<a href="" style="text-decoration: none;"><font style="margin-right: 570px; margin-top: -20px; text-decoration: none; display: inline-block;"><a style="text-decoration:none;" href="?page=gallery&action=like&id='.Database::$assoc["id"].'"> &#128077</a> '.Database::$assoc["like_img"].'</font></a>
							<a href="" style="text-decoration: none;"><font style="margin-right: 515px; margin-top: -26px; display: inline-block;"><a style="text-decoration:none;" href="?page=gallery&action=dislike&id='.Database::$assoc["id"].'">&#128078</a> '.Database::$assoc["dontlike_img"].'</font></a>
							</form>
						</div>';
				}
				echo '</div>';
				echo '<br/>';
				echo '<div style="border-bottom: 4px solid #C3D825;"></div>';
				if (($trie) > 1)
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie=1">«</a>';
				if (($trie - 3) <= floor($max_page) && ($trie - 3) > 0)
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie='.($trie - 3).'">'.($trie - 3).'</a>';
				if (($trie - 2) <= floor($max_page) && ($trie - 2) > 0)
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie='.($trie - 2).'">'.($trie - 2).'</a>';
				if (($trie - 1) <= floor($max_page) && ($trie - 1) > 0)
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie='.($trie - 1).'">'.($trie - 1).'</a>';
				echo '<a style="background-color: #C3D825;padding: 4px 10px 6px;color: #FFF;">'.$trie.'</a>';
				if (($trie + 1) <= floor($max_page))
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie='.($trie + 1).'">'.($trie + 1).'</a>';
				if (($trie + 2) <= floor($max_page))
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie='.($trie + 2).'">'.($trie + 2).'</a>';
				if (($trie + 3) <= floor($max_page))
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie='.($trie + 3).'">'.($trie + 3).'</a>';
				if ($trie != floor($max_page))
					echo '<a style="padding: 4px 10px 6px;color: #000000;" href="index.php?page=gallery&trie='.floor($max_page).'">»</a>';
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
