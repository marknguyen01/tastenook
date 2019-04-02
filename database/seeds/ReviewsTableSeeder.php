<?php

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Business;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $review1 = Review::create([
        'slug' => generate_slug(),
        'content' => 'Best restaurant ever',
        'rating' => 5,
        'user_id' => 1,
        'business_id' => 1,
      ]);

      $review2 = Review::create([
        'slug' => generate_slug(),
        'content' => "It's ok",
        'rating' => 3,
        'user_id' => 2,
        'business_id' => 1,
      ]);

      $business = Business::find(1);
      $business->review_count = 2;
      $business->rating_count = 2;
      $business->rating_avg = ($review1->rating + $review2->rating) / $business->rating_count;


      $review1->save();
      $review2->save();
      $business->save();
    }
}
