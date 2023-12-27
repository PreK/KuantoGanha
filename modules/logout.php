<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="login-form">
        <h2>Logout</h2>
        <p>Logout realizado com sucesso!</p>

        <div class="form-group">
            <button onclick="window.location.href='index.php'" class="btn btn-primary">Voltar à página inicial</button>
        </div>
    </div>
</main>
