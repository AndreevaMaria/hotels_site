<?php
error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

if($_POST['usid'] != 0) {
    $selhotel = 'SELECT hotel FROM hotels WHERE id='.$_POST['hoid'];
    $reshotel = mysqli_query($link, $selhotel);
    $rowhotel = mysqli_fetch_array($reshotel, MYSQLI_NUM);
    $hotel = $rowhotel[0];
    mysqli_free_result($reshotel); 

    $resuser = mysqli_query($link, 'SELECT `login` FROM users WHERE id='.$_POST['usid']);
    $rowuserid = mysqli_fetch_array($resuser, MYSQLI_NUM);
    $user = $rowuser[0];
    echo $user;
    mysqli_free_result($resuser);
    
    echo "<h5>".$user.", разместите свой отзыв о проживании в отеле $hotel</h5>";
    
    echo '<form action="handlers/form_handler.php" method="post" class="input-form">
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
        <input type="hidden" name="hotelid" value="'.$_POST['hoid'].'">
        <input type="hidden" name="userid" value="'.$_POST['usid'].'">
        <input type="submit" value="Send review" class="btn btn-primary" name="sndbtn">
    </form>';
} else {
    echo "<h6 class='text-danger'>Чтобы оставить комментарий, вам необходимо зарегистрироваться!</h6>";
}