<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>KuantoGanha.pt</title>

  <!-- Fonte Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Ícones do Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle JS (inclui Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="js/scripts.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        // Desenhar o gráfico de barras
        google.charts.setOnLoadCallback(drawBarChart);

        function drawBarChart() {
            var data = google.visualization.arrayToDataTable([
                ['Função', 'Salário (€)'],
                ['DevOps', 65000],
                ['Engenheiro de Software', 60000]
                // Adicione mais dados aqui
            ]);

            var options = {
                title: 'Salários por Função',
                hAxis: {title: 'Função', titleTextStyle: {color: 'black'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.BarChart(document.getElementById('bar_chart'));
            chart.draw(data, options);
        }

        // Desenhar o gráfico de linhas
        google.charts.setOnLoadCallback(drawLineChart);

        function drawLineChart() {
            var data = google.visualization.arrayToDataTable([
                ['Ano', 'Salário (€)'],
                ['2019', 55000],
                ['2020', 57000]
                // Adicione mais dados aqui
            ]);

            var options = {
                title: 'Evolução Salarial (2019-2022)',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
            chart.draw(data, options);
        }
    </script>
  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="grid-container">

  <!-- Header-->
  <header class="header">
    <div class="menu-icon" onclick="openSidebar()">
      <span class="material-icons-outlined text-normal">menu</span>
    </div>
  </header>
  <!-- Fim do Cabeçalho -->

  <!-- Barra Lateral -->
    <div class="d-flex">
        <div class="sidebar">
            <h3 class="text-center py-3">KuantoGanha.pt</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Painel de Controlo</a>
                </li>
                <!-- Outros itens da sidebar -->
            </ul>
            <div class="form-check form-switch text-center mb-3">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle">Modo Escuro</label>
            </div>
        </div>
        <div class="flex-grow-1 p-3">
            <!-- Conteúdo principal aqui -->
        </div>
    </div>

  <!-- Fim da Barra Lateral -->

  <!-- Conteúdo Principal -->
  <main class="main-container">
    <div class="main-title">
      <p class="font-weight-bold">PAINEL DE CONTROLO</p>
    </div>

    <div class="main-cards">

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL DE REGISTOS</p>
          <span class="material-icons-outlined text-blue">inventory_2</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $totalRegistos; ?> Registos</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">MAIOR SALÁRIO REPORTADO</p>
          <span class="material-icons-outlined text-green">currency_exchange</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo number_format($maiorSalario, 2, ',', '.'); ?> €</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">MÉDIA SALARIAL</p>
          <span class="material-icons-outlined text-orange">monetization_on</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo number_format($mediaSalarial, 2, ',', '.'); ?> €</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">MENOR SALÁRIO REPORTADO</p>
          <span class="material-icons-outlined text-red">attach_money</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo number_format($menorSalario, 2, ',', '.'); ?> €</span>
      </div>
    </div>
      <div class="container mt-4">
          <form action="processa_filtro.php" method="GET">
              <div class="row mb-3">
                  <!-- Dropdown de Distrito -->
                  <div class="col">
                      <select class="form-select" name="distrito">
                          <option selected>Escolha o Distrito</option>
                          <option value="lisboa">Lisboa</option>
                          <option value="porto">Porto</option>
                          <!-- Outros distritos aqui -->
                      </select>
                  </div>

                  <!-- Dropdown de Área -->
                  <div class="col">
                      <select class="form-select" name="area">
                          <option selected>Escolha a Área</option>
                          <option value="tecnologia">Tecnologia</option>
                          <option value="saude">Saúde</option>
                          <!-- Outras áreas aqui -->
                      </select>
                  </div>

                  <!-- Dropdown de Profissão -->
                  <div class="col">
                      <select class="form-select" name="profissao">
                          <option selected>Escolha a Profissão</option>
                          <option value="devops">DevOps</option>
                          <option value="medico">Médico</option>
                          <!-- Outras profissões aqui -->
                      </select>
                  </div>
              </div>

              <!-- Botão de Submissão -->
              <button type="submit" class="btn btn-primary">Filtrar</button>
          </form>
      </div>
      <div class="container mt-5">
          <h2>KuantoGanha.pt</h2>

          <!-- Gráfico de Barras -->
          <div id="bar_chart" style="width: 100%; height: 500px;"></div>

          <!-- Gráfico de Linhas -->
          <div id="line_chart" style="width: 100%; height: 500px;"></div>
      </div>

      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  </main>

    </div>
</body>
</html>