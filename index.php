<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KuantoGanha.pt</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"> <!-- Link para o Bootstrap -->
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Inclui a barra lateral -->
        <?php include 'modules/sidebar.php'; ?>

        <div class="col py-3">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Link para o Chart.js -->
            <!-- Conteúdo principal -->
            <h3>Benvindo ao KuantoGanha.pt</h3>
            <canvas id="teamChart" width="400" height="400"></canvas>
        <?php include 'modules/chart.php'; ?>
            <!-- Conteúdo do gráfico será inserido aqui -->
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script> <!-- Script do Bootstrap -->
</body>
</html>
