<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
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

  // Set ID to update
  $post->balance_id = $data->id;

  $post->balance_name = $data->balance_name;
  $post->balance_price = $data->balance_price;

  // Update post
  if($post->update()) {
    echo json_encode(
      array('message' => 'Post Updated', 'text'=> $post->balance_name, 'price' => $post->balance_price)
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Updated')
    );
  }

