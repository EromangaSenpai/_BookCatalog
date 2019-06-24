<?php
require '../phpScripts/db.php';
require '../Settings/config.php';
if(!isset($_COOKIE['id']))
    header('Location: ../UpdatePages/Choose_Book.php');

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

$info = '';
$book = R::findOne('books','id = ?', array($_COOKIE['id']));
$author = R::findAll('author');
$options = array();
$prop = "name";
$i = 0;
foreach ($author as $item)
{
    $options[$i] = "<option value=\"$item[$prop]\">$item[$prop]</option>";
    $i++;
}

$past_title = $book->name;
$past_author_name = $book->publisher_book;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $book->title = $_POST['Title'];
    $book->author_name = $_POST['author_name'];
    if ($_FILES) {
        $uniq = uniqid();
        foreach ($_FILES["filename"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["filename"]["tmp_name"][$key];
                $name = $_FILES["filename"]["name"][$key];
                $upload_dir = getcwd() . "\img" . '\\' . $uniq . '_' . $name;
                $books->img .= "\img" . '\\' . $uniq . '_' . $name . '|';
                move_uploaded_file($tmp_name, $upload_dir);
            }
        }
    }
    R::store($book);

    unset($past_name);
    unset($past_type);
    unset($past_img);

    setcookie('id', $_COOKIE['id'], time()-360000, '/');

    $info = "<div class=\"alert alert-success alert-dismissible\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Success!</strong> Product was successfully updated at store.
</div>";

    header("Refresh:2; url=../MainPage.php");

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
    <link rel="stylesheet" href="../css/MyCreateNewAuthorStyle.css">
    <title>Update Publish Page</title>

</head>
<body class="background3" style="height: 140vh">

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">

    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Create
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="../CreatePages/CreateNewPublish.php">Publish</a>
                <a class="dropdown-item" href="../CreatePages/CreateNewAuthor.php">Author</a>
                <a class="dropdown-item" href="../CreatePages/CreateNewBook.php">Book</a>
                <a class="dropdown-item" href="../CreatePages/CreateNewHeading.php">Heading</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Update
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="Choose_Publish.php">Publish</a>
                <a class="dropdown-item" href="Choose_Author.php">Author</a>
                <a class="dropdown-item" href="Choose_Book.php">Book</a>
                <a class="dropdown-item" href="Choose_Heading.php">Heading</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Delete
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="../DeletePages/Choose_Publish.php">Publish</a>
                <a class="dropdown-item" href="../DeletePages/Choose_Author.php">Author</a>
                <a class="dropdown-item" href="../DeletePages/Choose_Book.php">Book</a>
                <a class="dropdown-item" href="../DeletePages/Choose_Heading.php">Heading</a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="../MainPage.php">Go Back</a>
        </li>
    </ul>

</nav>

<div class="container" style="margin-top: 80px">
    <?php echo $info; $info = '';?>
    <h2 class="text-center text-light">Update book</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <br>
        <div class="custom-file">
            <input title="Choose Image" type="file" class="custom-file-input" id="customFile" name="filename[]" accept="image/*" multiple>
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
        <hr>

        <div class="row form-group">

            <div class="col-sm-6">
                <label for="Title" class="text-light">Book Title:</label>
                <input value="<?php echo @$past_title ?>" type="text" maxlength="60" name="Title" class="form-control" id="Title" placeholder="Book title" required>
            </div>

            <div class="col-sm-6">
                <label for="author_name" class="text-light">Author :</label>
                <select id="author_name" name="author_name" class="custom-select m-0">
                    <?php for ($i = 0; $i < count($options); $i++): echo $options[$i]; endfor; ?>
                </select>
            </div>

        </div>


        <hr>
        <div class="form-row justify-content-around form-group">
            <button type="reset" class="col-3 btn btn-danger" name="reset">Reset</button>
            <button type="submit" class="col-3 btn btn-success" name="add">Add</button>
        </div>

    </form>


</div>
<!-- Hide navbar using scrolldown -->
<script>
    function deleteCookie(elem) {
        var date = new Date(0);
        document.cookie = "id=" + elem.cells[0].innerText + ";" + "path=/; expires=" + date.toUTCString();
    }

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
