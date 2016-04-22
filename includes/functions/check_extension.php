<?php
function check_extension($ext)
{
	$array = array('png', 'jpg', 'jpeg', 'bmp', 'gif');
	return ((in_array($ext, $array)) ? true : false);
}
?>