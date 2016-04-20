<?php
	function Page($content)
	{
		$content = htmlentities(htmlspecialchars($content));
		include ((file_exists("pages/" . $content . ".php")) ? "pages/" . $content . ".php" : "pages/error.php");
	}
?>
