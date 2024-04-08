"use strict";
// setInterval,clearIntervalの関数
let id;
let paused = false;
let time = 0;
document.getElementById("hour").textContent = "00 :";
document.getElementById("min").textContent = "00 :";
document.getElementById("sec").textContent = "00";
// 入力された要素を取得
const th = document.getElementById("hcount");
const ts = document.getElementById("scount");
const tm = document.getElementById("mcount");
const input = document.getElementById("start");
// Startボタンを押したとき
function clickStart() {
  input.disabled = true;
  // 2回連続でStartボタンを押したとき
  if (!paused) {
    // startを押したとき秒数の取得
    time = Number(th.value) * 3600 + Number(tm.value) * 60 + Number(ts.value);
    setTime(time);
  }
  id = setInterval(function () {
    time--;
    setTime(time);
    if (time <= 0) {
      clearInterval(id);
      $("#flash").addClass("flash");
    }
  }, 1000);
}
// Resetボタンを押したとき
function clickReset() {
  clearInterval(id);
  paused = false;
  input.disabled = false;
  // 入力テキストを初期値にする
  th.value = "";
  tm.value = "";
  ts.value = "";
  setTime(0);
  $("#flash").removeClass("flash");
}
// Stopボタンを押したとき
function clickStop() {
  clearInterval(id);
  paused = true;
  input.disabled = false;
}
function setTime(time) {
  let countsec = Math.floor(time) % 60;
  let countmin = Math.floor(time / 60) % 60;
  let counthour = Math.floor(time / 60 / 60) % 24;
  const colon = " :";
  document.getElementById("sec").textContent = String(countsec).padStart(
    2,
    "0"
  );
  document.getElementById("min").textContent =
    String(countmin).padStart(2, "0") + colon;
  document.getElementById("hour").textContent =
    String(counthour).padStart(2, "0") + colon;
}
