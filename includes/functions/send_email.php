<?php
function SendEmail($destination, $user, $action, $hash)
{
	switch ($action)
	{
		case "validation":
			$i = 0;
			$email = base64_encode($destination);
			while ($i <= 4)
			{
				$email = base64_encode($email);
				$i++;
			}
			$path = realpath(dirname(__FILE__));
			$path = explode("MyWebSite/", $path);
			$str = NULL;
			$i = 0;
			while ($path[1][$i] != NULL && ($path[1][$i] != 'i' && $path[1][$i + 1] != 'n' && $path[1][$i + 2] != 'c'))
				$str = ''.$str.''.$path[1][$i++].'';
			$content = '<html>
					Bonjour <i>'.$user.'</i>, 
					<br/>Merci de cliquer sur <a href="http://localhost:8080/'.$str.'?page=validate&email='.base64_encode($email).'">ce lien</a> pour valider votre compte !
					<br/>
					A bientot sur <i>Camagru<i> !
					</html>';

			$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
			$header .= "Reply-to: \"Camagru\" <camagru@42.fr>". "\r\n";
			$header .= "Content-Type: text/html; charset=\"iso-8859-1\"" . "\r\n";
			$header .= 'MIME-Version: 1.0' . "\r\n";
			mail($destination, "Camagru - Activation de votre compte", $content, $header);
		break ;

		case "reset":
			$i = 0;
			$email = base64_encode($destination);
			while ($i <= 4)
			{
				$email = base64_encode($email);
				$i++;
			}
			$path = realpath(dirname(__FILE__));
			$path = explode("MyWebSite/", $path);
			$str = NULL;
			$i = 0;
			while ($path[1][$i] != NULL && ($path[1][$i] != 'i' && $path[1][$i + 1] != 'n' && $path[1][$i + 2] != 'c'))
				$str = ''.$str.''.$path[1][$i++].'';
			$content = '<html>
					Bonjour <i>'.$user.'</i>, 
					<br/>Merci de cliquer sur <a href="http://localhost:8080/'.$str.'?page=reset&hash='.$hash.'">ce lien</a> pour reinitialiser votre mot de passe !
					<br/>
					A bientot sur <i>Camagru<i> !
					</html>';

			$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
			$header .= "Reply-to: \"Camagru\" <camagru@42.fr>". "\r\n";
			$header .= "Content-Type: text/html; charset=\"iso-8859-1\"" . "\r\n";
			$header .= 'MIME-Version: 1.0' . "\r\n";
			mail($destination, "Camagru - Reinitialisation de votre mot de passe", $content, $header);
		break ;

		case "new_comment":
			$i = 0;
			$email = base64_encode($destination);
			while ($i <= 4)
			{
				$email = base64_encode($email);
				$i++;
			}
			$path = realpath(dirname(__FILE__));
			$path = explode("MyWebSite/", $path);
			$str = NULL;
			$i = 0;
			while ($path[1][$i] != NULL && ($path[1][$i] != 'i' && $path[1][$i + 1] != 'n' && $path[1][$i + 2] != 'c'))
				$str = ''.$str.''.$path[1][$i++].'';
			$content = '<html>
					Bonjour <i>'.$user.'</i>, 
					<br/>Vous avez recu un nouveau commentaire sur votre image !
					<br/>
					A bientot sur <i>Camagru<i> !
					</html>';

			$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
			$header .= "Reply-to: \"Camagru\" <camagru@42.fr>". "\r\n";
			$header .= "Content-Type: text/html; charset=\"iso-8859-1\"" . "\r\n";
			$header .= 'MIME-Version: 1.0' . "\r\n";
			mail($destination, "Camagru - Nouveau commentaire sur votre image", $content, $header);
		break ;
	}
}
?>