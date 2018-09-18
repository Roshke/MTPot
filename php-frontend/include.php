<?php
//Fill out here the same database credentials as on the honeypot server
$connect = mysqli_connect("hostname.or.IP", "USER", "password", "database_name");

if (!$connect) {
    die("Connection to DB failed");
} 

?>
