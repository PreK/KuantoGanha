<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <?php if ($logged_in) { ?>
                <!-- If the user is logged in, display the logout link -->
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php } else { ?>
                <!-- If the user is not logged in, display the login link -->
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Página 2
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Página 3
                </a>
            </li>
        </ul>
    </div>
</nav>