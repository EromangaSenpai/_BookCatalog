<?php
require '../phpScripts/db.php';
require '../Settings/config.php';
if (!R::testConnection())
    exit ('Нет соединения с базой данных');


$info = '';
$data = array();
$i = 0;
$book = R::findAll('books');
foreach ($book as $item)
{
    $data[$i] = " <tr onclick=\"GetId(this)\">
                <td>$item->id</td>
                <td>$item->title</td>
                <td>$item->author_name</td>
            </tr>";

    $i++;
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
    <title>Admin Page</title>

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
    <body>

    <h2 class="text-center text-light ">Books</h2>
    <br>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <table class="table table-dark table-hover" style="cursor: pointer">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Publisher book</th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php foreach ($data as $item): echo $item; endforeach; ?>
        </tbody>
    </table>


    </body>


</div>

<script>
    function GetId(elem) {
        var date = new Date(new Date().getTime() + 30 * 1000);
        document.cookie = "id=" + elem.cells[0].innerText + ";" + "path=/; expires=" + date.toUTCString();
        document.location = 'UpdateBook.php';
    }
</script>

<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>


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
