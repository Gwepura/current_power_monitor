<?php 
  // Load database configuration file
  include_once 'db_config.php'; 
  
  // Get all records from database
  $query = $conn->query("SELECT * FROM data_readings ORDER BY id ASC");
  if($query->num_rows > 0) {
    $delimiter = ",";
    $filename = "energy_monitoring_system (" . date('Y-m-d') . ").csv";

    // Create a file pointer
    $f = fopen('php://memory', 'w');
    
    // Set column headers
    $fields = array('Timestamp', 'Current(mA)', 'Voltage(V)', 'Power(mW)', 'Flow Rate');
    fputcsv($f, $fields, $delimiter);

    //Output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()) {
      // $status = ($row['status'] == 1) ? 'Active':'Inactive';
      $line_data = array($row['data_timestamp'], $row['current'], $row['voltage'], $row['data_power'], $row['flow_rate']);

      fputcsv($f, $line_data, $delimiter);
    }

    // Move back to beginning of file
    fseek($f, 0);

    // Set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    // Output all remaining data on a file pointer
    fpassthru($f);
  }

  exit;
?>