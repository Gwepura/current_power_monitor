<?php 
  // Load database configuration file
  include_once 'db_config.php';
  
  // Gets data from database
  $sql = "SELECT data_timestamp, current FROM data_readings ORDER BY data_timestamp";
  $result = mysqli_query($conn, $sql);  

  // Create data arrays
  $data = [];
  $data[] = ["Time", "Current"];

  // Output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $data[] = [$row["data_timestamp"], (float) $row["current"]];
  }

  mysqli_close($conn);

  // Write data array to page
  echo json_encode($data);
?>