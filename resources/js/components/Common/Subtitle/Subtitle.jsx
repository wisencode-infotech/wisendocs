import React from 'react';

const Subtitle = ({ text, classNames = '' }) => {
  
  return (
    <span 
      className={`${classNames}`}
      dangerouslySetInnerHTML={{ __html: text }}>
    </span>
  );
};

export default Subtitle;
