<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviewers = [
            ['name' => 'Sarah M.', 'rating' => 5, 'title' => 'Absolutely love it!', 'body' => 'This product exceeded all my expectations. The quality is outstanding and it arrived quickly. Will definitely buy again!'],
            ['name' => 'James K.', 'rating' => 4, 'title' => 'Great value for money', 'body' => 'Really happy with this purchase. Works exactly as described and the build quality is solid. Minor packaging issue but the product itself is perfect.'],
            ['name' => 'Emma L.', 'rating' => 5, 'title' => 'Perfect!', 'body' => 'Exactly what I was looking for. The quality is premium and it looks even better in person. Fast shipping too!'],
            ['name' => 'David R.', 'rating' => 4, 'title' => 'Very good product', 'body' => 'Using this daily and it holds up really well. Good quality materials and the design is spot on. Would recommend!'],
            ['name' => 'Anna T.', 'rating' => 5, 'title' => 'Highly recommend!', 'body' => 'Bought this as a gift and the recipient absolutely loved it. Amazing quality at a fair price. Will be ordering more from Marketory!'],
        ];

        $products = Product::active()->inRandomOrder()->limit(30)->get();

        foreach ($products as $product) {
            $count = rand(2, 4);
            $selected = array_rand($reviewers, min($count, count($reviewers)));
            if (!is_array($selected)) $selected = [$selected];

            foreach ($selected as $idx) {
                Review::create([
                    'product_id'    => $product->id,
                    'reviewer_name' => $reviewers[$idx]['name'],
                    'rating'        => $reviewers[$idx]['rating'],
                    'title'         => $reviewers[$idx]['title'],
                    'body'          => $reviewers[$idx]['body'],
                    'is_approved'   => true,
                    'created_at'    => now()->subDays(rand(1, 90)),
                ]);
            }
        }
    }
}
