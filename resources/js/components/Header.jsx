import React, { useState } from "react";
import Versioning from "../utils/Versioning";
import Search from "../utils/Search";
import logoDark from "../../logos/logo-dark.png";
import ThemeModeSwitcher from "./ThemeMode/Switcher";

const Header = ({ availableVersions, currentVersion, setCurrentVersion, toggleSidebar }) => {
  const [isSearchOpen, setIsSearchOpen] = useState(false);
  console.log(availableVersions);

  return (
    <header className="bg-theme-light dark:bg-theme-dark dark:text-theme-darkText text-theme-lightText shadow-lg sticky top-0 z-10">
      <div className="container mx-auto flex items-center justify-between px-6 py-4">
        {/* Left section: Logo */}
        <div className="flex items-center justify-between w-full sm:w-auto">
          <a href="/">
            <img src={logoDark} alt="Dark Logo" className="h-8" />
          </a>
        </div>

        {/* Middle section: Search */}
        <div className="hidden lg:flex flex-grow max-w-md mx-4">
          <button
            className="w-full px-4 py-2 bg-theme-lightBackground dark:bg-theme-darkBackground rounded-lg text-theme-lightText dark:text-theme-darkText focus:outline-none focus:ring-1 focus:ring-theme"
            aria-label="Toggle Search"
            onClick={() => setIsSearchOpen(!isSearchOpen)}
          >
            <i className="fa-solid fa-search"></i> Search
          </button>
        </div>

        {/* Middle section: Search */}
        <div className="sm:hidden flex items-center space-x-2">
          {/* Search Button (on mobile only) */}
          <button
            className="px-2 py-1 bg-theme-lightBackground dark:bg-theme-darkBackground rounded-lg text-theme-lightText dark:text-theme-darkText focus:outline-none focus:ring-1 focus:ring-theme"
            onClick={() => setIsSearchOpen(!isSearchOpen)}
            aria-label="Toggle Search"
          >
            <i className="fa-solid fa-search"></i>
          </button>

          {/* Versioning and ThemeModeSwitcher on mobile */}
          <Versioning
            availableVersions={availableVersions}
            currentVersion={currentVersion}
            onChangeVersion={setCurrentVersion}
          />
          <ThemeModeSwitcher />
          <button
            className="block sm:hidden text-theme-lightText dark:text-theme-darkText"
            onClick={toggleSidebar}
          >
            <i className="fas fa-bars" aria-hidden="true"></i>
          </button>
        </div>

        {/* Right section: Versioning and ThemeSwitcher for larger screens */}
        <div className="hidden sm:flex items-center space-x-4">
          <Versioning
            availableVersions={availableVersions}
            currentVersion={currentVersion}
            onChangeVersion={setCurrentVersion}
          />
          <ThemeModeSwitcher />
        </div>
      </div>

      {/* Search Component for Mobile */}
      {isSearchOpen && (
        <Search
          currentVersion={currentVersion}
          isSearchOpen={isSearchOpen}
          setIsSearchOpen={setIsSearchOpen}
        />
      )}
    </header>
  );
};

export default Header;