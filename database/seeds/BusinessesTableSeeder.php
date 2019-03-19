<?php

use Illuminate\Database\Seeder;
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
      $slug = Str::slug($name . hexdec(uniqid()), '-');
      $business = Business::create([
        'name'      =>  $name,
        'slug'      =>  $slug,
        'address'   =>  '9320 Steele Creek Rd, Charlotte, NC 28273'
        'city'      =>  'Charlotte',
        'state'     =>  'NC',
        'zip_code'  =>  '28273',
      ]);
      $business->save();
    }
}
