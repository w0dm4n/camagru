<?php
	echo '<div class="middle">
	<h1 style="margin-top: 30px;">Réinitialisation de mot de passe</h1>';
		if (isset($_GET["hash"]))
		{
			$hash = secure($_GET["hash"], 1);
			Database::Query('SELECT * FROM reset WHERE hash = "'.$hash.'"');
			if (Database::Get_Rows(NULL))
			{
				Database::Fetch_Assoc(NULL);
				$email = Database::$assoc["email"];
				Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'"');
				if (Database::Get_Rows(NULL))
				{
					if (isset($_POST["reset"]))
						Account::ResetPassword();
					else
					{
						Database::Fetch_Assoc(NULL);
						echo 'Bonjour <i> '.Database::$assoc["username"].', suis le formulaire ci-dessous pour réinitialiser ton mot de passe
						<form method="post">
							Nouveau mot de passe <br/>
							<input type="password" size="35" name="password"/> </br><br/>
							Confirmation nouveau mot de passe <br/>
							<input type="password" size="35" name="password_conf"/> </br><br/>
							<input type="hidden" name="email" value="'.base64_encode($email).'"/> 
							<input type="submit" name="reset" value="Réinitaliser"/>
						</form>';
					}
				}
				else
					print_message("Une erreur est survenue.", "error");
			}
			else
				print_message("Une erreur est survenue.", "error");
		}
		else
			print_message("Une erreur est survenue.", "error");

	echo '</div>';
?>