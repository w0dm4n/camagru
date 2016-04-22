<?php
	if (isset($_GET["id"]))
	{
		$id = secure($_GET["id"], 0);
		if (isset($_POST["send_comment"]))
		{
			echo '<div class="middle">
				<h1 style="margin-top: 30px;">Ajouter un commentaire</h1>';
				if (!empty($_SESSION['email']))
				{
					if (!empty($_POST["content"]))
					{
						$content = secure($_POST["content"], 1);
						$get_user = Database::Query('SELECT * FROM accounts WHERE email = "'.$_SESSION["email"].'"');
						$assoc = Database::Fetch_Assoc($get_user);
						Database::Query('INSERT INTO comments(content,image,author,date_post) VALUES("'.$content.'", "'.$id.'", "'.$assoc["username"].'", "'.date('Y-m-d H:i:s').'")');
						print_message("Votre commentaire a été posté !", "success");
						Database::Query('SELECT * FROM gallery WHERE id = "'.$id.'"');
						Database::Fetch_Assoc(NULL);
						Database::Query('SELECT * FROM accounts WHERE email = "'.Database::$assoc["author"].'"');
						Database::Fetch_Assoc(NULL);
						SendEmail(Database::$assoc["email"], Database::$assoc["username"], "new_comment", NULL);
					}	
					else
						print_message("Un champ est manquant", "error");
				}
				else
					print_message("Vous devez être connecté pour poster un commentaire !", "error");
			echo '</div>';
		}
		else
		{
			$query = Database::Query('SELECT * FROM gallery WHERE id = "'.$id.'"');
			if (Database::Get_Rows($query))
			{
				$assoc = Database::Fetch_Assoc($query);
				echo '<div class="middle">
						<div style="margin-top: 15px;">
							<img class="img_comment" src="'.$assoc["image_path"].'">
							<br/><a style="text-decoration:none;" href="?page=gallery&action=like&id='.$assoc["id"].'">&#128077</a> '.$assoc["like_img"].'&nbsp;&nbsp;
							<a style="text-decoration:none;" href="?page=gallery&action=dislike&id='.$assoc["id"].'">&#128078</a> '.$assoc["dontlike_img"].'';
							$get_user = Database::Query('SELECT * FROM accounts WHERE email = "'.$assoc["author"].'"');
							$assoc_user = Database::Fetch_Assoc($get_user);
							echo '&nbsp;&nbsp;&nbsp;Auteur: <i>'.$assoc_user['username'].'</i>';
						echo '</div>
						<div>
							<div style="margin-top: 15px;">
								<form method="post">
									<textarea style="text-decoration: none; resize:none;" cols="100" rows="3" name="content"></textarea><br/><br/>
									<input type="submit" name="send_comment" value="Ajoutez votre commentaire">
								</form>
						</div>';
							
					echo '<div class="comments">';

					Database::Query('SELECT * FROM comments WHERE image = "'.$id.'" ORDER BY date_post DESC');
					if (Database::Get_Rows(NULL))
					{
						while (Database::Fetch_Assoc(NULL))
						{
							echo '<div id="SAMERELAPERIPAPETICIENNE">
									'.Database::$assoc['author'].':
									<br/><br/>
									<div class="SAMERELAPERIPAPETICIENNE2">
										'.Database::$assoc['content'].'
									</div>
								</div><br/><br/><br/><br/><br/><br/>';
						}
					}
					echo '</div>
						</div>
						</div>';
			}
			else
				Redirect("gallery", 0);
		}
	}
?>