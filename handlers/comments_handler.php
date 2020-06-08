<?php
error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

$selhotel = 'SELECT hotel FROM hotels WHERE id='.$_POST['hoid'];
$reshotel = mysqli_query($link, $selhotel);
$rowhotel = mysqli_fetch_array($reshotel, MYSQLI_NUM);
echo "<h5>Отзывы о проживании в отеле $rowhotel[0]</h5>";
mysqli_free_result($reshotel);
    
$sel = 'SELECT hotelid, userid, title, score, positive, negative, datereview, timeliv, catliv FROM comments WHERE hotelid='.$_POST['hoid'];
$res = mysqli_query($link, $sel);
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    $seluser = 'SELECT login, avatar FROM users WHERE id='.$row[1];
    $resuser = mysqli_query($link, $seluser);
    $rowuser = mysqli_fetch_array($resuser, MYSQLI_NUM);
    echo "<div class='card'><div class='card-header'>
            <div class='user media'>";
    if ($rowuser[1] != NULL) {
        $img = base64_encode($rowuser[1]);
        echo "<img class='d-flex mr-3' src='data:image/*; base64, $img' style='width:30px;'>
            <p class='media-body lead'>$rowuser[0]</p>";
    }
    mysqli_free_result($resuser);

    echo "</div></div>";   
    echo "<div class='card-body'>
            <h4 class='card-title'>$row[2]</h4>
            <span class='datereview'>date('j.m.Y', $row[6])</span>
            <span class='score'>$row[3]</span>
            <p class='card-text positive'>$row[4]</p>
            <p class='card-text negative'>$row[5]</p>
            <span class='timeliv'>date('M.Y', $row[7])</span>
            <span class='catliv'>$row[8]</span>
            </div></div>";     
}
mysqli_free_result($res);


