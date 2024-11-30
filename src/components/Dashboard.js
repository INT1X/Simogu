// src/components/Dashboard.js
import React from "react";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import TeacherCharts from "./TeacherCharts";

const Dashboard = () => {
  return (
    <div className="flex">
      <Sidebar />
      <div className="flex-1">
        <Navbar />
        <div className="p-5">
          <h2 className="text-xl font-bold mb-4">Dashboard</h2>
          <TeacherCharts />
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
