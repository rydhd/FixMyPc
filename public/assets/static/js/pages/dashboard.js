// 1. Setup dynamic fallbacks
const finalChartLabels = (typeof dynamicChartLabels !== 'undefined' && dynamicChartLabels.length > 0)
    ? dynamicChartLabels
    : ["Section A", "Section B", "Section C", "Section D", "Section E", "Section F"];

const finalChartData = (typeof dynamicChartData !== 'undefined' && dynamicChartData.length > 0)
    ? dynamicChartData
    : [88, 76, 92, 81, 68, 95];

// 2. Configure optionsProfileVisit to use the variables
var optionsProfileVisit = {
  annotations: {
    position: "back",
  },
  dataLabels: {
    enabled: false,
  },
  title: {
    text: 'Section Performance (%)', // Updated title
    align: 'center'
  },
  chart: {
    type: "bar",
    height: 300,
  },
  fill: {
    opacity: 1,
  },
  plotOptions: {},
  series: [
    {
      name: "Average Score", // Updated series name
      data: finalChartData,
    },
  ],
  colors: "#435ebe",
  xaxis: {
    categories: finalChartLabels,
  },
  yaxis: {
    title: {
      text: "Percentage Completed (%)" // Updated Y-axis title
    },
    labels: {
      formatter: function (val) {
        return val + "%"; // Added the "%" sign for formatting
      }
    }
  }
}

// ---------------------------------------------------------
// The rest of your charts remain unchanged below
// ---------------------------------------------------------

let optionsVisitorsProfile = {
  series: [70, 30],
  labels: ["Male", "Female"],
  colors: ["#435ebe", "#55c6e8"],
  chart: {
    type: "donut",
    width: "100%",
    height: "350px",
  },
  legend: {
    position: "bottom",
  },
  plotOptions: {
    pie: {
      donut: {
        size: "30%",
      },
    },
  },
}

var optionsEurope = {
  series: [
    {
      name: "series1",
      data: [310, 800, 600, 430, 540, 340, 605, 805, 430, 540, 340, 605],
    },
  ],
  chart: {
    height: 80,
    type: "area",
    toolbar: {
      show: false,
    },
  },
  colors: ["#5350e9"],
  stroke: {
    width: 2,
  },
  grid: {
    show: false,
  },
  dataLabels: {
    enabled: false,
  },
  xaxis: {
    type: "datetime",
    categories: [
      "2018-09-19T00:00:00.000Z",
      "2018-09-19T01:30:00.000Z",
      "2018-09-19T02:30:00.000Z",
      "2018-09-19T03:30:00.000Z",
      "2018-09-19T04:30:00.000Z",
      "2018-09-19T05:30:00.000Z",
      "2018-09-19T06:30:00.000Z",
      "2018-09-19T07:30:00.000Z",
      "2018-09-19T08:30:00.000Z",
      "2018-09-19T09:30:00.000Z",
      "2018-09-19T10:30:00.000Z",
      "2018-09-19T11:30:00.000Z",
    ],
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
    labels: {
      show: false,
    },
  },
  show: false,
  yaxis: {
    labels: {
      show: false,
    },
  },
  tooltip: {
    x: {
      format: "dd/MM/yy HH:mm",
    },
  },
}

let optionsAmerica = {
  ...optionsEurope,
  colors: ["#008b75"],
}
let optionsIndonesia = {
  ...optionsEurope,
  colors: ["#dc3545"],
}

var chartProfileVisit = new ApexCharts(
    document.querySelector("#chart-profile-visit"),
    optionsProfileVisit
)
var chartVisitorsProfile = new ApexCharts(
    document.getElementById("chart-visitors-profile"),
    optionsVisitorsProfile
)
var chartEurope = new ApexCharts(
    document.querySelector("#chart-europe"),
    optionsEurope
)
var chartAmerica = new ApexCharts(
    document.querySelector("#chart-america"),
    optionsAmerica
)
var chartIndonesia = new ApexCharts(
    document.querySelector("#chart-indonesia"),
    optionsIndonesia
)

chartIndonesia.render()
chartAmerica.render()
chartEurope.render()
chartProfileVisit.render()
chartVisitorsProfile.render()