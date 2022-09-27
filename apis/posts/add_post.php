<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  $post->balance_name = $data->balance_name;
  $post->balance_price = $data->balance_price;

  // Create post
  if($post->create()) {
    echo json_encode(
      array('message' => 'Post Created', 'balance_name' => $post->balance_name, 'balance_price' => $post->balance_price), JSON_PRETTY_PRINT
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created'), JSON_PRETTY_PRINT
    );
  }

