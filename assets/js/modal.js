// ajax_fun.bootstrapModal = function(){
//     $(document).ready(function(){
//
//       var page = window.location.href;
//   		page = page.substring(page.lastIndexOf("/")+ 1);
//   		page = (page.match(/[^.]+(\.[^?#]+)?/) || [])[0];
//
//       if(page != 'fiscal-years'){
//       	$("#atmodal").modal().css({
//             'margin-top': function () {
//                 return (($(window).height()-$(this).height()) / 2 );
//             }
//         });
//       }
//     });
// };

$(document).ready(function(){
  $('.modal').modal();
  $('#setup-wizard').modal({ 'dismissible' : false });
  $('#setup-wizard').modal('open');
  $("[name=msg-allert]").html("");
  $('ul.tabs').tabs({
    // swipeable : true,
    // responsiveThreshold : 1920
  });
});
