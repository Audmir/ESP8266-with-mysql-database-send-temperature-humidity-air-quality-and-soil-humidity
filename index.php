<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AirStation</title>
    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="shortcut icon" type="image/x-icon" href="">
    <!-- <link rel="shortcut icon" href="assets/images/favicon.png" /> -->
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">

    <script text="text/javascript" src="assets/js/chart.js"></script>
    <script text="text/javascript">
        setInterval(function () {
            google.charts.load('current', { packages: ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                // Set Data
                const data = google.visualization.arrayToDataTable([
                    ['Humidity', 'temperature'],
                    [0, 0], [10, 10], [15, 2], [45, 2], [90, 9],
                    [100, 9], [110, 10], [120, 11],
                    [130, 14], [140, 14], [150, 15]
                ]);

                // Set Options
                const options = {
                    title: 'Temperature',
                    legend: {
                        position: 'bottom',
                        alignment: 'center',
                        orientation: 'vertical',
                    },
                    chartArea: { width: '80%', height: '75%' }
                };

                // Draw
                const chart = new google.visualization.LineChart(document.getElementById('myChart'));
                chart.draw(data, options);
            }
        }, 500);
    </script>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="title">
                <h1>AirStation</h1>
            </div>
            <div class="account">
                <button>Rapport</button>
            </div>
        </div>
        <div class="bott">
            <div class="card">
                <div class="values" id="values-from-card"></div>
                <div id="myChart" style="width:100%; max-width:100%; height:340px;"></div>
            </div>
        </div>
    </div>

    <script text="text/javascript" src="ajax/fetch-data.js"></script>
</body>

</html>