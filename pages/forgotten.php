<div class="middle">
	<h1 style="margin-top: 30px;">Mot de passe oublié</h1>
	<?php
		if (isset($_POST["forgotten"]))
		{
			if (!empty($_POST["email"]))
			{
				$email = secure($_POST["email"], 1);
				Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'"');
				if (Database::Get_Rows(NULL))
				{
					$hash = randomKey(255);
					print_message("Un email de réinitialisation de mot de passe vous a été envoyé !", "success");
					Database::Query('INSERT INTO reset(email,hash) VALUES("'.$email.'", "'.$hash.'")');
					Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'"');
					Database::Fetch_Assoc(NULL);
					SendEmail($email, Database::$assoc["username"], "reset", $hash);
				}
				else
				{
					print_message("Cet email n'existe pas !", "error");
					redirect("forgotten", 5);
				}
			}
			else
			{
				print_message("Un champ est manquant !", "error");
				redirect("forgotten", 5);
			}
		}
		else
		{
			echo '<form method="post">
				Adresse email<br/>
				<input type="text" size="35" name="email"/> </br><br/>
				<input type="submit" name="forgotten" value="Valider"/>
				</form>';
		}
	?>
</div>