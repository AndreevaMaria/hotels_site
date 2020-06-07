<h2>Select Tours</h2>
<hr>
<?php
$link = connect();
//ajax!!!
echo '<div class="form-inline">';

echo '<select onchange="showCities(this.value)">';
echo '<option value="0">Select country...</option>';
$res = mysqli_query($link, 'SELECT * FROM countries ORDER BY country');
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';
mysqli_free_result($res);

echo '<select id="cityid" onchange="showHotels(this.value)">
    </select>';
echo '</div>';
echo '<div id="hotels"></div>';
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
        ao.open('POST', 'handlers/cities_handler.php', true);
        ao.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ao.send('ciid='+ cityid);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                document.querySelector('#hotels').innerHTML = ao.responseText;
            }
        }
    }
</script>