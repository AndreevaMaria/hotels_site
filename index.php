<?php 
error_reporting(E_ALL) ;
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours site</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <header class="col-12">
                <?php include_once("pages/functions.php");?>
                <?php include_once("pages/login.php");?>
            </header>
        </div>
        <div class="row">
            <nav class="col-12">
                <?php include_once("pages/menu.php"); ?>
            </nav>
        </div>
        <div class="row">
            <section class="col-12">
            <?php
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
                if($page == 1) include_once('pages/tours.php');
                if($page == 2) include_once('pages/comments.php');
                if($page == 3) include_once('pages/registration.php');
                if($page == 4) include_once('pages/admin.php');
                if($page == 5 && isset($_SESSION['radmin'])) {
                    include_once('pages/private.php');}
            }
            ?>
            </section>
        </div>
        <footer class="row">Step Academy &copy; 2020</footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>