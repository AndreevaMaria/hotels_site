<?php
error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

if($_POST['user'] != "undefined") {
    $hotelid = $_POST['hoid'];
    $datereview = strtotime(date("j.m.Y"));

    $seluserid = 'SELECT id FROM users WHERE login='.$_POST['user'];
    $resuserid = mysqli_query($link, $seluserid);
    $rowuserid = mysqli_fetch_array($resuserid, MYSQLI_NUM);
    $userid = $rowuserid[0];
    mysqli_free_result($resuserid);

    $selhotel = 'SELECT hotel FROM hotels WHERE id='.$hotelid;
    $reshotel = mysqli_query($link, $selhotel);
    $rowhotel = mysqli_fetch_array($reshotel, MYSQLI_NUM);
    $hotel = $rowhotel[0];
    mysqli_free_result($reshotel); 

    echo "<h5>$_POST['user'], разместите свой отзыв о проживании в отеле $hotel</h5>";
            
    if(!isset($_POST['sendcomm'])) {    
?>
    <form action="index.php?page=2" method="post" class="input-form">
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
        <input type="submit" value="Send comment" class="btn btn-primary" name="sendcomm">
    </form>
<?php
    } else { 
        if(comment($hotelid, $userid, $_POST['title'], $_POST['score'], $_POST['positive'], $_POST['negative'], $datereview, $_POST['timeliv'], $_POST['catliv'])) {
            echo "<h4 class='text-success'>Ваш комментарий добавлен, ".$_POST['user']."!</h4>";
        }
    }
} else {
    echo "<h6 class='text-danger'>Чтобы оставить комментарий, вам необходимо зарегистрироваться!</h6>";
} 
