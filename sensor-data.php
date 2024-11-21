<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "christianucb_database";

try {
    // Create connection
    $pdo = new PDO("mysql:host={$servername};dbname={$dbname}", "{$username}", "{$password}");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $temperature = $_GET['temperature'];
    $humidity = $_GET['humidity'];
    $air_quality = $_GET['air_quality'];
    $soil_humidity = $_GET['soil_humidity'];

    $sql = "INSERT INTO data(`temperature`, `humidity`,`air_quality`,`soil_humidity`)
            VALUES ('{$temperature}','{$humidity}','{$air_quality}','{$soil_humidity}')";
    $query = $pdo->prepare($sql);
    if ($query->execute() === TRUE) {
        echo "Successfully inserted into" . $dbname;
    } else {
        echo "Error while inserting into ". $dbname . " check this request => " . $sql;
    }
} catch (PDOException $exception) {
    echo 'Error occured' . $exception->getMessage();
}

