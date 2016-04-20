<?php
	session_unset();
	session_destroy();
	redirect("gallery", 0);
?>
