

const salesConfig = 
{
    type: 'bar',
    data: {
        labels: moment.monthsShort(),
        datasets: null,
    },
    options: {
        tooltips: {
          callbacks: {
            label: (item) => `ยอดขาย: ${item.yLabel.toLocaleString('th-TH', { style: 'currency', currency: 'THB' })}`,
          },
        },
        responsive: true,
        legend: {
            display: false,
        },
    },
}

/*
const ordersConfig = 
{
    type: 'bar',
    data: {
        labels: moment.monthsShort(),
        datasets: [],
    },
    options: {
        scales: {
          yAxes: [{
              ticks: {
                  beginAtZero: true,
                  userCallback: function(label, index, labels) {
                      if (Math.floor(label) === label) {
                          return label;
                      }

                  },
              }
          }],
      },
        responsive: true,
        legend: {
            display: false,
        },
    },
}*/

const salesCtx = document.getElementById('sales')
// const ordersCtx = document.getElementById('orders')

$.ajax({
    url: siteUrl + '/api/report/salesChart',
    method: 'GET',
    dataType: 'JSON',
    contentType: false,
    cache: false,
    processData: false,
    success:function(response)
    {

      console.log(response);
        let res = response.map(x => {
            return {labels: x.labels, sale: parseInt(x.sale), order: parseInt(x.order_count)};
        });

        let momentMonths = moment.monthsShort();

        let fullMonths = momentMonths.map((x, index) => {
          return {
            labels: momentMonths[index],
            sale: 0,
            order: 0
          };
        });

        fullMonths = Object.values([...fullMonths, ...res].reduce((res, { labels, sale, order }) => {
            res[labels] = { 
              labels,
              sale: (res[labels] ? res[labels].sale : 0) + sale,
              order: (res[labels] ? res[labels].order : 0) + order
            };
            return res;
          }, {}));

          let months = fullMonths.map(element => {
              return element.labels;
          });

          salesConfig.data = 
          {
            labels: months,
            datasets: [ 
              {
                label: 'ยอดขาย',
                backgroundColor: '#7e3af2',
                borderWidth: 1,
                data: fullMonths.map((v) => v.sale),
              }
            ]
          };

        /*salesConfig.data.labels = months;
        salesConfig.data.datasets = [ 
            {
              label: 'ยอดขาย',
              backgroundColor: '#7e3af2',
              borderWidth: 1,
              data: fullMonths.map((v) => v.sale),
            }
          ];*/

        /*ordersConfig.data.datasets[0] = 
            {
              label: 'ยอดสั่งซื้อ',
              backgroundColor: '#0694a2',
              borderWidth: 1,
              data: fullMonths.map((v) => v.order),
            }
        ;*/

        window.myBar = new Chart(salesCtx, salesConfig)

        // window.myBar = new Chart(ordersCtx, ordersConfig)
    },
    error: function(response) {
        console.log(response);
    }
});
