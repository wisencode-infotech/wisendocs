import React from 'react';

const HorizontalLine = ({ 
  height = '1px', 
  color = 'gray', 
  opacity = 1, 
  margin = '0', 
  width = '100%' 
}) => {
  const style = {
    height,
    backgroundColor: color,
    opacity,
    margin,
    width,
  };

  return <div style={style} />;
};

export default HorizontalLine;