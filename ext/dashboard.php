<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h2">Dashboard</h1>

            <!-- Gráfico para as profissões mais bem pagas -->
            <div>
                <h3>Top 5 Profissões Mais Bem Pagas</h3>
                <canvas id="salaryChart"></canvas>
            </div>

            <!-- Seletor de Distrito -->
            <div>
                <label for="districtFilter">Filtrar por Distrito:</label>
                <select id="districtFilter" class="form-control">
                    <option value="all" selected>Todos os Distritos</option>
                    <option value="Aveiro">Aveiro</option>

                </select>
            </div>

            <!-- Tabela para as últimas profissões adicionadas -->
            <div>
                <h3>Últimas 20 Profissões Adicionadas</h3>
                <div class="table-responsive">
                    <table class="table table-striped" id="latestJobsTable">
                        <thead>
                        <tr>
                            <th>Profissão</th>
                            <th>Localização</th>
                            <th>Data de Início</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Os dados da tabela serão preenchidos via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script><script src="../js/dashboard.js"></script>
</body>
</html>