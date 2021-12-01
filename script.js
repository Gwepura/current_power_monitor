$( document ).ready(function () {
  var flow_state = getCookie("flow_state");

  if (flow_state == null) {
      flow_state = "on";
      btnToggle(flow_state);
  } else {
      setToggleState(flow_state);
  }
});

// Loads gauges for real time data
google.charts.load('current', {
packages: ['gauge']
}).then(function () {
var options = {
  minorTicks: 5,
};

var chart = new google.visualization.Gauge(document.getElementById('gauges_chart'));

drawGaugesChart();

function drawGaugesChart() {
  $.ajax({
      url: 'get_gauges_data.php',
      dataType: 'json' 
  }).done(function (jsonData) {
      if (jsonData.length == 1) {
          // Display no data
          $('#no_data').prop('hidden', false);
          $('#green_led').prop('hidden', false);
          $('#red_led').prop('hidden', true);
      } else {
          // Use respone from php for data table
          var flow_rate = jsonData[4][1];
          var power = jsonData[3][1] + " mW";
          var data = google.visualization.arrayToDataTable(jsonData);
          chart.draw(data, options);

          $("#power_display").text(power);

          $('#no_data').prop('hidden', true);
          
          if (flow_rate < 476) {
            $('#green_led').prop('hidden', true);
            $('#red_led').prop('hidden', false);
            $('#led_warning').prop('hidden', false);
          } else {
            $('#green_led').prop('hidden', false);
            $('#red_led').prop('hidden', true);
            $('#led_warning').prop('hidden', true);
          }
      }

      // Draw again in 5 seconds
      window.setTimeout(drawGaugesChart, 5000);
  });
};
});

// Loads gauges for time vs current data
google.charts.load('current', {
  packages: ['corechart']
  }).then(function () {
  var options = {
      title: 'Time vs Current (mA)',
    //   legend: { position: ['bottom']},
  };

  var chart = new google.visualization.LineChart(document.getElementById('time_current_chart'));

  drawTimeCurrentLineChart();

  function drawTimeCurrentLineChart() {
      $.ajax({
          url: 'get_time_current_data.php',
          dataType: 'json'
      }).done(function(jsonData) {
          if (jsonData.length > 1) {
              var data = google.visualization.arrayToDataTable(jsonData);
              chart.draw(data, options);
              $('#time_current_chart').prop('hidden', false);
          } else {
              $('#time_current_chart').prop('hidden', true);
          }
          

          // Draw again in 5 seconds
          window.setTimeout(drawTimeCurrentLineChart, 5000);
      })
  }
});

// Loads gauges for time vs voltage data
google.charts.load('current', {
  packages: ['corechart']
  }).then(function () {
  var options = {
      title: 'Time vs Voltage (V)',
      legend: { position: ['bottom']},
  };

  var chart = new google.visualization.LineChart(document.getElementById('time_voltage_chart'));

  drawTimeVoltageLineChart();

  function drawTimeVoltageLineChart() {
      $.ajax({
          url: 'get_time_voltage_data.php',
          dataType: 'json'
      }).done(function(jsonData) {
          if (jsonData.length > 1) {
              var data = google.visualization.arrayToDataTable(jsonData);
              chart.draw(data, options);
              $('#time_voltage_chart').prop('hidden', false);
          } else {
              $('#time_voltage_chart').prop('hidden', true);
          }

          // Draw again in 5 seconds
          window.setTimeout(drawTimeVoltageLineChart, 5000);
      })
  }
});

// Loads gauges for time vs voltage data
google.charts.load('current', {
  packages: ['corechart']
  }).then(function () {
  var options = {
      title: 'Time vs Power (mW)',
      legend: { position: ['bottom']},
  };

  var chart = new google.visualization.LineChart(document.getElementById('time_power_chart'));

  drawTimePowerLineChart();

  function drawTimePowerLineChart() {
      $.ajax({
          url: 'get_time_power_data.php',
          dataType: 'json'
      }).done(function(jsonData) {
          if (jsonData.length > 1) {
              var data = google.visualization.arrayToDataTable(jsonData);
              chart.draw(data, options);
              $('#time_power_chart').prop('hidden', false);
          } else {
              $('#time_power_chart').prop('hidden', true);
          }

          // Draw again in 5 seconds
          window.setTimeout(drawTimePowerLineChart, 5000);
      })
  }
});

// Loads gauges for time vs flow rate data
google.charts.load('current', {
  packages: ['corechart']
  }).then(function () {
  var options = {
      title: 'Time vs Flow Rate',
      legend: { position: ['bottom']},
  };

  var chart = new google.visualization.LineChart(document.getElementById('time_flow_rate_chart'));

  drawTimeFlowRateLineChart();

  function drawTimeFlowRateLineChart() {
      $.ajax({
          url: 'get_time_flow_rate_data.php',
          dataType: 'json'
      }).done(function(jsonData) {
          if (jsonData.length > 1) {
              var data = google.visualization.arrayToDataTable(jsonData);
              chart.draw(data, options);
              $('#time_flow_rate_chart').prop('hidden', false);
          } else {
              $('#time_flow_rate_chart').prop('hidden', true);
          }

          // Draw again in 5 seconds
          window.setTimeout(drawTimeFlowRateLineChart, 5000);
      })
  }
});

// Switches between real time data tab and historical data tab
function changeTab(tab_name) { 
  switch(tab_name) {
    case 'real_time':
      document.getElementById("real_time_page").hidden = false;
      document.getElementById("historical_page").hidden = true;
      document.getElementById("lcd_display_page").hidden = true;

      $("#btnHistorical").removeClass("active");
      $("#btnRealTime").addClass("active");
      $("#btnLCDDisplay").removeClass("active");
      break;
    case 'historical':
      $("#btnRealTime").removeClass("active");
      $("#btnHistorical").addClass("active");
      $("#btnLCDDisplay").removeClass("active");

      document.getElementById("real_time_page").hidden = true;
      document.getElementById("historical_page").hidden = false;
      document.getElementById("lcd_display_page").hidden = true;
      break;
    case 'lcd':
      $("#btnRealTime").removeClass("active");
      $("#btnHistorical").removeClass("active");
      $("#btnLCDDisplay").addClass("active");

      document.getElementById("real_time_page").hidden = true;
      document.getElementById("historical_page").hidden = true;
      document.getElementById("lcd_display_page").hidden = false;
    default:
      break;
  }
}

// Saves flow state
function btnToggle(state) {
  document.cookie = "flow_state=" + state;
  setToggleState(state);
}

// Updates control state buttons
function setToggleState(state) {
  if(state == "on") {
      $("#btnOnSwitch").prop('checked', true);
      $("#btnOnSwitchLabel").removeClass("btn-outline-primary");
      $("#btnOnSwitchLabel").addClass("btn-primary");
      
      $("#btnOffSwitch").prop('checked', false);
      $("#btnOffSwitchLabel").removeClass("btn-primary");
  } 
  else if(state == "off") {
      $("#btnOffSwitch").prop('checked', true);
      $("#btnOffSwitchLabel").removeClass("btn-outline-primary");
      $("#btnOffSwitchLabel").addClass("btn-primary");
      
      $("#btnOnSwitch").prop('checked', false);
      $("#btnOnSwitchLabel").removeClass("btn-primary");
  }
}

// Returns cookie based on name
function getCookie(name) {
  // Split cookie string and get all individual name=value pairs in an array
  var cookieArr = document.cookie.split(";");
  
  // Loop through the array elements
  for(var i = 0; i < cookieArr.length; i++) {
      var cookiePair = cookieArr[i].split("=");
      
      /* Removing whitespace at the beginning of the cookie name
      and compare it with the given string */
      if(name == cookiePair[0].trim()) {
          // Decode the cookie value and return
          return decodeURIComponent(cookiePair[1]);
      }
  }

  // Return null if not found
  return null;
}