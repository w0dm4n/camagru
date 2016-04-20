<div class="middle">
	<h1 style="margin-top: 30px;">Inscription</h1>
	<?php
	if (isset($_POST["register"]))
		Account::Register();
	else
	{
		echo '<form method="post">
			<i>
			Adresse e-mail <br/>
			<input type="text" size="35" name="email"/> </br><br/>
			Nom d\'utilisateur <br/>
			<input type="text" size="35" name="user"/> </br><br/>
			Mot de passe <br/>
			<input type="password" size="35" name="password"/> </br><br/>
			Confirmation mot de passe <br/>
			<input type="password" size="35" name="password_conf"/> </br><br/>
			<input type="submit" name="register" value="S\'inscrire"/>
			</i>
		</form>';
	}
	?>
</div>