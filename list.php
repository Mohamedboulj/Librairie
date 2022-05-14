<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Librairie</title>


</head>
<?php
require_once("./connexion.php");
require_once("./class/book.php");
$book = new book();
  $success = null;
  $error = null;
  if (isset($_GET["id"])) {
    if ($book->delBook($_GET["id"])) {
      $success = "Book deleted successfully";
      
    } else {
      $error = "Error of deletion";
    }
  };


  ?>
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
            <a class="nav-link active" aria-current="page" href="./index.php">Add books</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./list.php">List of books</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <?php
  
  echo '<div class="container shadow p-3 mt-3">';
  // Retrieving data from data base table
  $listOfbooks = $book->retrieveBooks();
  echo "<div class='container'>";
  echo ' <h3 class="text-center">List of available books</h3>';
  if (isset($sucess)) {
    echo "<div class='alert alert-success info'>", $success, "</div>";
  }
  if (isset($error)) {
    echo "<div  class='alert alert-danger info'>", $error, "</div>";
  } 
  if ($result = $conn->query($listOfbooks)) {
    if ($result->num_rows > 0) {

      echo "<table  class='table table-bordered table-sm table-striped'  >";
      echo "<tr>";
      echo "<th class='text-center'>#</th>";
      echo "<th class='text-center'>Title</th>";
      echo "<th class='text-center'>Author</th>";
      echo "<th class='text-center'>Descrption</th>";
      echo "<th class='text-center'>Date of publication</th>";
      echo "<th class='text-center'>Action</th>";
      echo "</tr>";
      while ($row = $result->fetch_array()) {
  ?>
        <tr>
          <td class='text-center'> <?php echo $row['ref'];  ?> </td>
          <td class='text-center'> <?php echo $row['title']; ?> </td>
          <td class='text-center'> <?php echo $row['author']; ?> </td>
          <td class='text-center'> <?php echo $row['description']; ?> </td>
          <td class='text-center'> <?php echo $row['date_of_publication']; ?> </td>
          <td class='text-center'><a href=edit.php?id=<?php echo $row['ref']; ?> class="btn btn-primary"> Edit</a>&nbsp;<a href=list.php?id=<?php echo $row['ref']; ?> class="btn btn-danger"> Delete</a> </td>
        </tr>
  <?php
      }
      echo "</table>";
      $result->free();
    } else {
      echo "No records matching your query were found.";
    }
  } else {
    echo "ERROR: Could not able to execute $selectBook. " . $mysqli->error;
  }
  echo "</div>";

  echo '</div>';



  ?>
  








</body>

</html>