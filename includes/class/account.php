<?php
class Account
{
	public static function Register()
	{
		if (!empty($_POST["email"]) && !empty($_POST["user"]) && !empty($_POST["password"]) && !empty($_POST["password_conf"]))
		{
			$email = secure($_POST["email"], 1);
			$user = secure($_POST["user"], 1);
			$password = secure($_POST["password"], 1);
			$password_conf = secure($_POST["password_conf"], 1);
			if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				if (strlen($user) >= 6)
				{
					if ($password == $password_conf)
					{
						if (strlen($password) >= 6)
						{
							if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $user))
							{
								if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))
								{
									Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'"');
									if (!Database::Get_Rows(NULL))
									{
										Database::Query('SELECT * FROM accounts WHERE username = "'.$user.'"');										
										if (!Database::Get_Rows(NULL))
										{
											Database::Query('INSERT INTO accounts(email,username,password,active) VALUES("'.$email.'", "'.$user.'", "'.hash('whirlpool', $password).'", "0")');
											print_message("Votre compte a été crée avec succès, bienvenue sur <i>Camagru</i> !<br/>Pour utiliser votre compte, merci de cliquer sur le lien que nous venons de vous envoyer par e-mail.<br/> <small>(Vérifiez vos courriers indésirables !)</small>", "success");
											SendEmail($email, $user, "validation", NULL);
										}
										else
										{
											print_message("Ce nom d'utilisateur est déjà pris, merci d'en choisir un autre !", "error");
											redirect("register", 4);
										}
									}
									else
									{
										print_message("Cette adresse e-mail est déjà prise, merci d'en choisir une autre !", "error");
										redirect("register", 4);
									}
								}
								else
								{
									print_message("Votre mot de passe ne doit pas contenir de caractère spéciaux !", "error");
									redirect("register", 4);
								}
							}
							else
							{
								print_message("Votre nom d'utilisateur ne doit pas contenir de caractère spéciaux !", "error");
								redirect("register", 4);
							}
						}
						else
						{
							print_message("Votre mot de passe doit faire au minimum 6 caractère !", "error");
							redirect("register", 4);
						}
					}
					else
					{
						print_message("Les deux mot de passe ne sont pas identique !", "error");
						redirect("register", 4);
					}
				}
				else
				{
					print_message("Votre nom d'utilisateur doit faire au minimum 6 caractère !", "error");
					redirect("register", 4);
				}
			}
			else
			{
				print_message("Le format de votre email est incorrect !", "error");
				redirect("register", 4);
			}
		}
		else
		{
			print_message("Un champ est manquant !", "error");
			redirect("register", 4);
		}
	}

	public static function Login()
	{
		if (!empty($_POST["email"]) && !empty($_POST["password"]))
		{
			$email = secure($_POST["email"], 1);
			$password = secure($_POST["password"], 1);
			Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'" AND password = "'.hash('whirlpool', $password).'"');
			if (Database::Get_Rows(NULL))
			{
				Database::Fetch_Assoc(NULL);
				if (intval(Database::$assoc["active"]) == 1)
				{
					$_SESSION["email"] = $email;
					print_message("Vous vous êtes connecté avec succès !", "success");
					redirect("gallery", 5);
				}
				else
				{
					print_message('Votre compte n\'a pas encore été validé.', "error");
					print_message('<br/> Un nouvel email vien de vous être envoyer !', "success");
					SendEmail($email, Database::$assoc["username"], "validation", NULL);
				}
			}
			else
			{
				print_message("Email ou mot de passe incorrect !", "error");
				redirect("login", 4);
			}		
		}
		else
		{
			print_message("Un champ est manquant !", "error");
			redirect("login", 4);
		}
	}

	public static function ResetPassword()
	{
		if (!empty($_POST["password"]) && !empty($_POST["password_conf"]) && !empty($_POST["email"]))
		{
			$password = secure($_POST["password"], 1);
			$password_conf = secure($_POST["password_conf"], 1);
			if ($password == $password_conf)
			{
				if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))
				{
					if (strlen($password) >= 6)
					{
						$email = secure(base64_decode($_POST["email"]), 1);
						Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'"');
						if (Database::Get_Rows(NULL))
						{
							Database::Query('DELETE FROM reset WHERE email = "'.$email.'"');
							Database::Query('UPDATE accounts SET password = "'.hash('whirlpool', $password).'" WHERE email = "'.$email.'"');
							print_message("Votre mot de passe a été mis a jour avec succès !", "success");
						}
						else
							print_message("Une erreur est survenue.", "error");
					}
					else
						print_message("Votre nouveau mot de passe doit faire au minimum 6 caractère !", "error");
				}
				else
					print_message("Votre nouveau mot de passe ne doit pas contenir de caractère spéciaux !", "error");
			}
			else
				print_message("Les deux nouveaux mot de passe ne correspondent pas !", "error");
		}
		else
			print_message("Un champ est manquant !", "error");
	}
}
?>