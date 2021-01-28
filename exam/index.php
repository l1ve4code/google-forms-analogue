<?php include $_SERVER["DOCUMENT_ROOT"]."/php/classes/LabelClass.php"; ?>
<?php session_start(); ?>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/php/connect/connect.php"; ?>
<?php

    $query = mysqli_query($connect, "SELECT * FROM `url`");
    $data = [];
    $name = "";
    $datas = "";
    if(mysqli_num_rows($query) > 0){
        $array = mysqli_fetch_all($query);
        $url = $_GET["url"];
        for($i = 0; $i < count($array); $i++){
            $arr_from_db = unserialize(base64_decode($array[$i][2]));
            if(in_array($url, $arr_from_db)){
                $id = $array[$i][1];
                $form = mysqli_query($connect, "SELECT * FROM `session` WHERE id = '$id'");
                $form = mysqli_fetch_assoc($form);
                $data = unserialize(base64_decode($form["data"]));
                $name = $form["name"];
                break;
            }
        }
    }

?>
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

<div class = "container d-flex flex-column align-items-center justify-content-center">
    <h3 class = "text-center mt-3"><?=$name?></h3>
        <?php
            if($form["state"] == 1){
                echo '<form class = "w-50 mt-5" method = "post" action="/php/forming.php">';
                for($i = 0; $i < count($data); $i++){
                    switch ($data[$i]->getSubjectUUID()){
                        case "one":
                            echo '<div class="mb-4">
                                             <label for="exampleInputEmail1" class="form-label">'.$data[$i]->getSubjectName().'</label>
                                             <input type="number" class="form-control" placeholder="Введите число" id="exampleInputEmail1" aria-describedby="emailHelp" name = "input'.$i.'" required>
                                         </div>';
                            break;
                        case "two":
                            echo '<div class="mb-4">
                                             <label for="exampleInputEmail1" class="form-label">'.$data[$i]->getSubjectName().'</label>
                                             <input type="number" class="form-control" min = "0" placeholder="Введите положительное число" id="exampleInputEmail1" aria-describedby="emailHelp" name = "input'.$i.'" required>
                                         </div>';
                            break;
                        case "three":
                            echo '<div class="mb-4">
                                             <label for="exampleInputEmail1" class="form-label">'.$data[$i]->getSubjectName().'</label>
                                             <input type="text" class="form-control" minlength="1" maxlength="30" placeholder="Введите строку от 1 до 30 символов" id="exampleInputEmail1" aria-describedby="emailHelp" name = "input'.$i.'" required>
                                         </div>';
                            break;
                        case "four":
                            echo '<div class="mb-4">
                                             <label for="exampleInputEmail1" class="form-label">'.$data[$i]->getSubjectName().'</label>
                                             <textarea type="text" class="form-control" minlength="1" maxlength="255" id="exampleInputEmail1" aria-describedby="emailHelp" name = "input'.$i.'" required></textarea>
                                         </div>';
                            break;
                        case "five":
                            echo '<div class="mb-4">
                                             <label for="exampleInputEmail1" class="form-label">'.$data[$i]->getSubjectName().'</label>
                                             <select class = "form-select" name = "input'.$i.'" required>';
                            for($j = 0; $j < count($data[$i]->getSubjectData()); $j++){
                                echo '<option value="'.$data[$i]->getSubjectData()[$j]["data"].';'.$data[$i]->getSubjectData()[$j]["mark"].'">'.$data[$i]->getSubjectData()[$j]["data"].'</option>';
                            }
                            echo '</select>
                                         </div>';
                            break;
                        case "six":
                            echo '<div class="mb-4">
                                             <label for="exampleInputEmail1" class="form-label">'.$data[$i]->getSubjectName().'</label>
                                             <select class = "form-select" multiple="multiple" name = "input'.$i.'[]" required>';
                            for($j = 0; $j < count($data[$i]->getSubjectData()); $j++){
                                echo '<option value="'.$data[$i]->getSubjectData()[$j]["data"].';'.$data[$i]->getSubjectData()[$j]["mark"].'">'.$data[$i]->getSubjectData()[$j]["data"].'</option>';
                            }
                            echo '</select>
                                         </div>';
                            break;
                    }
                    $datas .= $data[$i]->getSubjectUUID().";";
                }
                echo '        <input type="hidden" name = "id" value="'.$id.'">
                                <input type="hidden" name = "url" value="'.$url.'">
                                <input type="hidden" name = "datas" value = "'.$datas.'">
                                <button type="submit" class="btn btn-primary mt-3">Ответить</button>
                            </form>';
            }else if($form["state"] == 0){
                echo '<h4>В данный момент сессия не доступна</h4>';
            }

        ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/php/pages/login_modal.php" ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>