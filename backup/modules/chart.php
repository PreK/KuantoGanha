<canvas id="teamChart" width="400" height="400"></canvas>

// Inclui o script do Chart.js
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('teamChart').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'bar', // ou 'line', 'pie', etc.
        data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
            label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                // ... cores para cada barra
            ],
                borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                // ... bordas para cada barra
            ],
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
</script>
