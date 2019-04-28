/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/business.js":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/user-action.js");

var map;

window.initMap = function () {
  map = new google.maps.Map(document.getElementById('map'), {
    center: geopoints,
    zoom: 15,
    disableDefaultUI: true
  });
  var marker = new google.maps.Marker({ position: geopoints, map: map });
};
$('.form__rating input').change(function () {
  var $radio = $(this);
  $('.form__rating .selected').removeClass('selected');
  $radio.closest('label').addClass('selected');
});

/***/ }),

/***/ "./resources/assets/js/user-action.js":
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

window.UserAction = function () {
    function UserAction() {
        _classCallCheck(this, UserAction);
    }

    _createClass(UserAction, null, [{
        key: 'token',
        value: function token() {
            return document.querySelector("meta[name=csrf-token]").getAttribute('content');
        }
    }, {
        key: 'sendRequest',
        value: function sendRequest(el, url) {
            var _this = this;

            var xhttp = new XMLHttpRequest();
            xhttp.responseType = 'json';
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    var json = xhttp.response;
                    if (json.action == "vote") _this.updateVoteCount(el, json);
                }
            };
            xhttp.open("POST", url);
            xhttp.setRequestHeader("X-CSRF-TOKEN", this.token());
            xhttp.send();
        }
    }, {
        key: 'updateVoteCount',
        value: function updateVoteCount(el, json) {
            var profileActionEl = el.parentElement;
            var upvoteEl = profileActionEl.querySelector('.upvote_stat');
            var downvoteEl = profileActionEl.querySelector('.downvote_stat');
            var tastyEl = profileActionEl.parentElement.parentElement.querySelector('.tasty_stat');

            var upvoteCount = parseInt(json.upvotes);
            var downvoteCount = parseInt(json.downvotes);
            var tastyCount = parseInt(json.user_tasties);

            upvoteEl.innerText = upvoteCount;
            downvoteEl.innerText = downvoteCount;
            tastyEl.innerText = tastyCount;
        }
    }, {
        key: 'createCommentForm',
        value: function createCommentForm(el, action) {
            if (!el.parentElement.querySelector('.comment__form')) {

                var form = document.createElement("form");
                form.method = 'post';
                form.action = action;
                form.setAttribute('class', 'mt-1 mt-lg-3 comment__form');

                var tokenInput = document.createElement('input');
                tokenInput.value = this.token();
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';

                var textarea = document.createElement('textarea');
                textarea.name = 'content';
                textarea.setAttribute('class', 'form-control my-2');

                var submitButton = document.createElement('button');
                submitButton.type = 'submit';
                submitButton.setAttribute('class', 'btn btn-primary');
                submitButton.innerText = 'Submit';

                form.appendChild(textarea);
                form.appendChild(tokenInput);
                form.appendChild(submitButton);

                el.parentElement.appendChild(form);
            }
        }
    }]);

    return UserAction;
}();

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/business.js");


/***/ })

/******/ });