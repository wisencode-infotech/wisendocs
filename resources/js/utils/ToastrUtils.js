import toast from 'react-hot-toast';
import '../../css/toastr-styling.css';

export const showToast = (message, type = 'success', props = {}) => {
  console.log(props)
  const options = {
    duration: props.duration ? props.duration : 3000,
    position: 'bottom-right',
    className: 'toastr dark',
  };

  switch (type) {
    case 'success':
      toast.success(message, options);
      break;
    case 'error':
      toast.error(message, options);
      break;
    case 'info':
      toast(message, options);
      break;
    case 'warning':
      toast(message, { ...options, className: 'toastr warning' }); 
      break;
    default:
      toast(message, options);
  }
};