<?php 
  class Post {
    // DB stuff
    private $conn;
    private $table = 'balance';

    // Post Properties
    public $id;
    public $balance_id;
    public $balance_name;
    public $balance_price;
    public $Created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' WHERE 1';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM ' . $this->table . '                                    
                                    WHERE
                                    Balance_id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->balance_id = $row['Balance_id'];
          $this->balance_name = $row['Balance_name'];
          $this->balance_price = $row['Balance_price'];
          $this->Created_at = $row['Created_at'];
          
    }

    // // Create Post
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET Balance_name = :title, Balance_price = :price';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->balance_name = htmlspecialchars(strip_tags($this->balance_name));
          $this->balance_price = htmlspecialchars(strip_tags($this->balance_price));

          // Bind data
          $stmt->bindParam(':title', $this->balance_name);
          $stmt->bindParam(':price', $this->balance_price);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET Balance_name = :title, Balance_price = :price WHERE Balance_id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->balance_name = htmlspecialchars(strip_tags($this->balance_name));
          $this->balance_price = htmlspecialchars(strip_tags($this->balance_price));
          $this->balance_id = htmlspecialchars(strip_tags($this->balance_id));

          // Bind data
          $stmt->bindParam(':title', $this->balance_name);
          $stmt->bindParam(':price', $this->balance_price);
          $stmt->bindParam(':id', $this->balance_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE Balance_id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->balance_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
}