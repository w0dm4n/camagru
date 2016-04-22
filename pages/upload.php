<?php
if (isset($_POST['save']))
{
    if (!empty($_FILES["background_camera"]["name"]))
    {
       if (strstr($_FILES["background_camera"]["type"], "image"))
       {
            if ($_FILES["background_camera"]["size"] <= 1655000)
            {
                $extension = explode('.', $_FILES["background_camera"]["name"]);
                $extension = strtolower($extension[1]);
                if (check_extension($extension))
                {
                    $path = 'uploads/' . randomKey(100) . "." . $extension;
                    move_uploaded_file($_FILES['background_camera']['tmp_name'], $path);
                    ResizeImage($path, $path, 640, 480, $extension);
                    if (!empty($_POST["texture"]))
                    {
                        $texture = $_POST['texture'];
                        $texture = explode(";", $texture);
                        if ($extension == "gif")
                            $im = imagecreatefromgif($path);
                        else if($extension == "png")
                             $im = imagecreatefrompng($path);
                        else
                             $im = imagecreatefromjpeg($path);
                        foreach($texture as $t)
                        {
                            $split = explode(",", $t);
                            Database::Query('SELECT * FROM images WHERE id = "'.$split[0].'"');
                            Database::Fetch_Assoc(NULL);
                            file_put_contents('uploads/tmp.png', base64_decode(Database::$assoc['image_base64']));
                            imagecopy($im, imagecreatefrompng('uploads/tmp.png'), $split[2] - 50, $split[1] - 50, 0, 0, imagesx(imagecreatefrompng('uploads/tmp.png')), imagesy(imagecreatefrompng('uploads/tmp.png')));
                        }
                        imagepng($im, $path, 0);
                        unlink("uploads/tmp.png");
                        Database::Query('INSERT INTO gallery(image_path,author,like_img,dontlike_img,date_creation) VALUES("'.$path.'", "'.$_SESSION["email"].'", "0", "0", "'.date('Y-m-d H:i:s').'") ');
                        print_message("Votre image a bien été sauvegarder !", "success");
                    }
                    else
                    {
                        Database::Query('INSERT INTO gallery(image_path,author,like_img,dontlike_img,date_creation) VALUES("'.$path.'", "'.$_SESSION["email"].'", "0", "0", "'.date('Y-m-d H:i:s').'") ');
                        print_message("Votre image a bien été sauvegarder !", "success");
                    }
                }
                else
                    print_message("Une erreur est survenue, merci de réessayer avec une autre image", "error");
            }
            else
                print_message("Votre image est trop lourde, merci d'en upload une de moin de 1.5 Mo", "error");
       }
       else
            print_message("Une erreur est survenue, merci de réessayer avec une autre image", "error");
    }
    else
    {
        $path = 'uploads/' . randomKey(100) . "." . "png";
        file_put_contents($path, base64_decode($_POST["background_image"]));
        $background = imagecreatefromstring(base64_decode($_POST["background_image"]));
        ResizeImage($path, $path, 640, 480, "png");
        if (!empty($_POST["texture"]))
        {
            $texture = $_POST['texture'];
            $texture = explode(";", $texture);
            $im = imagecreatefromjpeg($path);
            foreach($texture as $t)
            {
                $split = explode(",", $t);
                Database::Query('SELECT * FROM images WHERE id = "'.$split[0].'"');
                Database::Fetch_Assoc(NULL);
                file_put_contents('uploads/tmp.png', base64_decode(Database::$assoc['image_base64']));
                imagecopy($im, imagecreatefrompng('uploads/tmp.png'), $split[2] - 50, $split[1] - 50, 0, 0, imagesx(imagecreatefrompng('uploads/tmp.png')), imagesy(imagecreatefrompng('uploads/tmp.png')));
                echo $split[1] . ":" . $split[2] . "<br/>";
            }
             imagepng($im, $path, 0);
             unlink("uploads/tmp.png");
             Database::Query('INSERT INTO gallery(image_path,author,like_img,dontlike_img,date_creation) VALUES("'.$path.'", "'.$_SESSION["email"].'", "0", "0", "'.date('Y-m-d H:i:s').'") ');
             print_message("Votre image a bien été sauvegarder !", "success");
            }
            else
            {
                  Database::Query('INSERT INTO gallery(image_path,author,like_img,dontlike_img,date_creation) VALUES("'.$path.'", "'.$_SESSION["email"].'", "0", "0", "'.date('Y-m-d H:i:s').'") ');
                  print_message("Votre image a bien été sauvegarder !", "success");
            }
        
    }
}
    if (!empty($_SESSION["email"]))
    { 
     echo '<div class="left">
                    <!--<video id="video" width="640" height="480" autoplay ></video>-->
                    <button id="snap"><h1 style="text-align: center; color: black;">SMILE !</h1></button><br/><br/>
                    <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="MAX_FILE_SIZE" value="1655000" /> 
                            <input id="import" type="file" accept="image/*" name="background_camera" onchange="loadFile(event)"/> <br/>
                            <input id="background" name="background_image" type="hidden" value="">
                            <input id="texture" name="texture" type="hidden" value="">
                            <input type="submit" style="text-align: center; color: black;" name="save" id="snap" value="SAVE !">
                    </form>
                </div>
                <div class="useless">
                    <img value="1" src="img/right_360.png">
                    <img value="2" src="img/down_360.png">
                </div>
                <div class="right">
                    <div class="picture">
                       <canvas onmousemove="draw_canvas(event)" id="canvas" width="640" height="480"></canvas>
                    </div>
                    <div class="images" id="img_zone" >';
                    Database::Query('SELECT * FROM images');
                    if (Database::Get_Rows(NULL))
                    {
                        while (Database::Fetch_Assoc(NULL))
                        {
                            $data = getimagesizefromstring(base64_decode(Database::$assoc['image_base64']));
                            echo '<div id="coucou">
                            <img id="object_'.Database::$assoc['id'].'" src="data:'.$data['mime'].';base64,'.Database::$assoc['image_base64'].'" height="100" width="100"/>
                                </div>';
                        }
                   }
                   echo '</div>
                    <div id="historique">';
                    Database::Query('SELECT * FROM gallery WHERE author = "'.$_SESSION['email'].'" ORDER BY date_creation DESC');
                    if (Database::Get_Rows(NULL))
                    {
                        while (Database::Fetch_Assoc(NULL))
                        {
                            echo '<div id="photo">
                                     <img src="'.Database::$assoc['image_path'].'" height="190" width="200"/>
                                  </div>';
                        }
                    }               
                    echo '</div>
                </div>';
        }
        else
        {
            echo '<div class="middle">
                <h1 style="margin-top: 400px;color:#BD2727;">Erreur 403 - Vous devez être connecter pour accéder a cette page</h1>
            </div>';
        }
?>