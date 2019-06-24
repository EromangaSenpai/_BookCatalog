<?php
require 'phpScripts/db.php';
require 'Settings/config.php';
if (!R::testConnection())
    exit ('Нет соединения с базой данных');


$info = '';
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_FILES && $_FILES['filename']['error'] == UPLOAD_ERR_OK && $_FILES['filename']['size'] <= '20000000')
    {
        $name = $_FILES['filename']['name'];
        $uniq = uniqid();
        $upload_dir = getcwd()."\img".'\\'.$uniq.'_'.$name;

        move_uploaded_file($_FILES['filename']['tmp_name'], $upload_dir);

        $goods = R::dispense('goods');
        $goods->image_path = 'img'.'/'.$uniq.'_'.$name;
        $goods->description = $_POST['description'];
        $goods->productname = $_POST['product'];
        $goods->firmname = $_POST['firm'];
        $goods->color = $_POST['color'];
        $goods->price = $_POST['price'];
        $goods->amount = $_POST['amount'];
        $goods->type = $_POST['type'];
        R::store($goods);

       $info = "<div class=\"alert alert-success alert-dismissible\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Success!</strong> Product was successfully added to store.
</div>";

    }
    else
    {
        $info = "<div class=\"alert alert-danger alert-dismissible\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Error!</strong> An error was occurred please try again.
</div>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <title>Admin Page</title>
    <style>
        .background3{
            background: #780206;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to top, #061161, #780206);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to top, #061161, #780206); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        hr {
            /* установим цвет и высоту */
            border:1px solid rgb(211, 211, 211);
            border-bottom-width: 0;
        }
        #navbar {
            background-color: #333;
            opacity: 0.6;
            position: fixed;
            top: 0;
            width: 100%;
            display: block;
            transition: top 0.3s;
        }

        #navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 15px;
            text-decoration: none;
            font-size: 17px;
        }

        #navbar a:hover {

        }
        toright{
            margin-left: 40px;
        }

    </style>
</head>
<body class="background3" style="height: 140vh">

<div id="navbar">
    <a href="#" class="text-light">Create</a>
    <a href="UpdatePages/Choose_Publish.php" class="text-light">Update</a>
    <a href="DeleteProductPage.php" class="text-light">Delete</a>
    <a style="float: right" class="text-light" href="MainPage.php">Go back</a>
</div>

<div class="container" style="margin-top: 80px">
<?php echo $info; $info = '';?>
    <h2 class="text-center text-light">Add product</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <br>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="filename" accept="image/*" required>
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <hr>

        <div class="row form-group">

            <div class="col-sm-6">
                <label for="Title" class="text-light">Book Title:</label>
                <input value="" type="text" maxlength="40" name="Title" class="form-control" id="product" placeholder="Book title" required>
            </div>
            <div class="col-sm-6">
                <label for="Author" class="text-light">Author:</label>
                <input value="" type="text" maxlength="60" name="Author" class="form-control" id="firm" placeholder="Author name" required>
            </div>

        </div>

        <div class="row form-group">

            <div class="col-sm-6">
                <label for="publishName" class="text-light">Publisher Name:</label>
                <input value="" type="text" maxlength="50" name="publishName" class="form-control" id="publishName" placeholder="Publisher name" required>
            </div>
            <div class="col-sm-6">
                <label for="firm" class="text-light">Publishing Address:</label>
                <input value="" type="text" maxlength="60" name="firm" class="form-control" id="publishAddress" placeholder="Publishing address" required>
            </div>

        </div>

        <div class="row form-group">

            <div class="col-sm-6">
                <label for="tel" class="text-light">Publisher's phone:</label>
                <input value="" type="tel" name="tel" class="form-control" id="product" placeholder="Publisher's phone" required>
            </div>
            <div class="col-sm-6">
                <label for="date" class="text-light">Date Of Publishing:</label>
                <input value="" type="date" name="date" class="form-control" id="date" placeholder="Date of publishing" required>
            </div>

        </div>


        <hr>
        <div class="form-row justify-content-around form-group">
            <button type="reset" class="col-3 btn btn-danger" name="reset">Reset</button>
            <button type="submit" class="col-3 btn btn-success" name="add">Add</button>
        </div>

    </form>


</div>

<script>
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("navbar").style.top = "0";
        } else {
            document.getElementById("navbar").style.top = "-55px";
        }
        prevScrollpos = currentScrollPos;
    }
</script>

</body>
</html>
