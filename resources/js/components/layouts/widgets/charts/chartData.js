export const planetChartData = {
    type: 'bar',
    data: {
        labels: ["Approved", "Received", "Rejected", "Pending",],
        datasets: [{
            // label: 'Purchasing Request',
            data: [],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              
            ],
            borderColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              
            ],
            borderWidth: 1
          }]
    },
    options: {
      responsive:true,
        maintainAspectRatio: false,
        plugins:{
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
               label: function(tooltipItem) {
                      return tooltipItem.yLabel;
               }
            }
        }},
        scales: {
         
          xAxes: [{
            gridLines: {
                display:false
            }
        }],
        yAxes: [{
            gridLines: {
                display:false
            }   
        }]
        },
     
    },
   
  };
  
  export default planetChartData;