<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Экзамен</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Главная</a>
                </li>
                <?php
                    if(isset($_SESSION["user"])){
                        echo '<li class="nav-item">
                                 <a class="nav-link" href="/session">Экспертная сессия</a>
                              </li>';
                    }
                ?>
            </ul>
            <form class="d-flex">
                <?php
                    if(isset($_SESSION["user"])){
                        echo '<div class = "d-flex align-items-center justify-content-center">';
                        echo '<p class = "mb-0 me-3" style="color: white;" >Добрый день: '.$_SESSION["user"]["name"].'</p>';
                        echo '<a class="btn btn-outline-danger" href="/php/auth/logout.php">Выход</a>';
                        echo '</div>';
                    }else{
                        echo '<a class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Войти</a>';
                    }
                ?>
            </form>
        </div>
    </div>
</nav>