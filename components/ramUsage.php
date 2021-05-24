<canvas id="<?= basename($component['file'],'.php').$component['id'] ?>"></canvas>
<script>
var ctx = document.getElementById("<?= basename($component['file'],'.php').$component['id'] ?>").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Running', 'Remaining'],
        datasets: [{
            label: 'RAM Usage',
            data: [123,343],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
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