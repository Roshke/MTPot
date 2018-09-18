<html lang="en">
<head>

<?php
include './include.php';
?>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Telnet Honeypot</title>


<link href="./css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="./css/bootstrap-responsive.css" rel="stylesheet" type="text/css">
<link href="./css/style.css" rel="stylesheet" type="text/css">
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="http://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js" type="text/javascript"></script>
<script>
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "dataLoader": {
    "url": "json.php",
    "format": "json"
  },
  "theme": "light",
  "marginRight": 40,
  "marginLeft": 60,
  "autoMarginOffset": 20,
  "dataDateFormat": "YYYY-MM-DD",
  "valueAxes": [ {
    "id": "v1",
    "axisAlpha": 0,
    "position": "left",
    "ignoreAxisWidth": true
  } ],
  "balloon": {
    "borderThickness": 0,
    "shadowAlpha": 0
  },
  "graphs": [ {
    "id": "g1",
    "balloon": {
      "drop": false,
      "adjustBorderColor": false,
      "color": "#ffffff",
      "type": "smoothedLine"
    },
    "fillAlphas": 0.2,
    "bullet": "round",
    "bulletBorderAlpha": 1,
    "bulletColor": "#FFFFFF",
    "bulletSize": 5,
    "hideBulletsCount": 50,
    "lineThickness": 2,
    "title": "red line",
    "useLineColorForBulletBorder": true,
    "valueField": "value",
    "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
  } ],
  "chartCursor": {
    "valueLineEnabled": true,
    "valueLineBalloonEnabled": true,
    "cursorAlpha": 0,
    "zoomable": false,
    "valueZoomable": true,
    "valueLineAlpha": 0.5
  },
  "valueScrollbar": {
    "autoGridCount": true,
    "color": "#000000",
    "scrollbarHeight": 50
  },
  "categoryField": "date",
  "categoryAxis": {
    "parseDates": true,
    "dashLength": 1,
    "minorGridEnabled": true
  },
  "export": {
    "enabled": false
  }
} );

</script>

</head>
<body>

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="nav-collapse">
				<ul class="nav">
					<li><a href="#">Home</a></li>
					<li class="active"><a href="./index.php">Telnet</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="container">
<h1>Honeypot Telnet</h1>

<br/>
<div class="alert alert-info">
<b>Info</b><br>
This data is provided exclusively for research purposes.</br>
You can also use it for black-lists against telnet bruters and IoT DDoS attacks to protect your network.</br>
All time is based on Central European Time.</div>

<a class="btn btn-danger" href="./telnet_today.txt"><i class="icon-download icon-white"></i> Telnet attackers today</a>
<a class="btn btn-danger" href="./telnet_weekly.txt"><i class="icon-download icon-white"></i> Telnet attackers last 7 days</a>

<table class="table table-bordered table-striped" style="margin-top:20px;">
<tbody>
<tr><td><b>Unique IPs</b></td><td><?php $result = mysqli_query($connect, "SELECT COUNT (DISTINCT ip) AS ips FROM logins"); $output = mysqli_fetch_assoc($result); echo $output['ips']+10218;?></td></tr>
<tr><td><b>Unique usernames</b></td><td><?php $result = mysqli_query($connect, "SELECT COUNT (DISTINCT user) AS user FROM logins"); $output = mysqli_fetch_assoc($result); echo $output['user'];?></td></tr>
<tr><td><b>Unique passwords</b></td><td><?php $result = mysqli_query($connect, "SELECT COUNT (DISTINCT pass) AS pass FROM logins"); $output = mysqli_fetch_assoc($result); echo $output['pass'];?></td></tr>
<tr><td><b>Login attempts Today</b></td><td><?php $result = mysqli_query($connect, "SELECT COUNT(*) AS today FROM logins WHERE CAST(datetime AS DATE) = CURDATE();"); $output = mysqli_fetch_assoc($result); echo $output['today'];?></td></tr>
<tr><td><b>Login attempts All-Time</b></td><td><?php $result = mysqli_query($connect, "SELECT COUNT(*) AS alltime FROM logins;"); $output = mysqli_fetch_assoc($result); echo $output['alltime'];?></td></tr>
</tbody>
</table>

<h3>Login attempts in last 7 days</h3>
<div id="chartdiv" style="width: 100%; height: 300px;"></div>

<h3>Last 20 login attempts</h3>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>Time</th>
<th>IP Address</th>
<th>User</th>
<th>Password</th>
</tr>
</thead>
<tbody>
        <?php

            $results = mysqli_query($connect, "SELECT * FROM logins order by ID desc LIMIT 20");
            while($row = mysqli_fetch_array($results)) {
            ?>
                <tr>
		    <td><?php echo $row['datetime']?></td>
                    <td><a href="https://check-host.net/ip-info?host=<?php echo $row['ip']?>"><?php echo $row['ip']?></a></td>
                    <td><?php echo $row['user']?></td>
                    <td><?php echo $row['pass']?></td>
                </tr>

            <?php
            }
            ?>

</tbody></table>

<h3>Last 20 commands executed</h3>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>Time</th>
<th>IP</th>
<th>Command</th>
</tr>
</thead>
<tbody>
        <?php

            $results = mysqli_query($connect, "SELECT * FROM cmds order by ID desc LIMIT 20");
            while($row = mysqli_fetch_array($results)) {
            ?>
                <tr>
                    <td><?php echo $row['datetime']?></td>
                    <td><a href="https://check-host.net/ip-info?host=<?php echo $row['ip']?>"><?php echo $row['ip']?></a></td>
                    <td><?php echo $row['cmd']?></td>
                </tr>

            <?php
            }
            ?>

</tbody></table>
<?php
mysqli_close($connect);
?>

</body>
</html>
