// src/components/List/List.jsx
import React from 'react';

const List = ({ items }) => {
  return (
    <ul className="list-disc pl-6 text-gray-900 dark:text-gray-400">
      {items.map((item, index) => (
        <li key={index} className="mb-2" dangerouslySetInnerHTML={{ __html: item }}></li>
      ))}
    </ul>
  );
};

export default List;
