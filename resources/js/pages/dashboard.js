/*
 *  Document   : be_pages_dashboard.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Dashboard Page
 */

// Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
class pageDashboard {
  /*
   * Init Charts
   *
   */
  static initCharts() {
    // Set Global Chart.js configuration
    Chart.defaults.color = "#818d96";
    Chart.defaults.scale.grid.lineWidth = 0;
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.datasets.bar.maxBarThickness = 45;
    Chart.defaults.elements.bar.borderRadius = 4;
    Chart.defaults.elements.bar.borderSkipped = false;
    Chart.defaults.elements.point.radius = 0;
    Chart.defaults.elements.point.hoverRadius = 0;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.labels.boxWidth = 10;

    // Get Chart Containers
    const chartEarningsCon = document.getElementById("js-chartjs-earnings");
    const chartTotalSubscriptionsCon = document.getElementById(
      "js-chartjs-total-subscriptions"
    );
    const chartTotalEarningsCon = document.getElementById(
      "js-chartjs-total-earnings"
    );
    const chartNewCustomersCon = document.getElementById(
      "js-chartjs-new-customers"
    );
    // Retrieve data from data attributes
    const yearlyEarningData = JSON.parse(
      chartEarningsCon.getAttribute("data-chart-data")
    );
    const subscriptionsData = JSON.parse(
      chartTotalSubscriptionsCon.getAttribute("data-chart-data")
    );
    const earningsData = JSON.parse(
      chartTotalEarningsCon.getAttribute("data-chart-data")
    );
    const newCustomersData = JSON.parse(
      chartNewCustomersCon.getAttribute("data-chart-data")
    );

    // Set Chart and Chart Data variables
    let chartEarnings,
      chartTotalSubscriptions,
      chartTotalEarnings,
      chartNewCustomers;

    // Init Chart Earnings
    if (chartEarningsCon !== null) {
      chartEarnings = new Chart(chartEarningsCon, {
        type: "bar",
        data: {
          labels: yearlyEarningData.labels,
          datasets: [
            {
              label: "This Year",
              fill: true,
              backgroundColor: "rgba(100, 116, 139, .7)",
              borderColor: "transparent",
              pointBackgroundColor: "rgba(100, 116, 139, 1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(100, 116, 139, 1)",
              data: yearlyEarningData.earningsThisYear,
            },
            {
              label: "Last Year",
              fill: true,
              backgroundColor: "rgba(100, 116, 139, .15)",
              borderColor: "transparent",
              pointBackgroundColor: "rgba(100, 116, 139, 1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(100, 116, 139, 1)",
              data: yearlyEarningData.earningsLastYear,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              display: false,
              grid: {
                drawBorder: false,
              },
            },
            y: {
              display: false,
              grid: {
                drawBorder: false,
              },
            },
          },
          interaction: {
            intersect: false,
          },
          plugins: {
            legend: {
              labels: {
                boxHeight: 10,
                font: {
                  size: 14,
                },
              },
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  return context.dataset.label + ": $" + context.parsed.y;
                },
              },
            },
          },
        },
      });
    }

    // Init Chart Total Subscriptions
    if (chartTotalSubscriptionsCon !== null) {
      chartTotalSubscriptions = new Chart(chartTotalSubscriptionsCon, {
        type: "line",
        data: {
          labels: subscriptionsData.labels,
          datasets: [
            {
              label: "Total Subscriptions",
              fill: true,
              backgroundColor: "rgba(220, 38, 38, .15)",
              borderColor: "transparent",
              pointBackgroundColor: "rgba(220, 38, 38, 1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(220, 38, 38, 1)",
              data: subscriptionsData.data,
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          tension: 0.4,
          scales: {
            x: {
              display: false,
            },
            y: {
              display: false,
            },
          },
          interaction: {
            intersect: false,
          },
          plugins: {
            legend: {
              display: false,
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  return " " + context.parsed.y + " Subscriptions";
                },
              },
            },
          },
        },
      });
    }

    // Init Chart Total Earnings
    if (chartTotalEarningsCon !== null) {
      chartTotalEarnings = new Chart(chartTotalEarningsCon, {
        type: "line",
        data: {
          labels: earningsData.labels,
          datasets: [
            {
              label: "Total Earnings",
              fill: true,
              backgroundColor: "rgba(101, 163, 13, .15)",
              borderColor: "transparent",
              pointBackgroundColor: "rgba(101, 163, 13, 1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(101, 163, 13, 1)",
              data: earningsData.data,
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          tension: 0.4,
          scales: {
            x: {
              display: false,
            },
            y: {
              display: false,
            },
          },
          interaction: {
            intersect: false,
          },
          plugins: {
            legend: {
              display: false,
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  return " $" + context.parsed.y;
                },
              },
            },
          },
        },
      });
    }

    // Init Chart New Customers
    if (chartNewCustomersCon !== null) {
      chartNewCustomers = new Chart(chartNewCustomersCon, {
        type: "line",
        data: {
          labels: newCustomersData.labels,
          datasets: [
            {
              label: "Total Subscriptions",
              fill: true,
              backgroundColor: "rgba(101, 163, 13, .15)",
              borderColor: "transparent",
              pointBackgroundColor: "rgba(101, 163, 13, 1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(101, 163, 13, 1)",
              data: newCustomersData.data,
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          tension: 0.4,
          scales: {
            x: {
              display: false,
            },
            y: {
              display: false,
            },
          },
          interaction: {
            intersect: false,
          },
          plugins: {
            legend: {
              display: false,
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  return " " + context.parsed.y + " Customers";
                },
              },
            },
          },
        },
      });
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initCharts();
  }
}

// Initialize when page loads
One.onLoad(() => pageDashboard.init());
