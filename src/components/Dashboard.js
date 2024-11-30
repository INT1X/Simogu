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
        <TeacherCharts />
      </div>
    </div>
  );
};

export default Dashboard;
