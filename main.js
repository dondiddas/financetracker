const chartData = {
  labels: ["Python", "Java", "C#", "CSS", "Others"],
  data: [40, 24, 56, 12, 50],
};

const myChart = document.querySelector(".myChart").getContext("2d");

new Chart(myChart, {
  type: "doughnut",
  data: {
    labels: chartData.labels,
    datasets: [{
      label: "Language",
      data: chartData.data,
      backgroundColor: [
        "#4CAF50",
        "#2196F3",
        "#FF9800",
        "#E91E63",
        "#9C27B0"
      ],
      borderWidth: 2
    }]
  },
  options: {
    clip: {left: 200, top: false, right: -2, bottom: 0},
    responsive: true,
    borderWidth: 10,
    borderRadius: 3,
    hoverBorderWidth: 10,
    maintainAspectRatio: false, 
    plugins: {
      legend: {
        display: true,
        position: "left",
      } 
    }
  }
});
