<?php
error_reporting(E_ALL);
$link = connect();

if (isset($_POST['sndbtn'])) {
    echo 'alert("Thanks for review")';
    $hotelid = $_POST['hotelid'];
    $userid = $_POST['userid'];
    $title = trim(utf8_encode(htmlspecialchars($_POST['title'])));
    $score = $_POST['score'];
    $positive = trim(utf8_encode(htmlspecialchars($_POST['positive'])));
    $negative = trim(utf8_encode(htmlspecialchars($_POST['negative'])));
    $catlive = trim(utf8_encode(htmlspecialchars($_POST['catlive'])));
    $timeliv = strtotime($_POST['timeliv']);
    $datereview = strtotime(date("j.m.Y");
    
    $ins = "INSERT INTO comments (hotelid, userid, title, score, positive, negative, datereview, timeliv, catliv) VALUES ('$hotelid', '$userid', '$title', '$score', '$positive', '$negative', '$datereview', '$timeliv', '$catliv')";
    mysqli_query($link, $ins);
    
    $err = mysqli_errno($link);
    if($err) {
        echo "<h6 class='text-danger'>Error code ".$err."</h6>";   
    } else {
    echo "<h4 class='text-success'>Ваш комментарий добавлен, ".$_POST['user']."!</h4>";
    }
}

