<canvas class="<?= basename($component['file'],'.php').$component['id'].$component_counter ?>"></canvas>
<script>
// Create chart
var ctx = document.getElementsByClassName("<?= basename($component['file'],'.php').$component['id'].$component_counter ?>");
var chart = new Chart(ctx, {
    type:"doughnut",
    data: {
        labels : ["Red","Blue"],
        datasets: [{
            label: "Gauge",
            data : [10, 190],
            backgroundColor: [
                "rgb(255, 99, 132)",
                "rgb(54, 162, 235)",
                "rgb(255, 205, 86)"
            ]
        }]
    },
    options: {
        circumference: Math.PI,
        rotation : Math.PI,
        cutoutPercentage : 90, // precent
        plugins: {
					  datalabels: {
              backgroundColor: 'rgba(0, 0, 0, 0.7)',
						  borderColor: '#ffffff',
              color: function(context) {
							  return context.dataset.backgroundColor;
						  },
						  font: function(context) {
                var w = context.chart.width;
                return {
                  size: w < 512 ? 18 : 20
                }
              },
              align: 'start',
              anchor: 'start',
              offset: 10,
						  borderRadius: 4,
						  borderWidth: 1,
              formatter: function(value, context) {
							  var i = context.dataIndex;
                var len = context.dataset.data.length - 1;
                if(i == len){
                  return null;
                }
							  return value+' mph';
						  }
            }
        },
        legend: {
            display: false
        },
        tooltips: {
            enabled: false
        }
    }
});


// DEMO Code: not relevant to example
function change_gauge(chart, label, data){
  chart.data.datasets.forEach((dataset) => {
    if(dataset.label == label){
      dataset.data = data;
    }  
  });
  chart.update();
}

var accelerating = false;
function accelerate(){
  accelerating = false;
  window.setTimeout(function(){
      change_gauge(chart,"Gauge",[20,140])
  }, 1000);

  window.setTimeout(function(){
      change_gauge(chart,"Gauge",[60,140])
  }, 2000);

  window.setTimeout(function(){
      change_gauge(chart,"Gauge",[100,100])
  }, 3000);

  window.setTimeout(function(){
      change_gauge(chart,"Gauge",[180,20])
  }, 4000);

  window.setTimeout(function(){
      change_gauge(chart,"Gauge",[200,0])
  }, 5000);
}

// Start sequence
accelerate();
window.setInterval(function(){
  if(!accelerating){
    acelerating = true;
    accelerate();
  }
}, 6000);
</script>