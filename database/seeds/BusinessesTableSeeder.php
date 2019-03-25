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
        'address'   =>  '9320 Steele Creek Rd, Charlotte, NC 28273',
        'city'      =>  'Charlotte',
        'state'     =>  'NC',
        'zip_code'  =>  '28273',
        'vote_avg'  => '3.4',
      ]);
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
