// src/App.js
import React from "react";
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";
import Login from "./components/Login";
import Dashboard from "./components/Dashboard";

const App = () => {
  return (
    <Router>
      <Switch>
        <Route path="/" exact component={Login} />
        <Route path="/dashboard" component={Dashboard} />
        {/* Add routes for other components like ManageTeacherData, TeacherPerformanceEvaluation, Reports, Settings */}
      </Switch>
    </Router>
  );
};

export default App;
