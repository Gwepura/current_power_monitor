<?php 
  // Get Heroku ClearDB connection information
  // $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  // $cleardb_server = $cleardb_url["host"];
  // $cleardb_username = $cleardb_url["user"];
  // $cleardb_password = $cleardb_url["pass"];
  // $cleardb_db = substr($cleardb_url["path"],1);

  // $active_group = 'default';
  // $query_builder = TRUE;

  // Connect to DB
  // $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

  // Development
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "data_readings";

  // Afrihost
  // $servername = "localhost";
  // $username = "solutlqv_anesu";
  // $password = "RJ&xMJwzEMdi1XV3";
  // $dbname = "solutlqv_energy_monitoring";

  // Create connection 
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $conn->set_charset('utf8mb4');
?>
