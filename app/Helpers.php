<?php
use Illuminate\Support\Str;

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function generate_slug($string = '') {
  return Str::slug($string . uniqid(), '-');
}

function address_to_geo($address) {
  $geocode= file_get_contents('https://maps.google.com/maps/api/geocode/json?key=' . config("settings.googleMapsAPIKey") . '&address='. urlencode($address) . '&sensor=false');
  $output= json_decode($geocode);
  return [
    'lat' => $output->results[0]->geometry->location->lat,
    'lng' => $output->results[0]->geometry->location->lng,
  ];
}

function format_address($street, $city, $state, $zip) {
  return $street . ' ' . $city . ', '. $state . ' ' . $zip;
}
