<?php
require '../phpScripts/db.php';
require '../Settings/config.php';
if (!R::testConnection())
    exit ('Нет соединения с базой данных');


$info = '';
$data = array();
$i = 0;
$author = R::findAll('author');
foreach ($author as $item)
{
    $data[$i] = " <tr onclick=\"GetId(this)\">
                <td>$item->id</td>
                <td>$item->name</td>
                <td>$item->publisher_book</td>
            </tr>";

    $i++;
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $activeElem = R::load('books', (int)$_COOKIE['id']);
    R::trash($activeElem);


    $info = "<div class=\"alert alert-success alert-dismissible\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Success!</strong> Element was delete.
</div>";
    $_COOKIE['id'] = '';

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
    <script src="../js/GetClickedElem.js"></script>
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

<!-- Modal begin -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-warning">Do you really want to delete it?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                <button type="button" class="btn btn-primary">YES</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->

<div class="container" style="margin-top: 80px">
    <?php echo $info; $info = '';?>
    <body>

    <h2 class="text-center text-light ">Author</h2>
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

    <hr>
    <div class="form-row">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <button type="submit" class="col-lg-12 btn btn-danger">Delete element</button>
        </form>
    </div>

    </body>


</div>


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
