import React, { useState } from "react";
import axios from "axios";
import Header from "../components/Header";
import Sidebar from "../components/Sidebar";
import ContentSection from "../components/ContentSection";
import Footer from "../components/Footer";
import { useParams } from "react-router-dom";
import useVersioningHook from "../hooks/useVersioningHook";

const fetchVersions = async () => {
  try {
    const response = await axios.get("/api/versions");
    return response.data;
  } catch (error) {
    console.error("Error fetching versions:", error);
    return [];
  }
};

const Home = () => {
  const { topicSlug } = useParams();
  const { availableVersions, currentVersion, setCurrentVersion } = useVersioningHook(null, fetchVersions);
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);

  return (
    <div className="min-h-screen flex flex-col">
      <Header
        availableVersions={availableVersions}
        currentVersion={currentVersion}
        setCurrentVersion={setCurrentVersion}
        toggleSidebar={() => setIsSidebarOpen(!isSidebarOpen)}
      />
      <div className="flex flex-col lg:flex-row flex-grow">
        <Sidebar
          topicSlug={topicSlug}
          currentVersion={currentVersion}
          isSidebarOpen={isSidebarOpen}
          toggleSidebar={() => setIsSidebarOpen(!isSidebarOpen)}
        />
        <ContentSection topicSlug={topicSlug} currentVersion={currentVersion} />
      </div>
      <Footer />
    </div>
  );
};

export default Home;