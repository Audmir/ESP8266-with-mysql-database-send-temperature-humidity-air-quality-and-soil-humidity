<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "christianucb_database";

try {
    // Create connection
    $pdo = new PDO("mysql:host={$servername};dbname={$dbname}", "{$username}", "{$password}");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch the data
    $stmt = $pdo->prepare("SELECT * FROM data ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($res) > 0) {
        foreach ($res as $row) {
            $html = "
            <div class='val1-temp'>
                <h2><i class='fa fa-thermometer'></i> Température</h2>
                <h1>".$row['temperature']." <span>&deg; C</span></h1>
            </div>
            <div class='val1-hum'>
                <h2><i class='fa fa-thermometer-half'></i> Humidité</h2>
                <h1>".$row['humidity']."<span> %</span></h1>
            </div>
            <div class='val1-air'>
                <h2>Qualité air</h2>
                <h1>".$row['air_quality']."<span></span></h1>
            </div>
             <div class='val1-air'>
                <h2>Humidité du sol</h2>
                <h1>".$row['soil_quality']."<span></span></h1>
            </div>
    ";
            echo $html;
        }
    } else {
        $html = "
            <div class='val1-temp'>
                <h2><i class='fa fa-thermometer'></i> Température</h2>
                <h1>0.0 <span>&deg; C</span></h1>
            </div>
            <div class='val1-hum'>
                <h2><i class='fa fa-thermometer-half'></i> Humidité</h2>
                <h1>0.0<span> %</span></h1>
            </div>
            <div class='val1-air'>
                <h2>Qualité air</h2>
                <h1>0.0<span></span></h1>
            </div>
            <div class='val1-air'>
                <h2>Humidité du sol</h2>
                <h1>0.0<span></span></h1>
            </div>
    ";
            echo $html;
    }
} catch (PDOException $exception) {
    echo "Connection failed: " . $exception->getMessage();
}
