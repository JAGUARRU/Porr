
const salesConfig = 
{
    type: 'bar',
    data: {
        labels: moment.monthsShort(),
        datasets: [],
    },
    options: {
        tooltips: {
          callbacks: {
            label: (item) => `ยอดขาย: ${item.yLabel.toLocaleString('th-TH', { style: 'currency', currency: 'THB' })}`,
          },

          /*callbacks: {
            label: function(context) {
                let label = context.dataset.label || '';

                if (label) {
                    label += ': ';
                }
                if (context.parsed.y !== null) {
                    label += new Intl.NumberFormat('th-TH', { style: 'currency', currency: 'THB' }).format(context.parsed.y);
                }
                return label;
            }
          }*/
        },
        responsive: true,
        legend: {
            display: false,
        },
    },
}


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
}

/*
let week = 0;
const fullWeeks = [{
  labels: moment().subtract(1, 'months').format('MMMM'),
  completed: 0,
  incompleted: 0
},
{
  labels: moment().add(week, 'weeks').isoWeekday(2).format('ddd'),
  completed: 0,
  incompleted: 0
},
{
  labels: moment().add(week, 'weeks').isoWeekday(3).format('ddd'),
  completed: 0,
  incompleted: 0
},
{
  labels: moment().add(week, 'weeks').isoWeekday(4).format('ddd'),
  completed: 0,
  incompleted: 0
},
{
  labels: moment().add(week, 'weeks').isoWeekday(5).format('ddd'),
  completed: 0,
  incompleted: 0
},
{
  labels: moment().add(week, 'weeks').isoWeekday(6).format('ddd'),
  completed: 0,
  incompleted: 0
},
{
  labels: moment().add(week, 'weeks').isoWeekday(7).format('ddd'),
  completed: 0,
  incompleted: 0
}];
*/
/*
moment.tz.setDefault("Asia/Bangkok");
console.log(moment().tz("Asia/Bangkok").format('Z'))

const startOfMonth = moment().startOf('year');
const endOfMonth   = moment(startOfMonth).endOf('month').format('YYYY-MM-DD HH:mm:ss');

let query = `SELECT SUM(total) as total, CASE \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(0, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[0]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[1]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[2]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[3]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[4]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[5]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[6]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[7]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[8]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[9]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[10]}' \
            WHEN CAST(order_lists.created_at AS DATE) BETWEEN CAST('${startOfMonth.add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) AND CAST('${startOfMonth.endOf('month').format('YYYY-MM-DD HH:mm:ss')}' AS DATE) THEN '${moment.monthsShort()[11]}' \
            END  as labels FROM order_lists GROUP BY labels`;

console.log(query);*/

// select date_format(created_at,'%M') as labels, sum(total) as sale from order_lists group by year(created_at),month(created_at) order by year(created_at), month(created_at);

const salesCtx = document.getElementById('sales')
const ordersCtx = document.getElementById('orders')

$.ajax({
    url: siteUrl + '/api/report/salesChart',
    method: 'GET',
    dataType: 'JSON',
    contentType: false,
    cache: false,
    processData: false,
    success:function(response)
    {
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

        salesConfig.data.datasets[0] = 
            {
              label: 'ยอดขาย',
              backgroundColor: '#7e3af2',
              borderWidth: 1,
              data: fullMonths.map((v) => v.sale),
            }
        ;

        ordersConfig.data.datasets[0] = 
            {
              label: 'ยอดสั่งซื้อ',
              backgroundColor: '#0694a2',
              borderWidth: 1,
              data: fullMonths.map((v) => v.order),
            }
        ;

        window.myBar = new Chart(salesCtx, salesConfig)

        window.myBar = new Chart(ordersCtx, ordersConfig)
    },
    error: function(response) {
        console.log(response);
    }
});