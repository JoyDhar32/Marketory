<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Gadgets, devices, and tech accessories', 'image_url' => 'https://picsum.photos/seed/cat-electronics/600/400', 'sort_order' => 1],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Clothing, shoes, and accessories for everyone', 'image_url' => 'https://picsum.photos/seed/cat-fashion/600/400', 'sort_order' => 2],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Everything for your home and outdoor spaces', 'image_url' => 'https://picsum.photos/seed/cat-home/600/400', 'sort_order' => 3],
            ['name' => 'Books', 'slug' => 'books', 'description' => 'Fiction, non-fiction, and educational titles', 'image_url' => 'https://picsum.photos/seed/cat-books/600/400', 'sort_order' => 4],
            ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors', 'description' => 'Gear and equipment for active lifestyles', 'image_url' => 'https://picsum.photos/seed/cat-sports/600/400', 'sort_order' => 5],
            ['name' => 'Beauty & Health', 'slug' => 'beauty-health', 'description' => 'Skincare, wellness, and personal care products', 'image_url' => 'https://picsum.photos/seed/cat-beauty/600/400', 'sort_order' => 6],
            ['name' => 'Toys & Games', 'slug' => 'toys-games', 'description' => 'Fun for all ages — toys, board games, and more', 'image_url' => 'https://picsum.photos/seed/cat-toys/600/400', 'sort_order' => 7],
            ['name' => 'Automotive', 'slug' => 'automotive', 'description' => 'Car accessories, tools, and parts', 'image_url' => 'https://picsum.photos/seed/cat-auto/600/400', 'sort_order' => 8],
            ['name' => 'Food & Grocery', 'slug' => 'food-grocery', 'description' => 'Gourmet foods, snacks, and pantry essentials', 'image_url' => 'https://picsum.photos/seed/cat-food/600/400', 'sort_order' => 9],
            ['name' => 'Office Supplies', 'slug' => 'office-supplies', 'description' => 'Stationery, desk accessories, and office essentials', 'image_url' => 'https://picsum.photos/seed/cat-office/600/400', 'sort_order' => 10],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
