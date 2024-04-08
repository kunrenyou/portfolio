"use strict";
/****************************************
pagetopボタンをスクロールごとに変化させる
****************************************/
window.addEventListener("scroll", function () {
  const elm = document.querySelector(".btn1");
  const scroll = window.pageYOffset;
  if (scroll < 300) {
    elm.style.opacity = "1";
    elm.style.zIndex = "1";
  } else if (scroll < 1200) {
    elm.style.opacity = "0.7";
    elm.style.zIndex = "2";
  }
});
