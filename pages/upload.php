<?php
if (isset($_POST['save']))
{
    if (!empty($_FILES["background_camera"]["name"]))
    {
       if (strstr($_FILES["background_camera"]["type"], "image"))
       {
            if ($_FILES["background_camera"]["size"] <= 1655000)
            {
                echo "OK";
            }
            else
            {
                // img trop grande
            }
       }
    }
    else
    {
        echo $_POST["background_image"];
    }
    /*$background = $_POST['background'];
    $texture = $_POST['texture'];
    $texture = explode(";", $texture);
    foreach($texture as $t)
    {
        $split = explode(",", $t);
        echo 'ID ['.$split[0].'], Y ['.$split[1].'] X ['.$split[2].']';
        echo "</br>";
    }*/
}
    if (!empty($_SESSION["email"]))
    { 
     echo '<div class="left">
                    <video id="video" width="640" height="480" autoplay ></video>
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
                    <div id="historique">
                        <div id="photo">
                            <img src="img/imgres.jpg" height="190" width="200"/>
                        </div>   
                        <div id="photo">
                            <img src="img/imgres.jpg" height="190" width="200"/>
                        </div>
                        <div id="photo">
                            <img src="img/imgres.jpg" height="190" width="200"/>
                        </div>
                        <div id="photo">
                            <img src="img/imgres.jpg" height="190" width="200"/>
                        </div>                 
                    </div>
                </div>';
        }
        else
        {
            echo '<div class="middle">
                <h1 style="margin-top: 400px;color:#BD2727;">Erreur 403 - Vous devez être connecter pour accéder a cette page</h1>
            </div>';
        }
?>