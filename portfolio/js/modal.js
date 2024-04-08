"use strict";
/****************************************
    portfolio-modal 1
****************************************/
const modal = document.getElementById("modal1");
const close = document.querySelector(".modalClose");
// console.log("modal1");
document.getElementById("gallery1").onclick = function () {
  modal.style.display = "block";
};
close.addEventListener("click", function () {
  // body.classList.remove('inactive');
  modal.style.display = "none";
});
