<?php

include './include.php';

$results = mysqli_query($connect, "SELECT DATE(datetime) AS datetime,COUNT(id) AS number FROM logins WHERE datetime BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() GROUP BY DATE(datetime);");

$prefix = '';
echo "[";
while ( $row = mysqli_fetch_assoc( $results ) ) {
  echo $prefix . " {";
  echo '  "date": "' . $row['datetime'] . '",' . "";
  echo '  "value": ' . $row['number'] . '' . "";
  echo " }";
  $prefix = ",";
}
echo "]";
mysqli_close($connect);
?>
