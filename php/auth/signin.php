<?php

    session_start();

    require_once $_SERVER["DOCUMENT_ROOT"]."/php/connect/connect.php";

    $login = $_POST["login"];
    $pass = $_POST["password"];

    $query = mysqli_query($connect, "SELECT * FROM `users` WHERE login = '$login' AND password = '$pass'");

    if(mysqli_num_rows($query) > 0){
        $user = mysqli_fetch_assoc($query);

        $_SESSION["user"] = [
            'login' => $login,
            'name' => $user["name"]
        ];
        header("Location: /");
    }else{
        header("Location: /");
    }

?>