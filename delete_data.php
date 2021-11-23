<?php 
  // Load database configuration file
  include_once 'db_config.php'; 
  
  // Get all records from database
  $sql = "DELETE FROM data_readings";
  $result = mysqli_query($conn, $sql);

  $_SESSION['redirect_url'] = $_SERVER['PHP_SELF']; 
  header('Location: index.php');

  exit;
?>