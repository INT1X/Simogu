// src/components/TeacherCharts.js
import React from "react";
import { Bar, Pie } from "react-chartjs-2";

const TeacherCharts = () => {
  const barData = {
    labels: ["Sangat Kurang", "Kurang", "Cukup", "Baik", "Sangat Baik"],
    datasets: [
      {
        label: "Pedagogic",
        data: [5, 10, 15, 20, 25],
        backgroundColor: "rgba(75, 192, 192, 0.6)",
      },
      {
        label: "Professional",
        data: [3, 6, 12, 18, 30],
        backgroundColor: "rgba(153, 102, 255, 0.6)",
      },
      {
        label: "Social",
        data: [2, 4, 8, 16, 20],
        backgroundColor: "rgba(255, 159, 64, 0.6)",
      },
      {
        label: "Personality",
        data: [1, 3, 7, 14, 22],
        backgroundColor: "rgba(255, 99, 132, 0.6)",
      },
    ],
  };

  const pieData = {
    labels: ["Average Score"],
    datasets: [
      {
        data: [4.2], // Example average score
        backgroundColor: ["rgba(54, 162, 235, 0.6)"],
      },
    ],
  };

  return (
    <div className="p-5">
      <h2 className="text-xl font-bold mb-4">Teacher Performance Charts</h2>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="bg-white p-4 rounded shadow">
          <Bar data={barData} options={{ responsive: true }} />
        </div>
        <div className="bg-white p-4 rounded shadow">
          <Pie data={pieData} options={{ responsive: true }} />
        </div>
      </div>
    </div>
  );
};

export default TeacherCharts;
