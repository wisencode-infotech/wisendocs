import React, { useState, useEffect } from "react";
import axios from "axios";
import SidebarMenu from "./SidebarMenu";
import { ScaleLoader } from "react-spinners";

const Sidebar = ({ topicSlug, currentVersion, isSidebarOpen, toggleSidebar }) => {
  const [menus, setMenus] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchTopics = async () => {
      if (!currentVersion) return;

      setIsLoading(true);
      setError(null);

      try {
        const response = await axios.get(`/api/version/${currentVersion}/topics/all`);
        setMenus(response.data);
      } catch (error) {
        setError("Failed to load topics.");
        console.error("Error fetching topics:", error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchTopics();
  }, [currentVersion]);

  return (
    <>
      <aside
        className={`bg-theme-light dark:bg-theme-dark w-4/5 lg:w-1/5 min-h-screen fixed lg:static top-0 left-0 p-4 shadow-lg border-r border-opacity-10 border-theme-light dark:border-theme-dark
          transform transition-transform ${
            isSidebarOpen ? "translate-x-0" : "-translate-x-full"
          } overflow-y-auto lg:translate-x-0 lg:z-auto z-50 flex flex-col`}
      >
        {/* Main content in the sidebar */}
        {isLoading ? (
          <div className="loader text-center">
            <ScaleLoader color="#3d5f8a" loading height={20} margin={2} radius={13} speedMultiplier={2} />
          </div>
        ) : error ? (
          <div className="text-red-600">{error}</div>
        ) : (
          <SidebarMenu
            topicSlug={topicSlug}
            menus={menus}
            selectedVersion={currentVersion}
            toggleSidebar={toggleSidebar} // Pass the toggleSidebar function to SidebarMenu
          />
        )}

        <div className="flex-grow" />

        {/* Help section at the bottom */}
        <div className="pt-2 border-t border-gray-100 dark:border-gray-700 text-sm text-theme-dark dark:text-theme-light">
          <h1 className="text-center mb-4">Need Help?</h1>
          <div className="flex justify-center items-center mt-4 space-x-2">
            <span><i className="fa fa-envelope"></i> wisencode.info@gmail.com</span>
            <span><i className="fa fa-phone"></i> +91 8238136154</span>
          </div>
        </div>
      </aside>

      {/* Overlay when sidebar is open on mobile/tablet */}
      <div
        className={`fixed inset-0 bg-black bg-opacity-50 transition-opacity z-40 lg:hidden ${
          isSidebarOpen ? "opacity-100" : "opacity-0 pointer-events-none"
        }`}
        onClick={toggleSidebar}
      />
    </>
  );
};

export default Sidebar;