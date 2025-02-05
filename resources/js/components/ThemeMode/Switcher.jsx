import React, { useState, useEffect } from "react";

const ThemeSwitcher = () => {
  const [isDarkMode, setIsDarkMode] = useState(false);

  // Set the initial theme from localStorage or default to light
  useEffect(() => {
    const savedTheme = localStorage.getItem("wisendocs-theme-mode");
    if (savedTheme) {
      setIsDarkMode(savedTheme === "dark");
    }
  }, []);

  // Toggle theme and save it to localStorage
  const toggleTheme = () => {
    setIsDarkMode((prevMode) => {
      const newMode = !prevMode;
      localStorage.setItem("wisendocs-theme-mode", newMode ? "dark" : "light"); // Save to localStorage
      return newMode;
    });
  };

  // Apply theme class to the body element
  useEffect(() => {
    if (isDarkMode) {
      document.body.classList.add("dark");
    } else {
      document.body.classList.remove("dark");
    }
  }, [isDarkMode]);

  return (
    <button
      onClick={toggleTheme}
      className="ml-4 p-2 rounded-full text-gray-300 hover:text-gray-500"
      aria-label="Toggle Theme"
    >
      {isDarkMode ? (
        <i className="fa-solid fa-sun"></i> // Sun icon for light mode
      ) : (
        <i className="fa-solid fa-moon"></i> // Moon icon for dark mode
      )}
    </button>
  );
};

export default ThemeSwitcher;