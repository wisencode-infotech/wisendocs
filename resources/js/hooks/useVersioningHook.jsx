import { useState, useEffect } from "react";

// Custom hook for versioning
const useVersioningHook = (initialVersion = null, fetchVersions) => {
  const [availableVersions, setAvailableVersions] = useState([]);
  const [currentVersion, setCurrentVersion] = useState(initialVersion);

  useEffect(() => {
    const loadVersions = async () => {
      if (typeof fetchVersions === "function") {
        try {
          const versions = await fetchVersions();  // Call the passed function
          setAvailableVersions(versions);
          setCurrentVersion(versions[0]?.id || null); // Set the first version by default
        } catch (error) {
          console.error("Error loading versions:", error);
        }
      }
    };

    loadVersions();
  }, [fetchVersions]);  // Dependency on fetchVersions function

  return {
    availableVersions,
    currentVersion,
    setCurrentVersion,
  };
};

export default useVersioningHook;