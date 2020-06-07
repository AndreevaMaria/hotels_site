<?php
error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

$sel = 'SELECT * FROM hotels WHERE cityid='.$_GET['ciid'];
$res = mysqli_query($link, $sel);
echo '<option value="0">Select hotel...</option>';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
mysqli_free_result($res);