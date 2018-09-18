<?php
date_default_timezone_set('Europe/Zagreb');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$fp = fopen('./telnet_weekly.txt', 'w');

fwrite($fp, "# Weekly Telnet Bruters from honeypot\n# List was generated on " . date('m/d/Y h:i:s a', time()) . " Central European Time\n");

 include './include.php';
 $result = mysqli_query($connect, "SELECT DISTINCT ip AS ips FROM logins WHERE datetime BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()");


 while($row = mysqli_fetch_array($result)) {
 fwrite($fp, $row['ips'] . "\n");
}
mysqli_close($connect);
fclose($fp);
?>
