import React from 'react';
import { showToast } from '../../utils/ToastrUtils';


const CodeBlock = ({ title, description, buttonText, copyContent }) => {

  // Function to handle content copy and show toast
  const handleCopy = () => {
    navigator.clipboard.writeText(copyContent);
    showToast('Copied to clipboard!', 'success');
  };

  return (
    <div className="bg-theme-light dark:bg-theme-dark text-gray-100 rounded-lg shadow-lg overflow-hidden">
      {/* Header Section */}
      <div className="flex justify-between items-center px-4 py-3 bg-white border-b border-theme-dark">
        <span className="text-sm font-semibold text-gray-900">{title}</span>
        <button
          onClick={handleCopy}
          className="text-sm bg-gray-800 hover:bg-gray-700 text-white px-3 py-1 rounded focus:outline-none focus:ring-1 focus:ring-theme-accent"
        >
          {buttonText}
        </button>
      </div>

      {/* Description Section */}
      <div className="p-4 bg-gray-700 text-sm text-white font-mono leading-relaxed text-left whitespace-pre-line">
        {description}
      </div>
    </div>
  );
};

export default CodeBlock;