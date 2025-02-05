import React from 'react';

const Title = ({ text, level = 'h5', classNames = '' }) => {
  const TitleTag = level; // Dynamically change the tag (h1, h2, h3, etc.)

  return (
    <TitleTag className={`${classNames}`}>
      {text}
    </TitleTag>
  );
};

export default Title;