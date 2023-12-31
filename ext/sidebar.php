<?php
// Start the session (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">KuantoGanha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="index.php">
                        <i class="bi bi-gear"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#" data-target="modules/perfil.php" id="profileLink">
                        <i class="bi bi-person"></i>Perfil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#" data-target="modules/userJobs.php" id="userJobsLink">
                        <i class="bi bi-person-workspace"></i>Adicionar Profissão
                    </a>
                </li>

                <?php if ($_SESSION["username"] === "admin") { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="#" data-target="modules/jobs.php" id="jobsLink">
                            <i class="bi bi-journal-bookmark"></i>Profissões
                        </a>
                    </li>
                <?php } ?>

                <!-- Link direto para logout, sem AJAX -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#" data-target="modules/logout.php" id="logout">
                        <i class="bi bi-box-arrow-left"></i>Logout
                    </a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="#" data-target="modules/login.php" id="loginLink">
                        <i class="bi bi-box-arrow-in-right"></i>Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#" data-target="modules/register.php" id="registerLink">
                        <i class="bi bi-pencil"></i>Registar
                    </a>
                </li>
            <?php } ?>
    </div>
</div>
