<!DOCTYPE html>
<html lang="en">
<?php
            // Start the session (if not already started)
            session_start();
            ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebar.css">
    <title>KuantoGanha.pt</title>
</head>
<body>

<div class="container-fluid">

    <div class="row">
        <!-- Sidebar -->
        <?php include('modules/sidebar.php'); ?>

        <!-- Conteúdo principal -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <!-- Main Container  -->
            <?php
            // Check if the user is logged in

            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                include('dashboard.php');
            } else {
                include('welcome.php');
            }
            ?>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>