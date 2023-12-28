/* globals Chart:false */

(() => {
  'use strict';
// Carregar dados para o gráfico e a tabela
  document.addEventListener('DOMContentLoaded', function() {
    fetchChartData();
    fetchTableData();

    const districtFilter = document.getElementById('districtFilter');
    if (districtFilter) {
      districtFilter.addEventListener('change', function() {
        fetchChartData();
      });
    }
  });

  // Função para buscar dados do gráfico via AJAX
  function fetchChartData() {
    const district = document.getElementById('districtFilter').value;
    fetch('modules/getInfo.php?requestType=chart&district=' + district)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error('Erro ao buscar dados do gráfico:', data.error);
          } else {
            updateChart(data);
          }
        })
        .catch(error => console.error('Erro ao buscar dados do gráfico:', error));
  }

  function fetchTableData() {
    fetch('modules/getInfo.php?requestType=table')
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error('Erro ao buscar dados da tabela:', data.error);
          } else {
            updateTable(data);
          }
        })
        .catch(error => console.error('Erro ao buscar dados da tabela:', error));
  }


  // Criação inicial do gráfico

  function updateChart(data) {
    const labels = data.map(item => item.title);
    const values = data.map(item => parseFloat(item.averagesalary));
    myChart.data.labels = data.labels;
    myChart.data.datasets[0].data = data.values;
    myChart.update();
  }

  function updateTable(data) {
    const tableBody = document.getElementById('latestJobsTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';
    data.forEach(item => {
      const row = `<tr>
                        <td>${item.title}</td>
                        <td>${item.district}</td>
                        <td>${item.description}</td>
                        <td>${item.start_date}</td>
                        <td>${item.end_date ?? 'N/A'}</td>
                    </tr>`;
      tableBody.innerHTML += row;
    });
  }
  const ctx = document.getElementById('salaryChart');
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [],
      datasets: [{
        label: 'Salário Médio',
        data: [],
        backgroundColor: 'rgba(0, 123, 255, 0.5)',
        borderColor: '#007bff',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
})();

