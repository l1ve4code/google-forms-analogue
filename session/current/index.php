<?php include $_SERVER["DOCUMENT_ROOT"] . "/php/classes/LabelClass.php"; ?>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/php/classes/DiagrammClass.php"; ?>
<?php if(!isset($_GET["id"]) || $_GET["id"] == "") header("Location: /session"); ?>
<?php session_start(); ?>
<?php if(!isset($_SESSION["user"])) header("Location: /"); ?>
<?php if(isset($_SESSION["labels"])) unset($_SESSION["labels"]); ?>
<?php if(isset($_SESSION["urls"])) unset($_SESSION["urls"]); ?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/php/connect/connect.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>Протокол</title>
</head>
<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT']."/php/pages/header.php" ?>
    <?php
        $all_marks = [];
        $id = $_GET["id"];
        $session = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `session` WHERE id = '$id'"));
        $experts = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `answers` WHERE session_id = '$id'"));
        $urls = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `url` WHERE session_id = '$id'"))["url_array"];

        $urls = unserialize(base64_decode($urls));

        $form = unserialize(base64_decode($session["data"]));
    ?>
    <h6 class = "mt-3">Общие данные</h6>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Эксперт</th>
            <?php
                for($i = 0; $i < count($form); $i++){
                    echo '<th scope="col">'.$form[$i]->getSubjectName().'</th>';
                }
            ?>
            <th scope="col">Суммарный балл</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if(count($experts) > 0){
                for($i = 0; $i < count($experts); $i++){
                    $mark = null;
                    $expert = $experts[$i];
                    $expert_data = unserialize(base64_decode($experts[$i][1]));
                    $test_data = unserialize(base64_decode($experts[$i][2]));
                    echo '<tr>
                        <th scope="row">'.($i+1).'</th>
                        <td><b>IP:</b> '.$expert_data["ip"].' <b>Дата/ Время:</b> '.$expert_data["date"].'</td>';
                    for($j = 0; $j < count($test_data); $j++){
                        if($test_data[$j]["uuid"] != "five" && $test_data[$j]["uuid"] != "six"){
                            echo '<td><b>Ответ: </b>'.$test_data[$j]["answer"].'</td>';
                        }
                        else if($test_data[$j]["uuid"] == "five"){
                            $ans = mb_split(";", $test_data[$j]["answer"])[0];
                            $mar = mb_split(";", $test_data[$j]["answer"])[1];
                            if(is_null($mark)){
                                $mark = $mar;
                            }else{
                                $mark += $mar;
                            }
                            echo '<td><b>Ответ: </b>'.$ans.'<b>. Полученный балл: </b>'.$mar.'</td>';
                        }
                        else if($test_data[$j]["uuid"] == "six"){
                            $array = $test_data[$j]["answer"];
                            echo "<td>";
                            for($k = 0; $k < count($array); $k++){
                                $ans = mb_split(";", $array[$k])[0];
                                $mar = mb_split(";", $array[$k])[1];
                                if(is_null($mark)){
                                    $mark = $mar;
                                }else{
                                    $mark += $mar;
                                }
                                echo '<b>Ответ: </b>'.$ans.'<b>. Полученный балл: </b>'.$mar.'<br>';
                            }
                            echo "</td>";
                        }
                    }
                    if(!is_null($mark)){
                        echo '<td>'.$mark.'</td>';
                        array_push($all_marks, $mark);
                    }else{
                        echo '<td>Полей с баллами не найдено!</td>';
                    }
                    echo '</tr>';
                }
            }
        ?>
        </tbody>
    </table>
    <h4 class = "text-center">Данные по ссылкам</h4>
    <?php
        for($b = 0; $b < count($urls); $b++){

            echo '<h6 class = "text-success mt-3"><b>ID ссылки:</b> '.$urls[$b].'</h6>';
            echo '<table class="table alert alert-warning">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Эксперт</th>';
                for($i = 0; $i < count($form); $i++){
                    echo '<th scope="col">'.$form[$i]->getSubjectName().'</th>';
                }
    echo '<th scope="col">Суммарный балл</th>
    </tr>
    </thead>
    <tbody>';
    if(count($experts) > 0){
        for($i = 0; $i < count($experts); $i++){
            if($experts[$i][5] == $urls[$b]){
            $mark = null;
            $expert = $experts[$i];
            $expert_data = unserialize(base64_decode($experts[$i][1]));
            $test_data = unserialize(base64_decode($experts[$i][2]));
            echo '<tr>
                        <th scope="row">'.($i+1).'</th>
                        <td><b>IP:</b> '.$expert_data["ip"].' <b>Дата/ Время:</b> '.$expert_data["date"].'</td>';
            for($j = 0; $j < count($test_data); $j++){
                if($test_data[$j]["uuid"] != "five" && $test_data[$j]["uuid"] != "six"){
                    echo '<td><b>Ответ: </b>'.$test_data[$j]["answer"].'</td>';
                }
                else if($test_data[$j]["uuid"] == "five"){
                    $ans = mb_split(";", $test_data[$j]["answer"])[0];
                    $mar = mb_split(";", $test_data[$j]["answer"])[1];
                    if(is_null($mark)){
                        $mark = $mar;
                    }else{
                        $mark += $mar;
                    }
                    echo '<td><b>Ответ: </b>'.$ans.'<b>. Полученный балл: </b>'.$mar.'</td>';
                }
                else if($test_data[$j]["uuid"] == "six"){
                    $array = $test_data[$j]["answer"];
                    echo "<td>";
                    for($k = 0; $k < count($array); $k++){
                        $ans = mb_split(";", $array[$k])[0];
                        $mar = mb_split(";", $array[$k])[1];
                        if(is_null($mark)){
                            $mark = $mar;
                        }else{
                            $mark += $mar;
                        }
                        echo '<b>Ответ: </b>'.$ans.'<b>. Полученный балл: </b>'.$mar.'<br>';
                    }
                    echo "</td>";
                }
            }
            if(!is_null($mark)){
                echo '<td>'.$mark.'</td>';
                array_push($all_marks, $mark);
            }else{
                echo '<td>Полей с баллами не найдено!</td>';
            }
            echo '</tr>';
        }
        }
    }
    echo '</tbody>
    </table>';
        }
        echo "<div class = 'd-flex align-items-center justify-content-center'>";
        for($i=0; $i < count($urls); $i++){
            echo '<a class = "me-3 btn btn-primary" href="/exam/?url='.$urls[$i].'">Ссылка №'.($i+1).'</a>';
        }
        echo "</div>";
    ?>

    <?php

        if(count($all_marks) > 0){
            echo '<div class = "container mt-3 alert alert-warning">';
            $average = array_sum($all_marks) / count(array_filter($all_marks));
            echo '<h5 class = "text-center">Средний балл по экспертной сессии: '.$average.'</h5>';
            echo '</div>';
        }

    ?>
    <div class = "container mt-3 d-flex flex-column align-items-center justify-content-center">
    <?php
        if(count($experts) > 0 && !is_null($mark)){
            $data = [];
            $naming = [];
            for($i = 0; $i < count($experts); $i++){
                $expert = $experts[$i];
                $test_data = unserialize(base64_decode($experts[$i][2]));
                for($j = 0; $j < count($test_data); $j++){
                    if($test_data[$j]["uuid"] == "five"){
                        if(!array_key_exists($test_data[$j]["name"], $data)){
                            array_push($data, [
                                    "id" => $test_data[$j]['name'],
                                    "number" => mb_split(";", $test_data[$j]['answer'])[1]
                            ]);
                        }
                    }
                    if($test_data[$j]["uuid"] == "six"){
                        if(!array_key_exists($test_data[$j]["name"], $data)){
                            for($k = 0; $k < count($test_data[$j]['answer']); $k++){
                                array_push($data, [
                                    "id" => $test_data[$j]['name'],
                                    "number" => mb_split(";", $test_data[$j]['answer'][$k])[1]
                                ]);
                            }
                        }
                    }
                }
            }
            for($i = 0; $i < count($form); $i++){
                if($form[$i]->getSubjectUUID() == "five" || $form[$i]->getSubjectUUID() == "six"){
                    array_push($naming, $form[$i]->getSubjectName());
                }
            }

            $arr = array ();
            for($i = 0; $i < count($naming); $i++){
                $average = 0;
                $number = 0;
                for($j = 0; $j < count($data); $j++){
                    if($naming[$i] == $data[$j]["id"]){
                        $average += $data[$j]["number"];
                        $number++;
                    }
                }
                $arr[$naming[$i]] = ($average/$number);
            }
            $plot = new SimplePlot($arr);
            $plot->show();
    }
    ?>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT']."/php/pages/login_modal.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>