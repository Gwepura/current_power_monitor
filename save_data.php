<?php 
  // Load database configuration file
  include_once 'db_config.php';
  
  if ($_GET["current"] && $_GET["voltage"] && $_GET["power"] && $_GET["flow_rate"]) {
    save_row($_GET["current"], $_GET["voltage"], $_GET["power"], $_GET["flow_rate"], $conn);
  }

  function save_row($current, $voltage, $data_power, $flow_rate, $conn) {
    $sql = "INSERT into data_readings (current,voltage,data_power,flow_rate)
              values('".$current."','".$voltage."','".$data_power."','".$flow_rate."')";
    $result = mysqli_query($conn, $sql);

    $flow_rate_warning = ($flow_rate < 476) ? "?flow_rate_warning=true" : "?flow_rate_warning=false";

    $_SESSION['redirect_url'] = $_SERVER['PHP_SELF']; 
    header('Location: index.php'.$flow_rate_warning);
  }
?>