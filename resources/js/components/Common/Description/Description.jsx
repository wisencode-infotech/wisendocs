import React from 'react';

const Description = ({ content, classNames = '' }) => {
  // Process the content to convert newlines to <br />
  const formattedContent = content.replace(/\n/g, '<br />');

  return (
    <p
      className={`${classNames}`}
      dangerouslySetInnerHTML={{ __html: formattedContent }}
    ></p>
  );
};

export default Description;