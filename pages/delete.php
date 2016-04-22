<?php
	if (isset($_GET["id"]))
	{
		$id = secure($_GET["id"], 0);
		if (!empty($_SESSION["email"]))
		{
			Database::Query('SELECT * FROM gallery WHERE id = "'.$id.'"');
			if (Database::Get_Rows(NULL))
			{
				Database::Fetch_Assoc(NULL);
				if (Database::$assoc["author"] == $_SESSION["email"])
					Database::Query('DELETE FROM gallery WHERE id = "'.$id.'"');
				redirect('upload', 0);
			}
			else
				redirect("upload", 0);
		}
		else
			redirect("login", 0);
	}
?>