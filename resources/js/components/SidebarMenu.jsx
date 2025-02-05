import React, { useEffect } from "react";
import { Link } from "react-router-dom";

const SidebarMenu = ({ topicSlug, menus, selectedVersion, toggleSidebar }) => {
  const activeTopic = menus.find((topic) => topic.slug === topicSlug);

  useEffect(() => {
    const appName = window.APP_NAME || "Your App Name"; // Fallback to a default name
    document.title = activeTopic
      ? `${activeTopic.name} - ${appName}`
      : appName;
  }, [activeTopic]);

  const handleMenuClick = (slug) => {
    toggleSidebar();
  };

  return (
    <nav className="space-y-1">
      {menus.map((topic) => {
        const isActive = topic.slug === topicSlug;
        return (
          <Link
            key={topic.id}
            to={`/${topic.slug}`}
            onClick={() => handleMenuClick(topic.slug)}
            className={`flex items-center space-x-3 py-3 px-4 rounded-lg ${
              isActive
                ? "bg-theme-dark text-lightText dark:bg-theme-light dark:text-gray-500"
                : "text-gray-400 dark:text-gray-300"
            }`}
          >
            <i className="fa-solid fa-arrow-right"></i>
            <span>{topic.name}</span>
          </Link>
        );
      })}
    </nav>
  );
};

export default SidebarMenu;