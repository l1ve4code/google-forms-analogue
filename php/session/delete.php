<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/php/connect/connect.php";
$id = $_GET["id"];

mysqli_query($connect, "DELETE FROM `session` WHERE id = '$id'");

header("Location: /session");

?>