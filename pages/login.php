<div class="middle">
	<h1 style="margin-top: 30px;">Connexion</h1>
	<?php
		if (empty($_SESSION["email"]))
		{
			if (isset($_POST["login"]))
				Account::Login();
			else
			{
				echo '<form method="post">
						Adresse e-mail <br/>
					<input type="text" size="35" name="email"/> </br><br/>
					Mot de passe <br/>
					<input type="password" size="35" name="password"/> </br><br/>
					<input type="submit" name="login" value="Connexion"/>
					 </form><hr><a href="?page=forgotten">Mot de passe oublié ?</a>';
			}
		}
		else
		{
			print_message("Tu n'as rien a faire ici @__________@", "error");
			redirect("gallery", 0);
		}
	?>
</div>