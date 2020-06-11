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
    echo "<div class='card mb-2'>
            <div class='card-header'>
                <div class='media'>";
    if ($rowuser[1] != NULL) {
        $img = base64_encode($rowuser[1]);
        echo "<img class='d-flex align-self-start mr-3 img-fluid' src='data:image/*; base64, $img' style='height:40px;'>";
    }
    echo "<div class='media-body'>
            <div class='font-weight-bold login'>$rowuser[0]</div>
            <div class='font-italic datereview'> $row[6]</div></div>";
    mysqli_free_result($resuser);
    echo "</div></div>";   
    echo "<div class='card-body p-2'>
            <h5 class='card-title'>$row[2]
            <span class='badge badge-success ml-2 score'>$row[3]</span></h5>
            <div class='card-text positive'>Good impressions $row[4]</div>
            <div class='card-text negative'>Bad impressions $row[5]</div>
            <span class='timeliv'>Time of living, category: $row[7]</span>
            <span class='catliv'>$row[8]</span>
            </div></div>";     
}
mysqli_free_result($res);


