import React from 'react';

const CustomLink = ({ attributes, children, ...props }) => {
  if (!attributes || typeof attributes !== 'object') {
    return null; // Handle case where attributes are not provided or invalid
  }

  const { title, url, icon, underline = true, new_tab = false, classes } = attributes;

  return (
    <a
      href={url || '#'}
      title={title || ''}
      className={`${classes || ''} ${underline ? 'underline' : 'no-underline'}`}
      target={new_tab ? '_blank' : '_self'} // Open in new tab if new_tab is true
      rel={new_tab ? 'noopener noreferrer' : undefined} // Add security attributes for new tabs
      {...props} // Pass additional props dynamically
    >
      {icon && <i className={`${icon} mr-2`}></i>}
      {children || title || 'Click here'}
    </a>
  );
};

export default CustomLink;