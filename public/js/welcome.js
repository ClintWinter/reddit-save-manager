/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/welcome.js ***!
  \*********************************/
document.querySelector('#subscribe').addEventListener('click', function (event) {
  event.preventDefault();
  var url = '/subscribe?_token=' + document.querySelector('[name="_token"]').value;
  var body = {
    email: document.querySelector('[name="email"]').value
  };
  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
  }).then(function (response) {
    if (response.ok) {
      return response.text();
    }

    throw response;
  }).then(function (message) {
    var elStatus = document.querySelector('#subscribe-status');
    var elError = document.querySelector('#subscribe-error');
    elError.classList.add('hidden');
    elStatus.textContent = JSON.parse(message);
    elStatus.classList.remove('hidden');
  })["catch"](function (error) {
    error.text().then(function (message) {
      var elStatus = document.querySelector('#subscribe-status');
      var elError = document.querySelector('#subscribe-error');
      elStatus.classList.add('hidden');
      elError.textContent = JSON.parse(message);
      elError.classList.remove('hidden');
    });
  });
});
/******/ })()
;