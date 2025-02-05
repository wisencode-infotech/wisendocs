import React, { useState } from "react";
import ImageModal from "./ImageModal"; // Import the ImageModal component

const ScreenshotGallery = ({ images, maxVisible = 2 }) => {
  const [currentIndex, setCurrentIndex] = useState(0); // State to track the current image index
  const [isModalOpen, setIsModalOpen] = useState(false); // State to track modal visibility

  const openModal = (index) => {
    setCurrentIndex(index);
    setIsModalOpen(true); // Open the modal when clicking on a thumbnail
  };

  const closeModal = () => {
    setIsModalOpen(false); // Close the modal
  };

  const visibleImages = images.slice(0, maxVisible); // Get the visible images up to maxVisible

  return (
    <div className="screenshot-gallery">
      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        {visibleImages.map((image, index) => (
          <div
            key={index}
            className="relative aspect-w-4 aspect-h-6 sm:aspect-h-7 md:aspect-h-5 cursor-pointer"
            onClick={() => openModal(index)}
          >
            <img
              src={image.imageUrl}
              alt={image.title}
              className="w-full h-full object-cover rounded-lg shadow-md"
            />
            <div className="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 hover:bg-opacity-70 rounded-lg">
              <i className="fas fa-eye text-white text-lg sm:text-xl md:text-2xl mb-1 sm:mb-2"></i>
              <p className="text-white text-xs sm:text-sm md:text-base text-center">{image.title}</p>
            </div>

            {/* Show the "+x more images" indicator only on the last visible image */}
            {index === visibleImages.length - 1 && images.length > maxVisible && (
              <div className="absolute inset-0 flex items-center justify-center bg-black bg-opacity-70 rounded-lg">
                <span className="text-xl sm:text-2xl text-white font-bold">
                  +{images.length - maxVisible}
                </span>
              </div>
            )}
          </div>
        ))}
      </div>

      {isModalOpen && (
        <ImageModal
          isOpen={isModalOpen}
          imageUrl={images[currentIndex].imageUrl}
          title={images[currentIndex].title}
          description={images[currentIndex].description}
          closeModal={closeModal}
          showNextImage={() => setCurrentIndex((prev) => (prev + 1) % images.length)}
          showPreviousImage={() => setCurrentIndex((prev) => (prev - 1 + images.length) % images.length)}
          isSingleImage={images.length === 1}
        />
      )}
    </div>
  );
};

export default ScreenshotGallery;