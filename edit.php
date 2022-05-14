<?php

require_once("./connexion.php"
);
require_once("./class/book.php");
require_once("./checkfunction.php");
function init()
{
    global $title;
    global $author;
    global $description;
    global $dp;

    $title = "";
    $author = "";
    $description = "";
    $dp = "";
}
$book = new book();
if (isset($_GET['id'])) 
{
    $res = $book->getBookbyId($_GET['id']);
    $row = $res->fetch_assoc();
    $title =$row['title'];
    $author =$row['author'];
    $description = $row['description'];
    $dp = $row['date_of_publication'];
}


$success = null;
$error = null;
if (isset($_POST["edit"])) {
    // $book = new book();
    $title = $_POST["title"];
    $book->setTitle($title);
    $author = $_POST["author"];
    $book->setAuthor($author);
    $description = $_POST["description"];
    $book->setDescription($description);
    $dp = $_POST["dp"];
    $book->setDop($dp);

    if (count($book->errorMsg) == 0) {
        $fields = $book->getFields();
        if ($book->edit($book::editQuery,'ssssi',$_GET['id'],$fields) ) {
            $success = "Book updated with success";
           
        }
         else {
            $error = "Error of update";
        }
        
    }

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Librairie</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Librairie</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active " aria-current="page" href="#">Edit books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./list.php">List of books</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container shadow mt-3 w-50 py-4">
        <h3 class="text-center">Edit book</h3>
        <?php
        if (isset($error)) {
            echo "<div  class='alert alert-danger info'>", $error,"</div>";
        }
        if (isset($success)) {
            echo "<div class='alert alert-success info'>", $success, "</div>";
        }
        ?>
        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label text-center" for="title">Title</label>
                <input class="form-control" id="title" type="text" name="title" placeholder="Enter book title" value="<?=$title; ?>" />
            </div>
            <?php
            if (isset($book->errorMsg["title"])) {
                echo "<div class='alert alert-danger'>", $book->errorMsg['title'], "</div>";
            }
            ?>
            <div class="mb-3">
                <label class="form-label" for="author">Author</label>
                <input class="form-control" id="author" type="text" name="author" placeholder="Enter book author" value="<?=$author; ?>" />
            </div>
            <?php
            if (isset($book->errorMsg["author"])) {
                echo "<div class='alert alert-danger'>", $book->errorMsg['author'], "</div>";
            }
            ?>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" type="text" name="description" placeholder="Description" ><?=$description; ?></textarea>
            </div>
            <?php
            if (isset($book->errorMsg["description"])) {
                echo "<div class='alert alert-danger'>", $book->errorMsg['description'], "</div>";
            }
            ?>
            <div class="mb-3">
                <label class="form-label" for="dp">Date of publication</label>
                <input class="form-control" id="dp" type="text" name="dp" placeholder="Enter date of publication" value="<?=$dp;?>" />
            </div>
            <?php
            if (isset($book->errorMsg["Date de publication"])) {
                echo "<div class='alert alert-danger'>", $book->errorMsg['Date de publication'], "</div>";
            }
            ?>



            <div class="d-grid">
                <button class="btn btn-primary btn-lg" value="submit" name="edit" type="submit">Edit</button>
            </div>

        </form>

    </div>
    <?php



    ?>
    <script src="./script.js" language='javascript'> </script>
</body>

</html>