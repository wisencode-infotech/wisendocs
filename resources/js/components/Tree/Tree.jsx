import React, { useState, useEffect, useRef } from 'react';

const Tree = ({ nodes }) => {
  const initializeExpandedNodes = (nodes) => {
    const expanded = {};
    const setExpandedRecursively = (nodes, path = '') => {
      nodes.forEach((node, index) => {
        const nodeId = `${path}-${node.label}-${index}`; // Unique identifier with path
        expanded[nodeId] = true; // Set all nodes to true (expanded) by default
        if (node.children) {
          setExpandedRecursively(node.children, nodeId); // Recurse for children
        }
      });
    };

    setExpandedRecursively(nodes);
    return expanded;
  };

  const [expandedNodes, setExpandedNodes] = useState(initializeExpandedNodes(nodes));
  const [showPopup, setShowPopup] = useState(null); // Track which node's popup should be shown
  const popupRef = useRef(null); // Ref for the popup container
  const treeContainerRef = useRef(null); // Ref for the tree container

  // Close the popup when clicked outside
  useEffect(() => {
    const handleClickOutside = (event) => {
      // Close popup only if clicked outside the popup and tree container
      if (
        treeContainerRef.current && !treeContainerRef.current.contains(event.target) &&
        popupRef.current && !popupRef.current.contains(event.target)
      ) {
        setShowPopup(null); // Close the popup if clicked outside
      }
    };

    document.addEventListener('click', handleClickOutside);

    return () => {
      document.removeEventListener('click', handleClickOutside);
    };
  }, []);

  const handleToggle = (nodeId) => {
    setExpandedNodes((prev) => ({
      ...prev,
      [nodeId]: !prev[nodeId],
    }));
  };

  const renderTree = (nodes, level = 0, path = '') => {
    return nodes.map((node, index) => {
      const nodeId = `${path}-${node.label}-${index}`; // Unique ID considering parent path
      const isExpanded = expandedNodes[nodeId];
      const hasChildren = node.children && node.children.length > 0;
  
      return (
        <div key={nodeId} className="node text-sm text-gray-900 dark:text-gray-200">
          <div
            className={`node-header flex items-center cursor-pointer p-1 rounded-md hover:bg-theme.accent dark:hover:bg-theme.darkBackground transition-colors ${level > 0 ? 'pl-4' : ''}`}
            onClick={() => hasChildren && handleToggle(nodeId)}
          >
            {hasChildren ? (
              <i
                className={`fas ${isExpanded ? 'fa-chevron-down' : 'fa-chevron-right'} mr-3 text-gray-400 dark:text-gray-200 transition-transform duration-200`}
              />
            ) : (
              <i className="fa-regular fa-circle mr-3 text-gray-400 dark:text-gray-200" />
            )}
  
            <i className={`${node.icon} mr-3 text-gray-900 dark:text-gray-200`} />
            <span className="text-theme.lightText dark:text-theme.lightText">{node.label}</span>
  
            {/* Render Tags if available */}
            {node.tags && node.tags.length > 0 && (
              <div className="ml-2 flex flex-wrap gap-1">
                {node.tags.map((tag, tagIndex) => (
                  <span
                    key={tagIndex}
                    className="bg-red-500 text-white rounded-full px-3 py-1 text-xs font-medium dark:bg-red-700 dark:text-white"
                  >
                    {tag}
                  </span>
                ))}
              </div>
            )}
  
            {/* If info exists, show info icon to toggle popup */}
            {node.info && (
              <i
                className="fa fa-info-circle ml-2 text-gray-500 dark:text-gray-300 hover:text-theme.accent transition-colors cursor-pointer"
                onClick={(e) => {
                  e.stopPropagation(); // Prevent the click from triggering the toggle function
                  setShowPopup(showPopup === nodeId ? null : nodeId); // Toggle popup visibility
                }}
              />
            )}
          </div>
  
          {/* Show child nodes if expanded */}
          {hasChildren && isExpanded && (
            <div className="children ml-6 border-l-2 border-theme.lightBorder dark:border-theme.darkBorder pl-4 mt-1">
              {renderTree(node.children, level + 1, nodeId)} {/* Pass current nodeId as path */}
            </div>
          )}
  
          {/* Popup info */}
          {showPopup === nodeId && node.info && (
          <div
            ref={popupRef}
            className="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-90 z-50"
            onClick={(e) => e.stopPropagation()} // Prevent closing when clicking on the popup itself
          >
            <div
              className="bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200 p-4 rounded-md shadow-lg max-w-md w-auto relative mx-4 sm:mx-8"
              style={{ whiteSpace: 'pre-line' }} // Preserve white space in the description
            >
              {/* Close Button aligned to the title */}
              <button
                onClick={() => setShowPopup(null)} // Close popup on button click
                className="absolute top-2 right-2 text-gray-500 dark:text-gray-200 hover:text-theme.accent dark:hover:text-theme.lightText"
              >
                <i className="fa fa-times"></i>
              </button>

              {/* Title */}
              {node.info.title && (
                <h4 className="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{node.info.title}</h4> // Reduced top margin
              )}

              {/* Description - Render HTML safely using dangerouslySetInnerHTML */}
              {node.info.description && (
                <p
                  className="text-gray-700 dark:text-gray-300"
                  dangerouslySetInnerHTML={{ __html: node.info.description }}
                />
              )}
            </div>
          </div>
        )}
        </div>
      );
    });
  };

  return (
    <div ref={treeContainerRef} className="bg-theme.lightBackground dark:bg-theme.darkBackground rounded-lg shadow-sm p-4 border border-theme.lightBorder dark:border-theme.darkBorder w-full max-w-full relative overflow-hidden">
      <div className="tree-structure overflow-x-auto">{renderTree(nodes)}</div>
    </div>
  );
};

export default Tree;