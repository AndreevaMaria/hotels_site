<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Hotel info</title>
</head>
<style>
  body {
    overflow-x: hidden;
  }

  .container {
    margin: 0;
  }
    .star {
      max-width: 40px;
    }

    .carousel-inner {
        width: 80%;
        height: auto;
    }
    
    .carousel-item img {
      width: auto;
      height: 60vh;
      margin-left: auto;
      margin-right: auto;
      align-items: center;
    }

    .img-fluid{
      height: 100px !important;
      max-width: 200px !important;
    }
    
    .list-inline {
        white-space: nowrap;
        overflow-x: auto;
    }
    
    .carousel-indicators {
        position: static;
        min-height: 124px;
        width: 90vw;
        margin-left: auto;
        margin-right: auto;
    }
    
    .carousel-indicators > li {
        width: 200px;
    }

    .carousel-indicators li img {
      display: block;
      opacity: 0.7;
    }

    .carousel-indicators li.active img {
      opacity: 1;
    }
    
    .carousel-indicators li:hover img {
      opacity: 0.9;
    }

    .carousel-control-prev-icon {
     background-image: url("../images/arrow-left.png");
    }
    
    .carousel-control-next-icon {
      background-image: url("../images/arrow-right.png");
    }
    .comments-block {
    height: 30vh;
    overflow-y: scroll;
    cursor: grab;
    } 
    .comment {
      width: 100%;

    }
</style>
<body>
<?php
include_once("functions.php");
$link = connect();

if(isset($_GET['hotel'])) {
    $ho_id = $_GET['hotel'];
    $sel = 'SELECT * FROM hotels WHERE id='.$ho_id;
    $res = mysqli_query($link, $sel);
    $row = mysqli_fetch_array($res, MYSQLI_NUM);
    $ho_name = $row[1];
    $ho_stars = $row[4];
    $ho_cost = $row[5];
    $ho_info = $row[6];
    mysqli_free_result($res);

    echo '<div class="container row">';
    echo '<div class="col-4">';
    echo "<h1 class='text-uppercase ml-2'>$ho_name</h1>
    <span>";
    for($i=0; $i<$ho_stars; $i++) {
      echo '<img src="../images/star.png" alt="star" class="star">';
  }
    echo '</span><p class="lead ml-2 mt-2">Info: '.$ho_info.'</p>';
    echo '</div>';
    echo '<div class="col-8">';
    echo '<div class="comments-block">';
    echo "<div class='card comment p-2'>";

    $sel = 'SELECT hotelid, userid, title, score, positive, negative, DATE_FORMAT(datereview, "%e %M %Y"), DATE_FORMAT(timeliv, "%M %Y"), catliv FROM comments WHERE hotelid='.$ho_id;
    $res = mysqli_query($link, $sel);
    while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        $seluser = 'SELECT login FROM users WHERE id='.$row[1];
        $resuser = mysqli_query($link, $seluser);
        $rowuser = mysqli_fetch_array($resuser, MYSQLI_NUM);
              echo "<div class='card-header'>$rowuser[0]</div>";
        mysqli_free_result($resuser);  
        echo "<div class='card-body'>
              <h4 class='card-title'>$row[2]</h4>
              <span class='score'>$row[3]</span>
              <span class='datereview'>$row[6]</span>
              <div class='card-text positive'>$row[4]</div>
              <div class='card-text negative'>$row[5]</div>
              <span class='timeliv'>$row[7]</span>
              <span class='catliv'>$row[8]</span>
              </div>";     
    }
    mysqli_free_result($res);
    echo '</div>';
    echo '</div></div>';

    echo '<div class="col-12">';
    echo '<p class="lead ml-2">Watch  our pictures</p>';
    $sel = 'SELECT imagepath FROM images WHERE hotelid='.$ho_id;
    $result = mysqli_query($link, $sel);
    $i = 0;
    echo '<div id="gallery" class="carousel slide mt-3" data-ride="carousel" align="center">
            <div class="carousel-inner">';
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      if ($i==0){$active=' active'; } else {$active='';};
      echo '<div id="'.$i.'" class="carousel-item'.$active.'">';
      echo "<img src='../$row[0]' alt='hotel picture'></div>";
      $i++;
    }
    echo '</div>';
    mysqli_free_result($result);
    echo '<a class="carousel-control-prev arrow-zone" href="#gallery" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span></a>
          <a class="carousel-control-next arrow-zone" href="#gallery" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span></a>';
    echo '<ol class="carousel-indicators list-inline mt-4 py-2">';
    $sel = 'SELECT imagepath FROM images WHERE hotelid='.$ho_id;
    $result = mysqli_query($link, $sel);
    $i = 0;
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      if ($i==0){$active=' active'; } else {$active='';};
      echo '<li class="list-inline-item'.$active.'">
              <a id="carousel-selector-'.$i.'" class="selected" data-slide-to="'.$i.'" data-target="#gallery">
                <img src="../'.$row[0].'" alt="mini pic" class="img-fluid"></a>
            </li>';
      $i++;
    }
    echo '</ol></div></div></div>';
    echo '</section>';
    mysqli_free_result($result);
}
?>
<script>
    window.onload = function () {
        var scr = $(".comments-block");
        scr.mousedown(function(){
            var startX = this.scrollLeft + event.pageX;
            var startY = this.scrollTop + event.pageY;
  
            scr.mousemove(function(){
                this.scrollLeft = startX - event.pageX;
                this.scrollTop = startY - event.pageY;
                return false;
            });
        });
        $(window).mouseup(function(){
            scr.off("mousemove");
        });
}
</script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>
</html>