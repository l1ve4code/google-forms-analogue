<?php session_start(); ?>
<?php if(!isset($_SESSION["user"])) header("Location: /"); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Экзамен</title>
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/php/pages/header.php" ?>

<div class = "container d-flex flex-column mt-5">
    <h3>Ссылки на экспертную сессию</h3>
    <?php

    if(isset($_SESSION["urls"])){
        for($i=0; $i < count($_SESSION["urls"]); $i++){
            echo '<a class = "mt-5" href="/exam/?url='.$_SESSION["urls"][$i].'">Ссылка №'.($i+1).'</a>';
        }
    }

    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/php/pages/login_modal.php" ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>