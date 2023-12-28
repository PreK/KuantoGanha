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
        fetchChartData(this.value);
      });
    }
  });

  // Função para buscar dados do gráfico via AJAX
  function fetchChartData(district = '') {
    fetch('modules/getInfo.php?requestType=chart&district=' + district)
        .then(response => response.json())
        .then(data => updateChart(data))
        .catch(error => console.error('Erro ao buscar dados do gráfico:', error));
  }

  function fetchTableData() {
    fetch('modules/getInfo.php?requestType=table')
        .then(response => response.json())
        .then(data => {
          updateTable(data);
        })
        .catch(error => console.error('Erro ao buscar dados da tabela:', error));
  }

  // Função para atualizar o gráfico com novos dados
  function updateChart(data) {
    myChart.data.labels = data.labels;
    myChart.data.datasets[0].data = data.values;
    myChart.update();
  }

  // Criação inicial do gráfico
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
  function updateChart(data) {
    myChart.data.labels = data.map(item => item.profession);
    myChart.data.datasets[0].data = data.map(item => item.averageSalary);
    myChart.update();
  }

  function updateTable(data) {
    const tableBody = document.getElementById('latestJobsTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';
    data.forEach(item => {
      let row = tableBody.insertRow();
      row.insertCell(0).innerText = item.profession;
      row.insertCell(1).innerText = item.location;
      row.insertCell(2).innerText = item.startDate;
    });
  }
})();

