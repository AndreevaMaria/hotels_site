<ul class="nav nav-pills justify-content-around py-2">
    <li><a href="index.php?page=1">Tours</a></li>
    <li><a href="index.php?page=2">Comments</a></li>
    <li><a href="index.php?page=3">Registration</a></li>
    <li><a href="index.php?page=4">Admin Forms</a></li>
    <?php
    if(isset($_SESSION['radmin'])) {
        echo '<li><a href="index.php?page=5">Private Page</a></li>';
    }
    ?>
</ul>