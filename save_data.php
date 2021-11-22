<?php 
  // Load database configuration file
  include_once 'db_config.php';
  
  if ($_GET["timestamp"] && $_GET["current"] &&
    $_GET["voltage"] && $_GET["power"] && $_GET["flow_rate"]) {
      $sql = "INSERT into data_readings (data_timestamp,current,voltage,data_power,flow_rate)
              values('".$_GET["timestamp"]."','".$_GET["current"]."','".$_GET["voltage"]."','".$_GET["power"]."','".$_GET["flow_rate"]."')";
              $result = mysqli_query($conn, $sql);
  }
?>