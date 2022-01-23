require('./bootstrap');

require('alpinejs');

window.Echo.private('App.Models.User.${USERID}')
   .notification(function (notificnation) {
      let count = Number($('#notificationCount').text())
      count++;
      $('#notificationCount').text(count); 
      $('#notifications').prepend('<a class="dropdown-item d-flex align-items-center" href="${notification.action}">
         < div class= "mr-3" >
          <div class="icon-circle bg-primary">
            <i class="fas fa-file-alt text-white"></i>
          </div>
       </div >
         <div>
            <div class="small text-gray-500">${notification.time}</div>
            <span class="font-weight-bold">${notification.message}</span>
         </div>
   </a > ')
       //alert(notification.message)

    });
