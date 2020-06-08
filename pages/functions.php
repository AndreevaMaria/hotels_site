<?php 
function connect($host="127.0.0.1:3306", $user="root", $pass="123456", $dbname="travels") {
    $link = mysqli_connect($host, $user, $pass, $dbname);
    echo "<div class='row'> <div class='col-12 text-muted font-italic mb-3'>";
    if(!$link) {
        echo "Ошибка: невозможно установить соединение с MySQL";
        echo "Код ошибки errno: " . mysqli_connect_errno();
        echo "Текст ошибки errno: " . mysqli_connect_error();
        exit;
    }
    if(!mysqli_set_charset($link, "utf8")) {
        echo "Ошибка при загрузке кодировки символов utf8: " . mysqli_error($link);
        exit;
    }
    //echo "<div class='badge badge-success'>Connection successful</div>";
    echo "</div></div>";
    return $link;
}

function register($name, $pass, $email) {
    $name = trim(utf8_encode(htmlspecialchars($name)));
    $pass = trim(utf8_encode(htmlspecialchars($pass)));
    $email = trim(utf8_encode(htmlspecialchars($email)));

    if ($name == "" || $pass == "" || $email == "") {
        echo "<h3 class='text-danger'>Заполните все поля</h3>";
        return false;
    }
    
    if(strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3 class='text-danger'>От 0 до 30 символов</h3>";
        return false;
    }

    $pass = password_hash($pass, PASSWORD_BCRYPT);

    $ins = "INSERT INTO users(login, pass, email, roleid) VALUES('$name', '$pass', '$email', 2)";
    $link = connect();
    mysqli_query($link, $ins);

    $err = mysqli_errno($link);

    if($err) {
        if($err == 1062) {
            echo "<h3 class='text-danger'>Пользователь с таким именем уже зарегистрирован!</h3>";
            return false;
        } else {
            echo "<h3 class='text-danger'>Error code ".$err."</h3>";
            return false;
        }
    }

    return true;

}
function login($login, $pass) {
    $name = trim(utf8_encode(htmlspecialchars($login)));
    $pass = trim(utf8_encode(htmlspecialchars($pass)));

    if ($name == "" || $pass == "") {
        echo "<h3 class='text-danger'>Заполните все поля</h3>";
        return false;
    }
    
    if(strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3 class='text-danger'>От 0 до 30 символов</h3>";
        return false;
    }

    $sel = "SELECT login, pass, roleid FROM users WHERE login='$name'";
    $link = connect();
    $res = mysqli_query($link, $sel);

    while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        if($name == $row[0] && password_verify($pass, $row[1])) {
            $_SESSION['ruser'] = $name;
            if($row[2] == 1) { 
                $_SESSION['radmin'] = $name; 
            } 
            return true;
        } else {
            return false;
        } 
    }
}