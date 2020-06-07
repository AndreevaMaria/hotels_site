<h3>Private page</h3>
<?php
$link = connect();
echo '<form action="" method="post" enctype="multipart/form-data" class="input-group">';
$sel = 'SELECT * FROM users WHERE roleid=2 ORDER BY login';
$res = mysqli_query($link, $sel);
echo '<select name="userid">';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';
echo '<input type="file" name="file" accept="image/*">';
echo '<input type="submit" name="addadmin" value="Make admin" class="btn btn-sm btn-primary">';
mysqli_free_result($res);
echo '</form>';

if(isset($_POST['addadmin'])) {
    $fn = $_FILES['file']['tmp_name'];
    $file = fopen($fn, 'rb'); // открытие картинки на побайтовое чтение
    $img = fread($file, filesize($fn));
    fclose($file);

    //функция для безопасности загрузки картинки в бд
    $img = addslashes($img);

    $upd = "UPDATE users SET avatar='$img', roleid=1 WHERE id=".$_POST['userid'];
    $res = mysqli_query($link, $upd);
}

//вывод всех админов с аватарками
$sel = 'SELECT * FROM users WHERE roleid=1 ORDER BY login';
$res = mysqli_query($link, $sel);
echo '<table class="table table-striped mt-2">';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<tr>
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[3]</td>";
        $img = base64_encode($row[6]);
        echo "<td><img src='data:image/*; base64, $img' style='width:100px;'> </td>";
    echo "</tr>";
}
mysqli_free_result($res);
echo '</table>';
?>