<?php $link = connect();?>
<div class="row">
   <div class="col-sm-12 col-md-6 left">
        <!----section A -countries---->
        <a class="btn" data-toggle="collapse" href="#blockA" role="button" aria-expanded="true" aria-controls="blockA">
        <h5>Moderating  COUNTRIES</h5></a>
        <div id="blockA" class="collapse show">
        <?php
        
        $sel = 'SELECT * FROM countries';
        $res = mysqli_query($link, $sel);

        echo "<form action='index.php?page=4' method='post' class='input-form mt-3' id='formcountry'>";
        
        echo "<input type='text' name='country' placeholder='Country' class='my-3'>";
        echo "<input type='submit' name='delcountry' value='Del Country' class='btn btn-sm btn-warning ml-2 mt-3 float-right'>";
        echo "<input type='submit' name='addcountry' value='Add Country' class='btn btn-sm btn-info ml-2 mt-3 float-right'>";

        echo "<br><div class='wndw'><table class='table table-sm table-striped'>";
        echo  '<thead><tr><th>ID</th><th>Country</th><th>Delete</th><th></th></tr></thead>';
        
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<tr id='$row[0]'>
                <td>$row[0]</td>
                <td>$row[1]</td>
                <td><input type='checkbox' name='cb$row[0]'></td>
                <td><form action='index.php?page=4' method='post'>
                        <input type='hidden' name='idco' value='$row[0]'>
                        <button type='submit' name='delitem'><i class='fa fa-trash-o' aria-hidden='true'></i></button>
                    </form>
                </td>
            </tr>";
        }
        echo "</table></div>";
        echo "</form>";
        mysqli_free_result($res);

        if(isset($_POST['delitem'])) {
            $idco = $_POST['idco'];
            $del = 'DELETE FROM countries WHERE id = '.$idco;
            mysqli_query($link, $del);
            echo '<script>window.location = document.URL</script>';
        }

        if(isset($_POST['addcountry'])) {
            $country = trim(htmlspecialchars($_POST['country']));
            if($country == "") exit;
            $ins = "INSERT INTO countries(country) VALUES('$country')";
            mysqli_query($link, $ins);
            echo '<script>window.location = document.URL</script>';
        }
            
        if(isset($_POST['delcountry'])) {
            foreach($_POST as $k => $v){
                if(substr($k, 0, 2) === 'cb') {
                    $idc = substr($k, 2);
                    $del = 'DELETE FROM countries WHERE id = '.$idc;
                    mysqli_query($link, $del);
                }
            }
            echo '<script>window.location = document.URL</script>';
        }
        ?>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 right">
        <!----section B -cities---->
        <a class="btn" data-toggle="collapse" href="#blockB" role="button" aria-expanded="true" aria-controls="blockB">
        <h5>Moderating  CITIES</h5></a>
        <div class="collapse show" id="blockB">
        <?php
        $res = mysqli_query($link, 'SELECT * FROM countries');
        echo "<form action='index.php?page=4' method='post' class='input-form' id='formcity'>";
        echo '<select name="countryname">';
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1]</option>";
        }
        echo "</select>";
        echo "<span class='ml-1 badge badge-secondary align-top'>From country</span>";
        echo "<br><input type='text' name='city' placeholder='City' class='mt-2 mb-3'>";
        echo "<input type='submit' name='delcity' value='Del City' class='btn btn-sm btn-warning ml-2 mt-2 float-right'>";
        echo "<input type='submit' name='addcity' value='Add City' class='btn btn-sm btn-info ml-2 mt-2 float-right'>";
        $res = mysqli_query($link, 'SELECT * FROM cities');
        echo "<br><div class='wndw'><table class='table table-sm table-striped'>";
        echo  '<thead><tr><th>ID</th><th>City</th><th>Delete</th><th></th></tr></thead>';
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<tr id='$row[0]'>
                <td>$row[0]</td>
                <td>$row[1]</td>
                <td><input type='checkbox' name='cbc$row[0]'></td>
                <td><form action='index.php?page=4' method='post'>
                        <input type='hidden' name='idco' value='$row[0]'>
                        <button type='submit' name='delitem'><i class='fa fa-trash-o' aria-hidden='true'></i></button>
                    </form>
                </td>
            </tr>";
        }
        echo "</div></table>";
        echo "</form>";
        mysqli_free_result($res);

        if(isset($_POST['addcity'])) {
            $city = trim(htmlspecialchars($_POST['city']));
            if($city == "") exit;
            $countryid = $_POST['countryname'];
            $ins = "INSERT INTO cities(city, countryid) VALUES('$city', '$countryid')";
            mysqli_query($link, $ins);
            
            if(mysqli_error($link)) {
                echo "Error text:". mysqli_error($link);
                exit;
            }
            echo '<script>window.location = document.URL</script>';
        }

        if(isset($_POST['delcity'])) {
            foreach($_POST as $k => $v){
                if(substr($k, 0, 3) === 'cbc') {
                    $idc = substr($k, 3);
                    var_dump($idc);
                    $delc = 'DELETE FROM cities WHERE id = '.$idc;
                    mysqli_query($link, $delc);
                }
            }
            echo '<script>window.location = document.URL</script>';
        }
        ?>
            </div>
        </div>
    </div>
</div>
    <hr>
<div class="row">
    <div class="col-sm-12 col-md-6 left">
        <!----section C -hotels---->
        <a class="btn" data-toggle="collapse" href="#blockC" role="button" aria-expanded="true" aria-controls="blockC">
        <h5>Moderating  HOTELS</h5></a>
        <div class="collapse show" id="blockC">
        <?php
        echo "<form action='index.php?page=4' method='post' class='input-form' id='formhotel'>";
        $sel = 'SELECT ci.id, ci.city, co.country, co.id FROM countries co, cities ci WHERE ci.countryid=co.id';
        $res = mysqli_query($link, $sel);

        $coid_array = array();

        echo "<select name='hcity'>";
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1] : $row[2]</option>";
            $coid_array[$row[0]] = $row[3];
        }
        echo "</select>";
        mysqli_free_result($res);

        echo "<span class='ml-1 badge badge-secondary align-top'>From city in country</span>";
        echo "<br><input type='text' name='hotel' placeholder='Hotel' class='my-2'>";
        echo "<input type='submit' name='delhotel' value='Del Hotel' class='btn btn-sm btn-warning ml-2 mt-2 float-right'>";
        echo "<input type='submit' name='addhotel' value='Add Hotel' class='btn btn-sm btn-info ml-2 mt-2 float-right'>";
        
        echo "<br><lable for='stars'>Stars: <input type='number' name='stars' id='stars' min='1' max='5'></lable>";
        echo "<input type='text' name='cost' placeholder='Cost' class='ml-2'>";
        echo "<br><textarea name='info' placeholder='Description of hotel'class='my-2'></textarea>";
        $res = mysqli_query($link, 'SELECT * FROM hotels');
        echo "<br><div class='wndw'><table class='table table-sm table-striped'>";
        echo  '<thead><tr><th>ID</th><th>Hotel</th><th>Delete</th><th></th></tr></thead>';
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<tr id='$row[0]'>
                <td>$row[0]</td>
                <td>$row[1]</td>
                <td><input type='checkbox' name='cbh$row[0]'></td>
                <td><form action='index.php?page=4' method='post'>
                        <input type='hidden' name='idco' value='$row[0]'>
                        <button type='submit' name='delitem'><i class='fa fa-trash-o' aria-hidden='true'></i></button>
                    </form>
                </td>
            </tr>";
        }
        echo "</div></table>";
        echo "</form>";
        mysqli_free_result($res);

        if(isset($_POST['addhotel'])) {
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            $cost = intval(trim(htmlspecialchars($_POST['cost'])));
            $stars = intval($_POST['stars']);
            $info = trim(htmlspecialchars($_POST['info']));
            if($hotel == "" || $cost == "" || $info == "") exit;
            $cityid = $_POST['hcity'];
            $countryid = $coid_array[$cityid];
            $ins = "INSERT INTO hotels(hotel, cityid, countryid, stars, cost, info) VALUES('$hotel', '$cityid', '$countryid', '$stars', '$cost', '$info')";
            mysqli_query($link, $ins);
            
            if(mysqli_error($link)) {
                echo "Error text:". mysqli_error($link);
                exit;
            }
            echo '<script>window.location = document.URL</script>';
        }
        if(isset($_POST['delhotel'])) {
            foreach($_POST as $k => $v){
                if(substr($k, 0, 3) === 'cbh') {
                    $idc = substr($k, 3);
                    $delh = 'DELETE FROM hotels WHERE id = '.$idc;
                    mysqli_query($link, $delh);
                }
            }
            echo '<script>window.location = document.URL</script>';
        }
        ?>
        </div>
    </div>
    </div>
    <div class="col-sm-12 col-md-6 right">
        <!----section D -images---->
        <a class="btn" data-toggle="collapse" href="#blockD" role="button" aria-expanded="true" aria-controls="blockD">
        <h5>Moderating  IMAGES</h5></a>
        <div class="collapse show" id="blockD">
        <?php
        echo "<form action='index.php?page=4' method='post' enctype='multipart/form-data' class='input-form'>";
        $sel = 'SELECT ho.id, co.country, ci.city, ho.hotel FROM countries co, cities ci, hotels ho WHERE ho.countryid=co.id AND ho.cityid=ci.id';
        $res = mysqli_query($link, $sel);

        echo "<select name='hotelid'>";
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1] : $row[2] : $row[3]</option>";
        }
        echo "</select>";
        mysqli_free_result($res);

        echo "<span class='ml-1 badge badge-secondary align-top'>Of hotel from city in country</span>";
        echo "<br><input type='file' name='file[]' multiple  accept='image/*' id='addimg' class='my-2'>";
        echo "<input type='submit' name='addimage' value='Add Image' class='btn btn-sm btn-info ml-2 mt-2 float-right'>";
        
        echo "<div id='mypreview'></div>";
        echo "</form>";
    ?>
     <script>
    var preview = (function () {
        var reader = new FileReader,
        i = 0,
        files, file;
    
        reader.addEventListener("load", function(e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            document.getElementById('mypreview').appendChild(img);
            $("img").addClass("image");
            
            file = files[++i];
            if (file) {
                reader.readAsDataURL(file)
            } else { i = 0 }
        })
    
        return function (e) {
            files = e.target.files;
            file = files[i];
            if (files) {
                while (i < files.length && !file.type.match('image.*')) {
                    file = files[++i];
                }
            if (file) reader.readAsDataURL(files[i])
            }
        }
    })()
 
    document.getElementById('addimg').addEventListener('change', preview, false);
    </script>
    <?php
        if(isset($_POST['addimage'])) {
            //перебираем все загруженные через форму картинки отелей
            foreach($_FILES['file']['name'] as $k =>  $v) {
                //проверяем, произошла ли ошибка при загрузке какого-нибудь из множества файлов
                if($_FILES['file']['error'][$k] != 0) {
                    echo "<script>alert('Upload file error: $v')</script>";
                    continue;
                }
                if(move_uploaded_file($_FILES['file']['tmp_name'][$k], 'images/'.$v)) {
                    $ins = 'INSERT INTO images(hotelid, imagepath) VALUES('.$_POST['hotelid'].', "images/'.$v.'")';
                    mysqli_query($link, $ins);
                }
            }
        }
        ?>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        var scr = $(".wndw");
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
