<?php
function ResizeImage($target, $newcopy, $w, $h, $ext)
{
    list($w_orig, $h_orig) = getimagesize($target);
    $ext = strtolower($ext);
    if ($ext == "gif")
        $img = imagecreatefromgif($target);
    else if($ext =="png")
         $img = imagecreatefrompng($target);
    else
         $img = imagecreatefromjpeg($target);
    $tci = imagecreatetruecolor($w, $h);
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
}
?>