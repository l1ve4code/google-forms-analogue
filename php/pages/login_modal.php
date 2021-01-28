<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Авторизация</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="php/auth/signin.php">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Логин</label>
                        <input type="text" name = "login" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                        <input type="password" name = "password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-success">Войти</button>
                </form>
            </div>
        </div>
    </div>
</div>