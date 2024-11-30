// src/App.js
import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Login from "./components/Login";
import Dashboard from "./components/Dashboard";
// Import other components as needed

const App = () => {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/dashboard" element={<Dashboard />} />
        {/* Add routes for other components like ManageTeacherData, TeacherPerformanceEvaluation, Reports, Settings */}
      </Routes>
    </Router>
  );
};

export default App;
