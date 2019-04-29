<?php
use Illuminate\Support\Str;


function time_left_string($datetime, $full = false) {
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
    return implode(', ', $string);
}

function time_elapsed_string($datetime, $full = false) {
    $string = time_left_string($datetime, $full);
    return $string ? $string . ' ago' : 'just now';
}

function generate_slug($string = '') {
  return Str::slug($string . uniqid(), '-');
}

function address_to_geo($address) {
  $geocode= file_get_contents('https://maps.google.com/maps/api/geocode/json?key=' . config("settings.googleMapsAPIKey") . '&address='. urlencode($address) . '&sensor=false');
  $output= json_decode($geocode);
  if(count($output->results) != 0) {
      return [
      'lat' => $output->results[0]->geometry->location->lat,
      'lng' => $output->results[0]->geometry->location->lng,
      ];
  }
  else return null;
}

function address_to_json($address) {
    $result = file_get_contents('https://maps.google.com/maps/api/geocode/json?key=' . config("settings.googleMapsAPIKey") . '&address='. urlencode($address) . '&sensor=false');
    $output = json_decode($result);
    if(count($output->results) != 0) {
        return $output->results[0];
    }
    else return null;
}

function format_address($street, $city, $state, $zip) {
  return $street . ' ' . $city . ', '. $state . ' ' . $zip;
}

function censor_name($first_name, $last_name) {
    return $first_name . ' ' . $last_name[0];
}
