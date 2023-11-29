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
      <!-- Navbar do Bootstrap -->
      <!-- Navbar do Bootstrap com Ícones e Dropdown -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
              <!-- Logo e Toggle Button para dispositivos móveis -->
              <a class="navbar-brand" href="#">
                  <span class="material-icons-outlined">savings</span> KuantoGanha
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <!-- Itens da Navbar -->
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav ms-auto">
                      <!-- Item Simples -->
                      <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="dashboard.php">
                              <span class="material-icons-outlined">dashboard</span> Painel de Controlo
                          </a>
                      </li>

                      <!-- Dropdown -->
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <span class="material-icons-outlined">settings</span> Opções
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <li><a class="dropdown-item" href="profile.php">Perfil</a></li>
                              <li><a class="dropdown-item" href="settings.php">Configurações</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="logout.php">Sair</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
    <div class="header-left">
      <span class="material-icons-outlined text-normal">search</span>
    </div>
    <div class="header-right">
      <span class="material-icons-outlined">notifications</span>
      <span class="material-icons-outlined">email</span>
      <span class="material-icons-outlined">account_circle</span>
    </div>
    <div class="mode-toggle">
      <span class="material-icons-outlined">light_mode</span>
      <label class="switch">
        <input type="checkbox" id="mode-switch" onclick="toggleDarkMode()">
        <span class="slider round"></span>
      </label>
      <span class="material-icons-outlined">dark_mode</span>
    </div>
  </header>
  <!-- Fim do Cabeçalho -->

  <!-- Barra Lateral -->
  <aside id="sidebar">
    <div class="sidebar-title">
      <div class="sidebar-brand">
        <span class="material-icons-outlined">savings</span> KuantoGanha
      </div>
      <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
    </div>

    <ul class="sidebar-list">
      <li class="sidebar-list-item">
        <a href="dashboard.php">
          <span class="material-icons-outlined">dashboard</span> Painel de Controlo
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="statistics.php">
          <span class="material-icons-outlined">poll</span> Estatísticas
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="settings.php">
          <span class="material-icons-outlined">settings</span> Definições
        </a>
      </li>
    </ul>
  </aside>
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