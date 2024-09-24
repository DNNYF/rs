/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/page-script.js ***!
  \*************************************/
document.addEventListener('DOMContentLoaded', function () {
  var specializationSelect = document.getElementById('spesialis');
  var specializationForm = document.getElementById('spesialis-form');
  specializationSelect.addEventListener('change', function () {
    if (this.value === 'Spesialis') {
      specializationForm.style.display = 'block';
    } else {
      specializationForm.style.display = 'none';
    }
  });
});
/******/ })()
;