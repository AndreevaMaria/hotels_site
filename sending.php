<?php
error_reporting(E_ALL);
include_once('pages/functions.php');
$link = connect();

if(isset($_POST['sendReview'])) {
    $hotelid = $_POST['hotelid'];
    $userid = $_POST['userid'];
    $title = trim($_POST['title']);
    $score = $_POST['score'];
    $positive = trim($_POST['positive']);
    $negative = trim($_POST['negative']);
    $catliv = trim($_POST['catliv']);
    $timeliv = date('Y.m.01', strtotime($_POST['timeliv']));
    $datereview = $_POST['datereview'];
        
    $ins = "INSERT INTO comments (hotelid, userid, title, score, positive, negative, datereview, timeliv, catliv) VALUES ('$hotelid', '$userid', '$title', '$score', '$positive', '$negative', '$datereview', '$timeliv', '$catliv')";
    mysqli_query($link, $ins);
        
    $err = mysqli_errno($link);
    if($err) {
        echo "<h6 class='text-danger'>Error code ".$err."</h6>";   
    } else {
        echo "<h4 class='text-success'>Ваш комментарий добавлен!</h4>";
    }
}
?>
<button onclick="myFunction()">GET BACK</button>

<script>
function myFunction() {
  location.replace("index.php?page=2")
}
</script>
