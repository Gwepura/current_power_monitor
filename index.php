<?php
    // Load the database configuration file
    include_once "db_config.php";

    // Get status message
    if(!empty($_GET['status'])){
        switch($_GET['status']){
            case 'succ':
                $statusType = 'alert-success';
                $statusMsg = 'Data has been imported successfully.';
                break;
            case 'err':
                $statusType = 'alert-danger';
                $statusMsg = 'Some problem occurred, please try again.';
                break;
            case 'invalid_file':
                $statusType = 'alert-danger';
                $statusMsg = 'Please upload a valid CSV file.';
                break;
            default:
                $statusType = '';
                $statusMsg = '';
        }
    };
?>

<!DOCTYPE html>
<html>
    <head> 
        <title>Energy Monitoring System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap cdns -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- js of google of chart for PHP Google Charts --> 
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>

        <link rel="stylesheet" href="styles.css">
        <script src="script.js"></script>
    </head>
    <body>
        <div class="container-fluid w-75 mx-auto" >
            <h1 class="text-center">Energy Monitoring System</h1>
             
            <?php if(!empty($statusMsg)){ ?>
            <div class="col-xs-12">
                <div class="alert <?php echo $statusType; ?> alert-dismissible" role="alert"><?php echo $statusMsg; ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>

            <div class="col-xs-12" id="led_warning">
                <div class="alert alert-danger">Problem occured, please check pressure sensor.</div>
            </div>

            <div class="card text-center">
                <div class="card-header">
                    <div class="float-start">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <button class="nav-link active" aria-current="true" id="btnRealTime" onclick="changeTab('real_time')"> Real Time</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="btnHistorical" onclick="changeTab('historical')"> Historical</button>
                            </li>
                        </ul>
                    </div>
                    <div class="float-end">
                        <div class="led-box" id="green_led">
                            <!-- <h5>Pressure Sensor</h5> -->
                            <div class="led-green"></div>
                        </div>
                        <div class="led-box" id="red_led" hidden>
                            <!-- <h5>Pressure Sensor</h5> -->
                            <div class="led-red"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="float-start">
                        <h5>Flow Control Switch</h5>
                        <div class="btn-group" role="group" aria-label="Control Switch">
                            <input type="raido" class="btn-check" name="btnSwitch" id="btnOnSwitch" value="on" onclick="btnToggle('on')" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" id="btnOnSwitchLabel" for="btnOnSwitch">On</label>

                            <input type="raido" class="btn-check" name="btnSwitch" id="btnOffSwitch" value="off" onclick="btnToggle('off')" autocomplete="off">
                            <label class="btn btn-outline-primary" id="btnOffSwitchLabel" for="btnOffSwitch">Off</label>
                        </div>
                    </div>

                    <div class="dropdown float-end">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            Data Options
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a href="export_to_csv.php" class="dropdown-item">Export to CSV</a></li>
                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importCSVModal">
                                Import from CSV
                            </button></li>
                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#clearDataModal">
                                Clear Data
                            </button></li>
                        </ul>
                    </div>
                
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <div id="real_time_page" >
                        <h2 class="text-center">Real Time Data</h2>
                        <br>
                        <br>
                        <div id="gauges_chart" style="width:50%;margin-left: auto;margin-right: auto;"></div>
                    </div>
                    <div id="historical_page" hidden="hidden">
                        <h2 class="text-center">Historical Data</h2>
                        <br>
                        <br>
                        <div id="time_current_chart" style="width: 900px; height: 500px; margin-right: auto; margin-left: auto;"></div>
                        <div id="time_voltage_chart" style="width: 900px; height: 500px; margin-right: auto; margin-left: auto;"></div>
                        <div id="time_power_chart" style="width: 900px; height: 500px; margin-right: auto; margin-left: auto;"></div>
                        <div id="time_flow_rate_chart" style="width: 900px; height: 500px; margin-right: auto; margin-left: auto;"></div>
                    </div>

                    <h3 class="text-center" id="no_data" hidden>No data available...</h3>
                </div>
            </div>

            <!-- Clear data modal -->
            <div class="modal fade" tabindex="-1" id="clearDataModal" aria-labelledby="clearModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clearModalLabel">Clear Data?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to continue? Changes made will be irreversible.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="delete_data.php" class="btn btn-danger">Clear Data</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload CSV modal -->
            <div class="modal fade" tabindex="-1" id="importCSVModal" aria-labelledby="importCSVModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                            <div class="modal-header">
                                <h5 class="modal-title">Import CSV File</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <form class="form-horizontal" action="import_from_csv.php" method="post" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="file" name="file" />
                                            <input type="submit" class="btn btn-primary" name="importSubmit" value="Import File">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>