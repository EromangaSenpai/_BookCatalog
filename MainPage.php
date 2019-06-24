<?php
require 'phpScripts/ProductInfo.php';
require 'Settings/config.php';
session_start();

$productInfo = new ProductInfo;

$info = $productInfo->info;
$books = $productInfo->books;
$booksArr = $productInfo->booksArray;
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
        <div class="row" id="catalog">
            <?php for($i = 0; $i < count($booksArr); $i++): echo $booksArr[$i]; endfor;?>
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
