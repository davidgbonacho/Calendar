<?php

// require lib
require_once __DIR__.'/dgbcalendar/dgbcalendar.php';
use DGBcalendar\calendar;

$year = isset($_GET["y"])?  $_GET["y"] : date('Y');
$month = isset($_GET["m"])?  $_GET["m"] : date('m'); 

$month = str_pad($month, 2, '0', STR_PAD_LEFT); // put 0 on left if nec.

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calendar</title>
</head>

<body>

<?php

$mycalendar = new calendar($year, $month);

echo $mycalendar->getCalendar();

?>


</body>

</html>