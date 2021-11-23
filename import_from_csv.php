<?php 
  // Load database configuration file
  include_once 'db_config.php';
  include_once 'save_data.php';

  if(isset($_POST["importSubmit"])) {
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 
      'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 
      'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 
      'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
      // If the file is uploaded
      if(is_uploaded_file($_FILES['file']['tmp_name'])){    
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        // Skip the first line
        fgetcsv($csvFile);

        // Parse data from CSV file line by line
        while(($line = fgetcsv($csvFile)) !== FALSE) {
          // Get row data
          $current = $line[1];
          $voltage = $line[2];
          $data_power = $line[3];
          $flow_rate = $line[4];

          save_row($current, $voltage, $data_power, $flow_rate, $conn);
        }

        // Close opened CSV file
        fclose($csvFile);

        $qstring = "?status=succ";
      } else {
        $qstring = "?status=err";
      }
    } else {
      $qstring = "?status=invalid_file";
    }

  } 
    
  // Redirect to index.php
  header("Location: index.php".$qstring);
  
?>