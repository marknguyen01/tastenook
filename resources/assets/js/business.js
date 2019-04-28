require('./user-action');

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
