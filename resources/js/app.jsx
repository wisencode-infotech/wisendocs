import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { Toaster } from "react-hot-toast";
import Home from "./pages/Home";
import "../css/app.css";

const App = () => (
  <Router>
      <div>
        <Toaster
          position="bottom-right"
          toastOptions={{
            duration: 3000,
            className: "toastr dark",
          }}
        />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/:topicSlug/*" element={<Home />} />
        </Routes>
      </div>
    </Router>
);

const root = ReactDOM.createRoot(document.getElementById("app"));

// Wrap with StrictMode only in development
if (process.env.NODE_ENV === "development") {
  root.render(
    <React.StrictMode>
      <App />
    </React.StrictMode>
  );
} else {
  root.render(<App />);
}