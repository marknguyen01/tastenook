
var map;

window.initMap = function() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: geopoints,
    zoom: 15,
    disableDefaultUI: true,
  });
  var marker = new google.maps.Marker({position: geopoints, map: map});
}
$('.form__rating input').change(function () {
  var $radio = $(this);
  $('.form__rating .selected').removeClass('selected');
  $radio.closest('label').addClass('selected');
});

window.UserAction = class UserAction {
  static token () {
    return document.querySelector("meta[name=csrf-token]").getAttribute('content');
  }
  init(el) {

  }
  static sendRequest(el, url) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
      if(this.readyState == 4 && this.status == 200) {
        const target = el.querySelector(".action__stats");
        console.log(el)
      }
    }
    xhttp.open("POST", url);
    xhttp.setRequestHeader("X-CSRF-TOKEN", this.token());
    xhttp.send();
  }
}
