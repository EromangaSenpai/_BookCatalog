<?php
require 'phpScripts/db.php';
require_once 'phpScripts/HierarchicalFunc.php';
require 'Settings/config.php';
session_start();

$elem = R::findOne( 'books', ' id = ?', [$_SESSION['id']]);
$image_arr = explode('|', $elem['img']);
$slots = array();
for ($i = 0; $i < count($image_arr) - 1; $i++)
{
    $slots[$i] = " <div class=\"col-lg-3 mb-4 div-column-style\">
                    <a href=\"$image_arr[$i]\">
                        <img src=\"$image_arr[$i]\" class=\"img-thumbnail zoom\" style=\"background-color: grey; width: 304px; height:236px\" alt=\"Image\" width=\"304px\" height=\"236px\">
                        <div class=\"caption text-primary\">
                             </a>
                        </div>
                </div>";
}

$result = get_cat($elem['title']);

?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/myStyles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <style>
        hr {
            border:1px solid rgb(211, 211, 211);
            border-bottom-width: 0;
        }
    </style>
    <title>Main Page</title>
<body class="background">


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <button class="btn btn-outline-danger ml-2" onclick="document.location = 'CreatePages/CreateNewPublish.php'">CRUD Panel</button>
</nav>

<br>

<div class="container" id="maindiv">
    <h2 class="text-center text-light">Image Gallery</h2>
    <div class="row" id="catalog">
        <?php foreach ($slots as $item): echo $item; endforeach;?>
    </div>
    <h2 class="text-center text-light">Book Hierarchic</h2>
    <div class="row" id="catalog">
        <?php if(!empty($result))
        {
            view_cat($result);
        }
        else
            echo "No Hierarchic found";
        ?>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function(){
        $("#menu").on("click","a", function (event) {
            event.preventDefault();
            var id  = $(this).attr('href'),
                top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 1500);
        });
    });
</script>
</body>
