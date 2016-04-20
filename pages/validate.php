<?php
echo '<div class="middle">
	<h1 style="margin-top: 30px;">Validation de compte</h1>';
	if (isset($_GET["email"]))
	{
		$email = base64_decode($_GET["email"]);
		$i = 0;
		while ($i <= 5)
		{
			$email = base64_decode($email);
			$i++;
		}
		$email = secure($email, 1);
		Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'"');
		if (Database::Get_Rows(NULL))
		{
			Database::Fetch_Assoc(NULL);
			if (intval(Database::$assoc["active"]) == 0)
			{
				Database::Query('UPDATE accounts SET active = "1" WHERE email = "'.$email.'"');
				print_message("Votre compte a été valider, vous pouvez désormais vous connecter !", "success");
			}
			else
				print_message("Votre compte a déjà été activé !", "error");
		}
		else
			print_message("Cet email n'existe pas :(", "error");
	}
	else
		print_message("Une erreur est survenue.", "error");
echo '</div>';
?>