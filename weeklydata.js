var customLables = {
    0: 'Create account', 20: 'Activate account', 40: 'Provide profile information', 50: 'What jobs are you interested in?',
    70: 'Do you have relevant experience in these jobs', 90: 'Are you a freelancer?', 99: 'Waiting for approval', 100: 'Approval'
};
console.log(customLables);

var chart = Highcharts.chart("container", {
  title: {
    text: "Weekly Retention Curves",
  },

  subtitle: {
    text: "Source: export.csv",
  },

  yAxis: {
    title: {
      text: "Percentage of users (%)",
    },
  },

    xAxis: {
        rotation: 45,
        labels: {
            enabled: true,
            formatter: function () { return customLables[this.value]; },
        },
    title: {
      text: "Onboarding Flow (%)",
    },
    accessibility: {
      rangeDescription: "Range: 0 to 100",
      },
  },

  legend: {
    layout: "vertical",
    align: "right",
    verticalAlign: "middle",
  },

  plotOptions: {
    series: {
      label: {
        connectorAllowed: false,
      },
      pointStart: 0,
      pointInterval: 10,
    },
  },

  responsive: {
    rules: [
      {
        condition: {
              maxWidth: 800,
        },
        chartOptions: {
          legend: {
            layout: "horizontal",
            align: "center",
            verticalAlign: "bottom",
          },
        },
      },
    ],
  },
});

var weeklyData = [];
var opts = {
  method: "GET",
  headers: {},
};
fetch("/api.php", opts)
  .then(function (response) {
    return response.json();
  })
  .then(function (body) {
    for (const key in body) {
      chart.addSeries({
        name: key,
        data: Object.values(body[key]),
      });
    }
  });
