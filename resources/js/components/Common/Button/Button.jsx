import React from 'react';
import PropTypes from 'prop-types';

const Button = ({
  text,
  onClick,
  size = 'medium',
  color = 'primary',
  disabled = false,
  loading = false,
  fullWidth = false,
  icon = null,
  classNames = '',
  type = 'button', // 'button', 'submit', 'reset'
  onHover = '', // Add onHover prop to handle hover classes
  ...props
}) => {
  // Determine button styles based on props
  const sizeStyles = {
    small: 'px-4 py-2 text-sm',
    medium: 'px-6 py-3 text-base',
    large: 'px-8 py-4 text-lg',
  };

  const colorStyles = {
    themeLight: 'bg-theme-dark dark:bg-theme-light hover:bg-theme-light dark:hover:bg-theme-dark text-theme-light dark:text-theme-dark hover:text-theme-dark dark:hover:text-theme-light',
    themeDark: 'bg-theme-light dark:bg-theme-dark hover:bg-theme-dark dark:hover:bg-theme-light text-theme-dark dark:text-theme-light hover:text-theme-light dark:hover:text-theme-dark',
    primary: 'bg-blue-600 dark:bg-blue-500 hover:bg-blue-500 dark:hover:bg-blue-600 text-white',
    secondary: 'bg-gray-600 dark:bg-gray-500 hover:bg-gray-500 dark:hover:bg-gray-600 text-white',
    danger: 'bg-red-600 dark:bg-red-500 hover:bg-red-500 dark:hover:bg-red-600 text-white',
    success: 'bg-green-600 dark:bg-green-500 hover:bg-green-500 dark:hover:bg-green-600 text-white',
    outline: 'border-2 border-blue-600 dark:border-blue-500 text-blue-600 dark:text-blue-500 hover:bg-blue-200 dark:hover:bg-blue-100',
  };

  const buttonClassNames = `
    ${sizeStyles[size]} 
    ${colorStyles[color]} 
    ${disabled ? 'opacity-50 cursor-not-allowed' : ''} 
    ${fullWidth ? 'w-full' : ''} 
    ${onHover ? `${onHover}` : ''}
    ${classNames}
    inline-flex items-center justify-center rounded-lg font-semibold transition-all duration-300
  `;

  return (
    <button
      type={type}
      onClick={onClick}
      className={buttonClassNames}
      disabled={disabled || loading}
      {...props}
    >
      {loading ? (
        <span className="spinner-border spinner-border-sm text-white" role="status"></span>
      ) : (
        <>
          {icon && <span className="mr-2"><i className={icon}></i></span>}
          {text}
        </>
      )}
    </button>
  );
};

Button.propTypes = {
  text: PropTypes.string.isRequired,
  onClick: PropTypes.func,
  size: PropTypes.oneOf(['small', 'medium', 'large']),
  color: PropTypes.oneOf(['primary', 'secondary', 'danger', 'success', 'outline']),
  disabled: PropTypes.bool,
  loading: PropTypes.bool,
  fullWidth: PropTypes.bool,
  icon: PropTypes.node,
  classNames: PropTypes.string,
  onHover: PropTypes.string,
  type: PropTypes.oneOf(['button', 'submit', 'reset']),
};

export default Button;