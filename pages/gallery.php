<?php
		Database::Query('SELECT * FROM gallery ORDER BY date_creation DESC');
		if (Database::Get_Rows(NULL))
		{
			echo '<div class="middle_galerie">';
			while (Database::Fetch_Assoc(NULL))
			{
				 echo '<div id="galerie">
						<a href=""><img class="img_gal" src="uploads/bg.jpg" /></a>
						<form style="text-align: right; margin-right: 10px; margin-top: 6px;">
						<input type="button" value="x"></input>
						<a href="" style="text-decoration: none;"><font style="margin-right: 570px; margin-top: -20px; text-decoration: none; display: inline-block;">&#128077 '.Database::$assoc["like"].'</font></a>
						<a href="" style="text-decoration: none;"><font style="margin-right: 515px; margin-top: -26px; display: inline-block;">&#128078 '.Database::$assoc["dontlike"].'</font></a>
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
?>