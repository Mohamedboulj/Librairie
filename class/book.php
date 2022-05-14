<?php
require_once("./connexion.php"
);
require_once("./checkfunction.php");

class book
{

   private Int $ref;
   private ?string $title;
   private ?string $author;
   private ?string $description;
   private ?string $date_of_publication;
   public array $errorMsg = [];
   private const insert = "INSERT INTO book (title,author,description,date_of_publication) VALUES (?,?,?,?)";
   const selectBook = "SELECT * FROM book ";
   const selectByIdQuery = "SELECT * FROM book WHERE ref=?";
   const editQuery = "UPDATE book set title = ?, author = ?, description = ?, date_of_publication = ? WHERE ref = ?";
   const delbook = "DELETE FROM book WHERE ref = ? " ;



   public function setTitle(string $title)
   {
      try {
         $this->title = checkField("Title", $title, 3);
      } catch (Exception $e) {
         $this->errorMsg["title"] = $e->getMessage();
      }
   }
   public function setAuthor(string $author)
   {
      try {
         $this->author = checkField("Author", $author, 3);
      } catch (Exception $e) {
         $this->errorMsg["author"] = $e->getMessage();
      }
   }
   public function setDescription(string $description)
   {
      try {
         $this->description = checkField("Description", $description, 4);
      } catch (Exception $e) {
         $this->errorMsg["description"] = $e->getMessage();
      }
   }
   public function setDop(string $date_of_publication)
   {
      try {
         $this->date_of_publication = checkField("Date de publication", $date_of_publication, 3);
      } catch (Exception $e) {
         $this->errorMsg["Date de publication"] = $e->getMessage();
      }
   }
   public function getref()
   {
      return $this->ref;
   }

   public function getTitle()
   {
      return $this->title;
   }

   public function getAuthor()
   {
      return $this->author;
   }

   public function getDescription()
   {
      return $this->description;
   }

   public function getDop()
   {
      return $this->date_of_publication;
   }


   public function getFields(): array
   {

      return [$this->getTitle(), $this->getAuthor(), $this->getDescription(), $this->getDop()];
   }


   public function addBook($fields): bool
   {
      global $conn;
      $stmt = $conn->prepare(self::insert);
      $stmt->bind_param("ssss", ...$fields);
      if ($stmt->execute()) {
         return true;
      }
      return false;
   }

   public function retrieveBooks()
   {
      return self::selectBook;
   }

   public function getBookbyId(Int $ref)
   {
      global $conn;
      $stmt = $conn->prepare(self::selectByIdQuery);
      $stmt->bind_param('i', $ref);
      if ($stmt->execute()) {
         return $stmt->get_result();
      }
      return false;
   }
   public function edit(string $requestQuery, string $fieldTypes, int $ref, array $fields): bool
   {  
      global $conn;
      $stmt = $conn->prepare($requestQuery);
      $myArray = [...$fields, $ref];
      $stmt->bind_param($fieldTypes, ...$myArray);

      if ($stmt->execute()) {
         return true;
      }
      return false;
   }

   public function delBook($ref)
     {  
        global $conn;
        $stmt =$conn->prepare(self::delbook);
        $stmt->bind_param('i', $ref);
        if ( $stmt->execute()) {
           return true;
        }
        return false;
     }
}
    
     

