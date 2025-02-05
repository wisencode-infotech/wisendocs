import React, { useState, useEffect } from "react";

const ImageModal = ({
  isOpen,
  imageUrl,
  title,
  description,
  closeModal,
  showNextImage,
  showPreviousImage,
  isSingleImage
}) => {
  const [zoomLevel, setZoomLevel] = useState(1); // Zoom level state
  const [offset, setOffset] = useState({ x: 0, y: 0 }); // Offset state for moving the image

  useEffect(() => {
    // Reset zoom and offset when modal is opened
    if (isOpen) {
      setZoomLevel(1);
      setOffset({ x: 0, y: 0 });
    }
  }, [isOpen]);

  // Zoom in
  const zoomIn = () => {
    setZoomLevel((prevZoom) => Math.min(prevZoom + 0.1, 3)); // Max zoom level 3
  };

  // Zoom out
  const zoomOut = () => {
    setZoomLevel((prevZoom) => Math.max(prevZoom - 0.1, 1)); // Min zoom level 1
  };

  // Reset zoom and offset
  const resetZoom = () => {
    setZoomLevel(1);
    setOffset({ x: 0, y: 0 });
  };

  // Move image when zoomed in
  const moveImage = (e) => {
    if (zoomLevel > 1) {
      const newOffset = {
        x: e.clientX - e.target.offsetWidth / 2,
        y: e.clientY - e.target.offsetHeight / 2,
      };
      setOffset(newOffset);
    }
  };

  // Prevent the modal from closing when clicking inside the modal content
  const stopPropagation = (e) => e.stopPropagation();

  if (!isOpen) return null; // If modal is not open, don't render it

  return (
    <div
      className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50"
      onClick={closeModal}
    >
      <div
        className="relative bg-theme-lightBackground dark:bg-theme-darkBackground w-[80vw] max-w-[90vw] h-[80vh] max-h-[90vh] md:w-[70vw] md:max-w-[80vw] md:h-[80vh] md:max-h-[80vh] lg:w-[50vw] lg:max-w-[60vw] lg:h-[70vh] lg:max-h-[80vh] flex flex-col justify-between"
        onClick={stopPropagation} // Prevent closing modal on content click
      >
        {/* Header with Title and Description */}
        <div className="mb-0 bg-theme-darkBackground dark:bg-gray-600 bg-opacity-75 p-2">
          <h3 className="text-xl text-white font-bold">{title}</h3>
          <p className="text-sm text-gray-300">{description}</p>
        </div>

        {/* Image */}
        <div
          className="relative w-full h-full overflow-hidden"
          onMouseMove={moveImage}
          style={{ cursor: zoomLevel > 1 ? "move" : "default" }}
        >
          <img
            src={imageUrl}
            alt={title}
            className="rounded-b-lg w-full h-full object-contain"
            style={{
              transform: `scale(${zoomLevel}) translate(${offset.x}px, ${offset.y}px)`,
              transition: "transform 0.3s ease",
            }}
            onClick={resetZoom} // Reset zoom when clicked
          />
        </div>

        {/* Navigation Controls (Show when more than one image) */}
        {!isSingleImage && (
          <>
            <button
              className="absolute top-1/2 left-4 transform -translate-y-1/2 text-white bg-gray-700 hover:bg-gray-600 rounded-full p-1 px-3"
              onClick={showPreviousImage}
            >
              <i className="fas fa-chevron-left text-2xl"></i>
            </button>
            <button
              className="absolute top-1/2 right-4 transform -translate-y-1/2 text-white bg-gray-700 hover:bg-gray-600 rounded-full p-1 px-3"
              onClick={showNextImage}
            >
              <i className="fas fa-chevron-right text-2xl"></i>
            </button>
          </>
        )}

        {/* Close Button */}
        <button
          className="absolute top-1 right-2 text-white hover:text-gray-300 p-1 px-3"
          onClick={closeModal}
        >
          <i className="fas fa-times"></i>
        </button>

        {/* Zoom Controls */}
        <div
          className="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-4 bg-gray-800 bg-opacity-80 p-2 rounded-lg"
        >
          <button
            onClick={zoomIn}
            className="text-white hover:text-green-400 transition"
            title="Zoom In"
          >
            <i className="fas fa-search-plus text-lg"></i>
          </button>
          <button
            onClick={zoomOut}
            className="text-white hover:text-red-400 transition"
            title="Zoom Out"
          >
            <i className="fas fa-search-minus text-lg"></i>
          </button>
          <button
            onClick={resetZoom}
            className="text-white hover:text-blue-400 transition"
            title="Reset Zoom"
          >
            <i className="fas fa-sync text-lg"></i>
          </button>
        </div>
      </div>
    </div>
  );
};

export default ImageModal;