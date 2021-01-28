<?php session_start(); ?>
<?php if(!isset($_SESSION["user"])) header("Location: /"); ?>
<?php

    class simpleLabel{

        private $name;
        private $uuid;

        public function __construct($name, $uuid)
        {
            $this->name = $name;
            $this->uuid = $uuid;
        }

        public function getSubjectName(){
            return $this->name;
        }
        public function getSubjectUUID(){
            return $this->uuid;
        }
        public function getNameOfClass(){
            return static::class;
        }

    }

    class hardLabel extends simpleLabel{

        private $data_array = [];

        public function __construct($name, $uuid, $data_array)
        {
            parent::__construct($name, $uuid);
            $this->data_array = $data_array;
        }

        public function getSubjectData(){
            return $this->data_array;
        }

    }

    if(isset($_POST["type"])){

        if(!isset($_SESSION["labels"])){
            $_SESSION["labels"]["data"] = [];
            $_SESSION["labels"]["id"] = 0;
        }

        if($_POST["type"] == "solo"){
            if(!isset($_SESSION["labels"]["solo"])){
                $_SESSION["labels"]["solo"] = [];
            }
            array_push($_SESSION["labels"]["solo"], [
                'data' => $_POST["data"],
                'mark' => $_POST["mark"]
            ]);
        }
        else if($_POST["type"] == "multi"){
            if(!isset($_SESSION["labels"]["multi"])){
                $_SESSION["labels"]["multi"] = [];
            }
            array_push($_SESSION["labels"]["multi"], [
                'data' => $_POST["data"],
                'mark' => $_POST["mark"]
            ]);
        }
        else if($_POST["type"] != "five" && $_POST["type"] != "six"){
            array_push($_SESSION["labels"]["data"], new simpleLabel($_POST["text"], $_POST["type"]));
            $_SESSION["labels"]["id"]++;
        }
        else if($_POST["type"] == "five"){
            if(isset($_SESSION["labels"]["solo"]) && count($_SESSION["labels"]["solo"]) >= 2){
                array_push($_SESSION["labels"]["data"], new hardLabel($_POST["text"], $_POST["type"], $_SESSION["labels"]["solo"]));
                unset($_SESSION["labels"]["solo"]);
                $_SESSION["labels"]["id"]++;
            }
            else{
                header("Location: .");
            }
        }
        else if($_POST["type"] == "six"){
            if(isset($_SESSION["labels"]["multi"]) && count($_SESSION["labels"]["multi"]) >= 3){
                array_push($_SESSION["labels"]["data"], new hardLabel($_POST["text"], $_POST["type"], $_SESSION["labels"]["multi"]));
                unset($_SESSION["labels"]["multi"]);
                $_SESSION["labels"]["id"]++;
            }
            else{
                header("Location: .");
            }
        }

        header("Location: .");
    }
    else if(isset($_GET["del"])){
        if(isset($_SESSION["labels"]["data"][$_GET["del"]])){

            unset($_SESSION["labels"]["data"][$_GET["del"]]);
            $_SESSION["labels"]["id"]--;

            $_SESSION["labels"]["data"] = array_values($_SESSION["labels"]["data"]);

            header("Location: .");
        }
    }
    else if(isset($_GET["sel"])){
        if(isset($_SESSION["labels"]["solo"][$_GET["sel"]])){
            unset($_SESSION["labels"]["solo"][$_GET["sel"]]);

            $_SESSION["labels"]["solo"] = array_values($_SESSION["labels"]["solo"]);

            header("Location: .");
        }
    }
    else if(isset($_GET["mul"])){
        if(isset($_SESSION["labels"]["multi"][$_GET["mul"]])){
            unset($_SESSION["labels"]["multi"][$_GET["mul"]]);

            $_SESSION["labels"]["multi"] = array_values($_SESSION["labels"]["multi"]);

            header("Location: .");
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
    <?php include_once $_SERVER['DOCUMENT_ROOT']."/php/pages/login_modal.php" ?>
    <div class = "container mt-4">
        <h3 class = "text-center">Конструктор экспертной сессии</h3>
    </div>
    <div class = "container-fluid d-flex align-items-center justify-content-around mt-5">
        <div class = "col-5">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            C открытым ответом (число)
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Название поля:</label>
                                    <input type="text" class="form-control" name = "text" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <input type="hidden" name = "type" value="one">
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            C открытым ответом (положительное число)
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Название поля:</label>
                                    <input type="text" class="form-control" name = "text" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <input type="hidden" name = "type" value="two">
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            C открытым ответом (строка)
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Название поля:</label>
                                    <input type="text" class="form-control" name = "text" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <input type="hidden" name = "type" value="three">
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThird">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThird" aria-expanded="false" aria-controls="collapseThird">
                            C открытым ответом (текст)
                        </button>
                    </h2>
                    <div id="collapseThird" class="accordion-collapse collapse" aria-labelledby="headingThird" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Название поля:</label>
                                    <input type="text" class="form-control" name = "text" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <input type="hidden" name = "type" value="four">
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFifth">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifth" aria-expanded="false" aria-controls="collapseFifth">
                            C единственным выбором
                        </button>
                    </h2>
                    <div id="collapseFifth" class="accordion-collapse collapse" aria-labelledby="headingFifth" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Добавить поля для выбора:</label>
                                    <input type="text" class="form-control mb-2" placeholder="Названия поля для выбора" name = "data" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                    <input type="number" class="form-control mb-2" min="-100" max="100" placeholder="Балл за выбранный вариант" name = "mark" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                    <input type="hidden" name = "type" value="solo">
                                    <select class = "form-select">
                                        <?php
                                            for($i = 0; $i < count($_SESSION["labels"]["solo"]); $i++){
                                                echo "<option value='".$_SESSION["labels"]["solo"][$i]["data"]."'>".$_SESSION["labels"]["solo"][$i]["data"]." Балл: ".$_SESSION["labels"]["solo"][$i]["mark"]."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class = "d-flex flex-column">
                                    <?php
                                        if(isset($_SESSION["labels"]["solo"])){
                                            for($i = 0; $i < count($_SESSION["labels"]["solo"]); $i++){
                                                echo "<a class = 'mb-2' href = '?sel=".$i."'>Удалить: ".$_SESSION["labels"]["solo"][$i]["data"]."</a>";
                                            }
                                        }
                                    ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Создать</button>
                                <div id="emailHelp" class="form-text">Без созданных 2-ух полей не получится добавить форму на страницу</div>
                            </form>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Название поля:</label>
                                    <input type="text" class="form-control" name = "text" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <input type="hidden" name = "type" value="five">
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            C множественным выбором
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Добавить поля для выбора:</label>
                                    <input type="text" class="form-control mb-2" placeholder="Названия поля для выбора" name = "data" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                    <input type="number" class="form-control mb-2" min="-100" max="100" placeholder="Балл за выбранный вариант" name = "mark" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                    <input type="hidden" name = "type" value="multi">
                                    <select class = "form-select">
                                        <?php
                                        for($i = 0; $i < count($_SESSION["labels"]["multi"]); $i++){
                                            echo "<option value='".$_SESSION["labels"]["multi"][$i]["data"]."'>".$_SESSION["labels"]["multi"][$i]["data"]." Балл: ".$_SESSION["labels"]["multi"][$i]["mark"]."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class = "d-flex flex-column">
                                    <?php
                                    if(isset($_SESSION["labels"]["multi"])){
                                        for($i = 0; $i < count($_SESSION["labels"]["multi"]); $i++){
                                            echo "<a class = 'mb-2' href = '?mul=".$i."'>Удалить: ".$_SESSION["labels"]["multi"][$i]["data"]."</a>";
                                        }
                                    }
                                    ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Создать</button>
                                <div id="emailHelp" class="form-text">Без созданных 3-ух полей не получится добавить форму на страницу</div>
                            </form>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Название поля:</label>
                                    <input type="text" class="form-control" name = "text" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <input type="hidden" name = "type" value="six">
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class = "col-5">
            <h4 class = "text-center">Внешний вид</h4>
            <div>
                <?php

                    for($i = 0; $i < $_SESSION["labels"]["id"]; $i++){
                        switch ($_SESSION["labels"]["data"][$i]->getSubjectUUID()){
                            case "one":
                                echo '<form class="mb-4">
                                         <label for="exampleInputEmail1" class="form-label">'.$_SESSION["labels"]["data"][$i]->getSubjectName().'</label>
                                         <input type="number" class="form-control" placeholder="Введите число" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                                         <a href = "?del='.$i.'" class="btn btn-danger mt-2">Удалить</a>
                                     </form>';
                                break;
                            case "two":
                                echo '<form class="mb-4">
                                         <label for="exampleInputEmail1" class="form-label">'.$_SESSION["labels"]["data"][$i]->getSubjectName().'</label>
                                         <input type="number" class="form-control" min = "0" placeholder="Введите положительное число" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                                         <a href = "?del='.$i.'" class="btn btn-danger mt-2">Удалить</a>
                                     </form>';
                                break;
                            case "three":
                                echo '<form class="mb-4">
                                         <label for="exampleInputEmail1" class="form-label">'.$_SESSION["labels"]["data"][$i]->getSubjectName().'</label>
                                         <input type="text" class="form-control" minlength="1" maxlength="30" placeholder="Введите строку от 1 до 30 символов" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                                         <a href = "?del='.$i.'" class="btn btn-danger mt-2">Удалить</a>
                                     </form>';
                                break;
                            case "four":
                                echo '<form class="mb-4">
                                         <label for="exampleInputEmail1" class="form-label">'.$_SESSION["labels"]["data"][$i]->getSubjectName().'</label>
                                         <textarea type="text" class="form-control" minlength="1" maxlength="255" id="exampleInputEmail1" aria-describedby="emailHelp" disabled></textarea>
                                         <a href = "?del='.$i.'" class="btn btn-danger mt-2">Удалить</a>
                                     </form>';
                                break;
                            case "five" || "six":
                                echo '<form class="mb-4">
                                         <label for="exampleInputEmail1" class="form-label">'.$_SESSION["labels"]["data"][$i]->getSubjectName().'</label>
                                         <select class = "form-select" disabled>';
                                            for($j = 0; $j < count($_SESSION["labels"]["data"][$i]->getSubjectData()); $j++){
                                                echo '<option value="'.$_SESSION["labels"]["data"][$i]->getSubjectData()[$j]["data"].'">'.$_SESSION["labels"]["data"][$i]->getSubjectData()[$j]["data"].'</option>';
                                            }
                                         echo '</select>
                                         <a href = "?del='.$i.'" class="btn btn-danger mt-2">Удалить</a>
                                     </form>';
                                break;
                        }
                    }
                    if(isset($_SESSION["labels"]["data"]) && count($_SESSION["labels"]["data"]) > 0){
                        echo '<form method="post" action="/php/generate.php" class = "mt-5">';
                            echo '<input type="text" class = "form-control" name="data" placeholder="Название сессии" required>';
                            echo '<button type = "submit" class="btn btn-success mt-3">Создать сессию</button>';
                        echo '</form>';
                    }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>