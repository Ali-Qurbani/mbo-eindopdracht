/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
var admin_page_img_input = document.getElementById('admin_page_img_input');

if (admin_page_img_input) {
  var showPreview = function showPreview() {
    var src = URL.createObjectURL(admin_page_img_input.files[0]);
    var preview = document.getElementById("form_profile_picture");
    preview.src = src;
  };

  admin_page_img_input.addEventListener("change", showPreview);
}
/******/ })()
;