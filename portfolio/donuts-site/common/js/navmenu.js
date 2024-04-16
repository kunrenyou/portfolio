'use strict';
$(document).ready(function () {
  const navBtn = $('.navbtn');
  const menu = $('#wrapper');
  navBtn.on('click', function () {
    menu.toggleClass('active');
  });
});
