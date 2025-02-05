import React from "react";

const Versioning = ({ availableVersions, currentVersion, onChangeVersion }) => {
  return (availableVersions.length > 1 && 
    <div className="relative w-full max-w-xs">
      <select
        className="bg-theme-lightBackground dark:bg-theme-darkBackground text-theme-lightText dark:text-theme-darkText rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-1 focus:ring-theme appearance-none text-sm sm:text-base w-full"
        value={currentVersion || ""}
        onChange={(e) => onChangeVersion(e.target.value)}
      >
        {availableVersions.map((version) => (
          <option key={version.id} value={version.id}>
            Version {version.identifier}
          </option>
        ))}
      </select>
      <span className="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <i className="fa-solid fa-chevron-down text-theme-lightText dark:text-theme-darkText"></i>
      </span>
    </div>
  );
};

export default Versioning;