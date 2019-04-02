
var map;
window.initMap = function() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: geopoints,
    zoom: 15,
    disableDefaultUI: true,
  });
  var marker = new google.maps.Marker({position: geopoints, map: map});
}
