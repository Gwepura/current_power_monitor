<?php 
   // Load database configuration file
   include_once 'db_config.php';
  
  // Gets data from database
  $gauges_sql = "SELECT * FROM data_readings ORDER BY data_timestamp DESC LIMIT 1";
  $gauges_result = mysqli_query($conn, $gauges_sql);  

  // Create data arrays
  $gauges_data = [];
  $gauges_data[] = ["Label", "Value"];

  

  // Output data of each row
  while($row = mysqli_fetch_assoc($gauges_result)) {
    $gauges_data[] = ["Current", (float) $row["current"]];
    $gauges_data[] = ["Voltage", (float) $row["voltage"]];
    $gauges_data[] = ["Power", (float) $row["data_power"]];
    $gauges_data[] = ["Flow Rate", (float) $row["flow_rate"]];
  }

  // function get_last_row($conn) {
    

    // return $gauges_result;
  // }

  mysqli_close($conn);

  // Write data array to page
  echo json_encode($gauges_data, JSON_NUMERIC_CHECK);
?>
