<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/php/connect/connect.php";
$id = $_GET["id"];

mysqli_query($connect, "UPDATE `session` SET state=1 WHERE id = '$id'");

header("Location: /session");

?>