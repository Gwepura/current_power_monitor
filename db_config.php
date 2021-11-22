<?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "data_readings";

  // Create connection 
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $conn->set_charset('utf8mb4');
?>