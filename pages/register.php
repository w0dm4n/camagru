<?php
$_SESSION['count'] = time();
?>
<div class="middle">
	<h1 style="margin-top: 30px;">Inscription</h1>
	<?php
	$flag = 5;
	if (isset($_POST["register"]))
	{
		$flag = $_POST["flag"];
		Account::Register();
	}
	else
	{
		if ($flag != 1)
			create_image();
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
			<div style="display:block;margin-bottom:20px;margin-top:20px;">
				<center><img src="./image'.$_SESSION['count'].'.png"></center>
			</div>
			<input type="hidden" name="flag" value="1"/></br>
			Captcha </br>
			<input type="text" size="35" name="robot"/></br><br/>
			<input type="submit" name="register" value="S\'inscrire"/>
			</i>
		</form>';
	}
	?>
</div>