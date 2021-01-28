<?php

include $_SERVER["DOCUMENT_ROOT"]."/php/classes/LabelClass.php";
session_start();

require_once $_SERVER["DOCUMENT_ROOT"]."/php/connect/connect.php";

$name = $_POST["data"];

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

$array = base64_encode(serialize($_SESSION["labels"]["data"]));

mysqli_query($connect, "INSERT INTO `session` (`id`, `name`, `data`, `state`) VALUES (NULL, '$name', '$array', 1)");

$id_query = mysqli_query($connect, "SELECT * FROM `session`");


$arr = mysqli_fetch_all($id_query);
$id = $arr[count($arr)-1][0];

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

$urls = [];
array_push($urls, generate_string($permitted_chars, 20));
array_push($urls, generate_string($permitted_chars, 18));
array_push($urls, generate_string($permitted_chars, 10));

$_SESSION["urls"] = $urls;

$urls = base64_encode(serialize($urls));

mysqli_query($connect, "INSERT INTO `url` (`id`, `session_id`, `url_array`) VALUES (NULL, '$id', '$urls')");

unset($_SESSION["labels"]);

header("Location: /urls");

?>