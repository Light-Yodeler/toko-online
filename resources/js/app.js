import './bootstrap';
import Swal from 'sweetalert2';
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// after input notify
$(function () {
  if (window.flashMessage && window.flashMessage.message) {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end', // pojok kanan atas
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });

    Toast.fire({
      icon: window.flashMessage.type || 'info',
      title: window.flashMessage.message
    });
  }
});