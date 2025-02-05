import React from "react";
import Subtitle from "../Subtitle/Subtitle";
import { useNavigate } from "react-router-dom";
import Button from "../Button/Button";
import Description from "../Description/Description";

const NoDataFoundTemplate = ({ heading, description = '', icon = '' }) => {

  const navigate = useNavigate();

  return (
    <main className="bg-theme-light dark:bg-theme-dark"> 
      {/* Centered Popup */}
      <div className="absolute inset-0 flex items-center justify-center">
        <div className="bg-theme-light dark:bg-theme-dark rounded-xl shadow-lg p-8 max-w-md w-full text-center">

          <div className="mb-4">
            <Subtitle 
              text={`<span><i class="${icon}"></i></span>`} 
              classNames="text-4xl font-semibold text-gray-400 mb-8" 
            />
          </div>

          {heading && (
            <Subtitle 
              text={heading} 
              classNames="text-sm font-semibold text-gray-400 mb-8" />
          )}

          {description && (
            <Description 
              content={description}
              classNames="text-xs text-gray-400 mt-2" />
          )}

          <div>
            <Button 
              text={'Go home'} 
              onClick={() => navigate('/')}  // Redirect to home page
              size="small" 
              classNames='mt-4'
              color='themeLight'
              icon={'fa fa-home'} 
            />
          </div>
        </div>
      </div>
    </main>
  );
};

export default NoDataFoundTemplate;