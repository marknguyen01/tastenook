<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Business;

class BusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $name = "McDonald's";
      $slug = Str::slug($name . uniqid(), '-');
      $business = Business::create([
        'name'      =>  $name,
        'slug'      =>  $slug,
        'street_address'   =>  '9320 Steele Creek Rd',
        'city'      =>  'Charlotte',
        'state'     =>  'NC',
        'zip_code'  =>  '28273',
        'phone_number' => '7045839274',
        'website' => 'https://www.mcdonalds.com/us/en-us.html',
      ]);

      $address = format_address($business->street_address, $business->city,
      $business->state, $business->zip_code);

      $geopoints = address_to_geo($address);

      $business->lat = $geopoints['lat'] != null ? $geopoints['lat'] : 0;
      $business->lng =  $geopoints['lng'] != null ? $geopoints['lng'] : 0;

      // Generate placholder images
      $op = 'public/images/businesses/faker_images/';
      $dp = 'public/images/businesses/profile/' . $business->slug;

      \File::cleanDirectory(base_path('public/images/businesses/profile'));

      \File::makeDirectory(base_path($dp), 0777);
      \File::copy(base_path($op . 'cover.jpg'), base_path($dp . '/cover.jpg'));
      \File::copy(base_path($op . 'avatar.jpg'), base_path($dp . '/avatar.jpg'));
      \File::copy(base_path($op . 'slide1.jpg'), base_path($dp . '/slide1.jpg'));
      \File::copy(base_path($op . 'slide2.jpg'), base_path($dp . '/slide1.jpg'));

      $business->avatar = '/images/businesses/profile/' . $business->slug . '/avatar.jpg';

      $business->save();
    }
}
