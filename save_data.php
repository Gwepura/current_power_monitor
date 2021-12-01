<?php 
  // Load database configuration file
  include_once 'db_config.php';

  $result = convert_to_json($_SERVER["QUERY_STRING"]);
  save_row($result[0], $result[1], $result[2], $result[3], $conn);

  function convert_to_json($data) {
    $keywords = preg_split("/[\s,=,&]+/", $data);
    $arr = array();

    for($i=0; $i < sizeof($keywords); $i++) {
      if($i % 2 != 0) {
        array_push($arr, $keywords[$i]);
      }
    }
    return $arr;
  }

  function save_row($current, $voltage, $data_power, $flow_rate, $conn) {
    $sql = "INSERT into data_readings (current,voltage,data_power,flow_rate)
              values('".$current."','".$voltage."','".$data_power."','".$flow_rate."')";
    $result = mysqli_query($conn, $sql);
  }
?>