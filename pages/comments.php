<h3>Comments</h3>
<?php
$link = connect();

if(isset($_SESSION['ruser']) || isset($_SESSION['radmin'])) {
    if(isset($_SESSION['ruser'])) { $user = $_SESSION['ruser']; }
    if(isset($_SESSION['radmin'])) { $user = $_SESSION['radmin']; }
    $user = strval($user);
    $resuserid = mysqli_query($link, 'SELECT id FROM `users` WHERE `login`="'.$user.'"');
    $rowuserid = mysqli_fetch_array($resuserid, MYSQLI_NUM);
    $userid = (int)$rowuserid[0];
    mysqli_free_result($resuserid);
} else { 
    $userid = 0;
}


echo '<div class="form-inline">';
echo '<select onchange="showCities(this.value)">';
echo '<option value="0">Select country...</option>';
$res = mysqli_query($link, 'SELECT * FROM countries ORDER BY country');
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';
mysqli_free_result($res);

echo '<select id="cityid" onchange="showHotels(this.value)">';
echo '<option value="0">Select city...</option>';
$res = mysqli_query($link, 'SELECT * FROM cities ORDER BY city');
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';
mysqli_free_result($res);



echo '<select id="hotelid" onchange="showComments(this.value); addNewComment(this.value, '.$userid.');">';
echo '<option value="0">Select hotel...</option>';
$res = mysqli_query($link, 'SELECT * FROM hotels ORDER BY hotel');
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';
mysqli_free_result($res);

echo '</div>';
echo '<div id="comments"></div>';
echo '<div id="comment"></div>';
?>
<script>
    function showCities(countryid) {
        const ao = new XMLHttpRequest();
        ao.open('GET', 'handlers/country_handler.php?coid=' + countryid, true);
        ao.send(null);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                document.querySelector('#cityid').innerHTML = ao.responseText;
            }
        }
    }

    function showHotels(cityid) {
        const ao = new XMLHttpRequest();
        ao.open('GET', 'handlers/city_forhotels.php?ciid=' + cityid, true);
        ao.send(null);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                document.querySelector('#hotelid').innerHTML = ao.responseText;
            }
        }
    }

    function showComments(hotelid) {
        const ao = new XMLHttpRequest();
        ao.open('POST', 'handlers/comments_handler.php', true);
        ao.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ao.send('hoid='+ hotelid);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                document.querySelector('#comments').innerHTML = ao.responseText;
            }
        }
    }

    function addNewComment(hotelid, userid) {
        const ao = new XMLHttpRequest();
        ao.open('POST', 'handlers/newcomment_handler.php', true);
        ao.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ao.send('hoid='+ hotelid +'&'+ 'usid=' + userid);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                document.querySelector('#comment').innerHTML = ao.responseText;
            }
        }
    }
</script>