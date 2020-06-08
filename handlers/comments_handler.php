<?php
error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

$selhotel = 'SELECT hotel FROM hotels WHERE id='.$_POST['hoid'];
$reshotel = mysqli_query($link, $selhotel);
$rowhotel = mysqli_fetch_array($reshotel, MYSQLI_NUM);
echo "<h5>Отзывы о проживании в отеле $rowhotel[0]</h5>";
mysqli_free_result($reshotel);

$sel = 'SELECT hotelid, userid, title, score, positive, negative, DATE_FORMAT(datereview, "%e %M %Y"), DATE_FORMAT(timeliv, "%M %Y"), catliv FROM comments WHERE hotelid='.$_POST['hoid'];
$res = mysqli_query($link, $sel);
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    $seluser = 'SELECT login, avatar FROM users WHERE id='.$row[1];
    $resuser = mysqli_query($link, $seluser);
    $rowuser = mysqli_fetch_array($resuser, MYSQLI_NUM);
    echo "<div class='card'><div class='card-header'>
            <div class='user media'>";
    if ($rowuser[0] != NULL) {
        $img = base64_encode($rowuser[0]);
        echo "<img class='d-flex mr-3' src='data:image/*; base64, $img' style='width:30px;'>";
    }
    echo "<p class='media-body'>$rowuser[0]</p>";
    mysqli_free_result($resuser);
    echo "</div></div>";   
    echo "<div class='card-body'>
            <h5 class='card-title'>$row[2]</h5>
            <span class='score'>My score $row[3]</span>
            <div class='datereview'>Date review $row[6]</div>
            <div class='card-text positive'>Good impressions $row[4]</div>
            <div class='card-text negative'>Bad impressions $row[5]</div>
            <span class='timeliv'>When lived $row[7]</span> <br>
            <span class='catliv'>Where lived $row[8]</span>
            </div></div>";     
}
mysqli_free_result($res);


