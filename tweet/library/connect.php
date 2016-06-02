<?php
$conne_error = 'could not connect';

$servername = "localhost";
$username = "ani";
$password = "";
$mysqli_db='twitter';
$conn = mysqli_connect($servername, $username, $password, $mysqli_db);

if(!@mysqli_connect($servername, $username, $password, $mysqli_db)){
    die($conne_error);
}
?>
