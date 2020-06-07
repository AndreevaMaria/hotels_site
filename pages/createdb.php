<?php
error_reporting(E_ALL);
include_once("functions.php");

$link = connect();

$ct1 = 'CREATE TABLE countries(
    id int not null auto_increment primary key,
    country varchar(64) unique
)default charset="utf8"';

$ct2 = 'CREATE TABLE cities(
    id int not null auto_increment primary key,
    city varchar(64),
    countryid int,
    foreign key(countryid) references countries(id) on delete cascade,
    ucity varchar(128),
    unique index ucity(city, countryid)
)default charset="utf8"';

$ct3 = 'CREATE TABLE hotels(
    id int not null auto_increment primary key,
    hotel varchar(64),
    cityid int,
    foreign key(cityid) references cities(id) on delete cascade,
    countryid int,
    foreign key(countryid) references countries(id) on delete cascade,
    stars int,
    cost int,
    info varchar(1024)
)default charset="utf8"';

$ct4 = 'CREATE TABLE images(
    id int not null auto_increment primary key,
    imagepath varchar(1024),
    hotelid int,
    foreign key(hotelid) references cities(id) on delete cascade
)default charset="utf8"';

$ct5 = 'CREATE TABLE roles(
    id int not null auto_increment primary key,
    role varchar(32)
)default charset="utf8"';

$ct6 = 'CREATE TABLE users(
    id int not null auto_increment primary key,
    login varchar(64) unique,
    pass varchar(128),
    email varchar(128),
    roleid int,
    foreign key(roleid) references roles(id) on delete cascade,
    discount int,
    avatar mediumblob
)default charset="utf8"';

$ct7 = 'CREATE TABLE comments(
    id int not null auto_increment primary key,
    hotelid int,
    foreign key(hotelid) references hotels(id) on delete cascade,
    userid int,
    foreign key(userid) references users(id) on delete cascade,
    title varchar(32),
    score int,
    positive varchar(1024),
    negative varchar(1024),
    datereview timestamp,
    timeliv timestamp,
    catliv varchar(128)
)default charset="utf8"';

mysqli_query($link, $ct1);
if(mysqli_errno($link)) {
    echo "Error code 1 " . mysqli_errno($link) . "<br>";
    exit;
}
mysqli_query($link, $ct2);
if(mysqli_errno($link)) {
    echo "Error code 2 " . mysqli_errno($link) . "<br>";
    exit;
}
mysqli_query($link, $ct3);
if(mysqli_errno($link)) {
    echo "Error code 3 " . mysqli_errno($link) . "<br>";
    exit;
}
mysqli_query($link, $ct4);
if(mysqli_errno($link)) {
    echo "Error code 4 " . mysqli_errno($link) . "<br>";
    exit;
}
mysqli_query($link, $ct5);
if(mysqli_errno($link)) {
    echo "Error code 5 " . mysqli_errno($link) . "<br>";
    exit;
}
mysqli_query($link, $ct6);
if(mysqli_errno($link)) {
    echo "Error code 6 " . mysqli_errno($link) . "<br>";
    exit;
}
mysqli_query($link, $ct7);
if(mysqli_errno($link)) {
    echo "Error code 7 " . mysqli_errno($link) . "<br>";
    exit;
}
?>