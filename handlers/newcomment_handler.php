<?php
error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

if($_POST['user'] != "undefined") {
    $seluserid = 'SELECT id FROM users WHERE login='.$_POST['user'];
    $resuserid = mysqli_query($link, $seluserid);
    $rowuserid = mysqli_fetch_array($resuserid, MYSQLI_NUM);
    $userid = $rowuserid[0];
    mysqli_free_result($resuserid);

    $selhotel = 'SELECT hotel FROM hotels WHERE id='.$_POST['hoid'];
    $reshotel = mysqli_query($link, $selhotel);
    $rowhotel = mysqli_fetch_array($reshotel, MYSQLI_NUM);
    $hotel = $rowhotel[0];
    mysqli_free_result($reshotel); 
    
    echo "<h5>".$_POST['user'].", разместите свой отзыв о проживании в отеле $hotel</h5>";
    if (!isset($_GET['sndbtn'])) {
    echo '<form action="index.php?page=2" method="get" class="input-form">
        <div class="form-group">
            <label for="title">Заголовок отзыва</label>
            <input type="text" class="form-control" name="title">
        </div>
        <div class="form-group">
            <label for="score">Оценка от 1 до 10</label>
            <input type="number" class="form-control" name="score" min="1" max="10" value="1">
        </div>
        <div class="form-group">
            <label for="positive">Положительные впечатления:</label>
            <input type="text" class="form-control" name="positive">
        </div>
        <div class="form-group">
            <label for="negative">Негативные впечатления:</label>
            <input type="text" class="form-control" name="negative">
        </div>
        <div class="form-group">
            <label for="timeliv">Время проживания (месяц/год)</label>
            <input type="month" class="form-control" name="timeliv">
        </div>
        <div class="form-group">
            <label for="catliv">Категория проживания</label>
            <input type="text" class="form-control" name="catliv">
        </div>
        <input type="submit" value="Send review" class="btn btn-primary" name="sndbtn">
    </form>';
 
    } else {
    echo 'alert("Thanks for review")';
    $hotelid = trim(utf8_encode(htmlspecialchars($_POST["hoid"])));
    $title = trim(utf8_encode(htmlspecialchars($_GET['title'])));
    $score = trim(utf8_encode(htmlspecialchars($_GET['score'])));
    $positive = trim(utf8_encode(htmlspecialchars($_GET['positive'])));
    $negative = trim(utf8_encode(htmlspecialchars($_GET['negative'])));
    $catlive = trim(utf8_encode(htmlspecialchars($_GET['catlive'])));
    $timeliv = trim(utf8_encode(htmlspecialchars(strtotime($_GET['timeliv']))));
    $datereview = trim(utf8_encode(htmlspecialchars(strtotime(date("j.m.Y")))));
    
    $ins = "INSERT INTO comments (hotelid, userid, title, score, positive, negative, datereview, timeliv, catliv) VALUES ('$hotelid', '$userid', '$title', '$score', '$positive', '$negative', '$datereview', '$timeliv', '$catliv')";
    mysqli_query($link, $ins);
    
    $err = mysqli_errno($link);
    if($err) {
        echo "<h6 class='text-danger'>Error code ".$err."</h6>";   
    } else {
    echo "<h4 class='text-success'>Ваш комментарий добавлен, ".$_POST['user']."!</h4>";
    }
}
} else {
    echo "<h6 class='text-danger'>Чтобы оставить комментарий, вам необходимо зарегистрироваться!</h6>";
}
