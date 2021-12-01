<?php 
  if (isset($_COOKIE)) {
    $flow_state = $_COOKIE["flow_state"];

    header('Content-Type: application/json');
    echo json_encode($flow_state);
  }
?>