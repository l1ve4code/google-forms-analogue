<?php
include $_SERVER["DOCUMENT_ROOT"] . "/php/classes/LabelClass.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/php/connect/connect.php";

$client  = $_SERVER['HTTP_CLIENT_IP'];
$forward = $_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = $_SERVER['REMOTE_ADDR'];

$answers = [];
$date = date('Y-m-d H:i:s');
$id = $_POST["id"];
$url = $_POST["url"];
$amount = mb_split(";", $_POST["datas"]);
unset($amount[count($amount) - 1]);

$form = mysqli_query($connect, "SELECT * FROM `session` WHERE id = '$id'");
$form = mysqli_fetch_assoc($form);
$data = unserialize(base64_decode($form["data"]));

$mark = null;

for($i = 0; $i < count($amount); $i++){
    array_push($answers, [
        "name" => $data[$i]->getSubjectName(),
        "answer" => $_POST["input".$i],
        "uuid" => $amount[$i]
    ]);
    if($amount[$i] == "five"){
        $_mark = mb_split(";", $_POST["input".$i])[1];
        if(is_null($mark)){
            $mark = $_mark;
        }else{
            $mark += $_mark;
        }
    }
    else if($amount[$i] == "six"){
        for($j = 0; $j < count($_POST["input".$i]); $j++){
            $_mark = mb_split(";", $_POST["input".$i][$j])[1];
            if(is_null($mark)){
                $mark = $_mark;
            }else{
                $mark += $_mark;
            }
        }
    }
}

if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
else $ip = $remote;

$user_data = [
    "ip" => $ip,
    "date" => $date
];

$user_data = base64_encode(serialize($user_data));

$answers = base64_encode(serialize($answers));

if(is_null($mark)){
    mysqli_query($connect, "INSERT INTO `answers` (`id`, `expert_data`, `test_data`, `mark`, `session_id`, `url`) VALUES (NULL, '$user_data', '$answers', '99999', '$id', '$url')");
}else{
    mysqli_query($connect, "INSERT INTO `answers` (`id`, `expert_data`, `test_data`, `mark`, `session_id`, `url`) VALUES (NULL, '$user_data', '$answers', '$mark', '$id', '$url')");
}


header("Location: /session");

?>