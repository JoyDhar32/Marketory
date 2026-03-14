<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Attribute;
use App\Models\AttributeType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private function categoryImages(string $cat): array
    {
        $bank = [
            'electronics'     => [
                '1511707171634-5f897ff02aa9', // iPhone flat lay
                '1496181133206-80ce9b88a853', // MacBook on desk
                '1505740420928-5e560c06d30e', // Sony headphones
                '1523275335684-37898b6baf30', // Apple Watch
                '1593784991095-a205069533cd', // 4K TV
                '1587829741301-dc798b83add3', // mechanical keyboard
                '1608043152269-423dbba4e7e1', // Bluetooth speaker
                '1526170375885-4d8ecf77b99f', // action camera
                '1527864550417-7fd91fc51a46', // gaming mouse
                '1544244015-0df4b3ffc6b0',   // tablet/iPad
            ],
            'fashion'         => [
                '1562157873-818bc0726f68',   // white t-shirt
                '1542291026-7eec264c27ff',   // Nike sneakers
                '1515372039744-b8f02a3ae446', // floral dress
                '1551028719-00167b16eac5',   // leather jacket
                '1542272604-787c3835535d',   // slim pants
                '1556821840-3a63f95609a7',   // hoodie
                '1583496661160-fb5218beab11', // skirt
                '1469334031218-e382a71b716b', // blouse
                '1539533018447-63fcce2678e3', // overcoat
                '1565693413579-8a73ffa8de15', // running shorts
            ],
            'home-garden'     => [
                '1555041469-a586c61ea9bc',   // throw blanket on couch
                '1501004318641-b39e6451bec6', // houseplant in pot
                '1416879595882-3373a0480b5b', // garden plants
                '1556909114-f6e7ad7d3136',   // bamboo kitchen
                '1603006905003-be475563bc59', // soy candles
                '1602143407151-7111542de6e8', // water bottle
                '1558060370-d644479cb6f7',   // string fairy lights
            ],
            'books'           => [
                '1512820790803-83ca734da794', // books on shelf
                '1544716278-ca5e3f4abd8c',   // open book
                '1481627834876-b7833e8f84f6', // reading book
                '1507003211169-0a1dd7228f2d', // book cover close-up
            ],
            'sports-outdoors' => [
                '1534438327276-14e5300c3a48', // dumbbells / gym weights
                '1601925228008-22b0571e9e4b', // yoga mat rolled out
                '1553062407-98eeb64c6a62',   // camping backpack
                '1558618666-fcd25c85cd64',   // cycling helmet
                '1571902943202-507ec2618e8f', // foam roller exercise
            ],
            'beauty-health'   => [
                '1596755389378-c31d21fd1273', // skincare cream jar
                '1620916566398-39f1143ab7be', // vitamin C serum
                '1556228578-8c89e6adf883',   // moisturizer bottle
                '1579165466741-7f35e4755660', // essential oils set
                '1607613009820-a29f7bb81c04', // bamboo toothbrush
            ],
            'toys-games'      => [
                '1611996575749-79a3a250f948', // board game pieces
                '1529699211952-734e80c4d42b', // wooden chess set
                '1587654780291-39c9404d746b', // colorful building blocks
            ],
            'automotive'      => [
                '1493238792460-5948be2174ac', // car dashboard / interior
                '1590650046871-92c887180603', // car phone mount
            ],
            'food-grocery'    => [
                '1514432324607-a09d9b4aefdd', // roasted coffee beans
                '1511381939415-e44f73e0c1a0', // dark chocolate bar
                '1556679343-c7306c1976bc',   // green tea cup
                '1548848221-0c2e497ed557',   // mixed nuts bowl
            ],
        ];

        $pool = $bank[$cat] ?? $bank['electronics'];
        // Return 3 IDs — cycle through the pool
        $count = count($pool);
        return [
            $pool[0 % $count],
            $pool[1 % $count],
            $pool[2 % $count],
        ];
    }

    private function img(string $id): string
    {
        return "https://images.unsplash.com/photo-{$id}?w=600&h=600&fit=crop&auto=format&q=80";
    }

    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');
        $colorAttrType = AttributeType::where('slug', 'color')->first();
        $sizeAttrType  = AttributeType::where('slug', 'size')->first();
        $storageType   = AttributeType::where('slug', 'storage')->first();
        $ramType       = AttributeType::where('slug', 'ram')->first();

        $colors   = Attribute::where('attribute_type_id', $colorAttrType->id)->get()->keyBy('value');
        $sizes    = Attribute::where('attribute_type_id', $sizeAttrType->id)->get()->keyBy('value');
        $storages = Attribute::where('attribute_type_id', $storageType->id)->get()->keyBy('value');
        $rams     = Attribute::where('attribute_type_id', $ramType->id)->get()->keyBy('value');

        $products = [
            // ---- ELECTRONICS (20) ----
            ['name' => 'ProMax Smartphone 256GB', 'cat' => 'electronics', 'price' => 899.99, 'sale' => 799.99, 'featured' => true,
             'variants' => [
                ['storage' => '128GB', 'color' => 'Black',  'stock' => 30, 'mod' => -100],
                ['storage' => '256GB', 'color' => 'Black',  'stock' => 25, 'mod' => 0],
                ['storage' => '256GB', 'color' => 'White',  'stock' => 20, 'mod' => 0],
                ['storage' => '512GB', 'color' => 'Black',  'stock' => 15, 'mod' => 100],
            ]],
            ['name' => 'UltraBook Pro 15"', 'cat' => 'electronics', 'price' => 1299.99, 'featured' => true,
             'variants' => [
                ['ram' => '8GB',  'storage' => '256GB', 'stock' => 10, 'mod' => -200],
                ['ram' => '16GB', 'storage' => '512GB', 'stock' => 12, 'mod' => 0],
                ['ram' => '32GB', 'storage' => '1TB',   'stock' => 8,  'mod' => 400],
            ]],
            ['name' => 'Wireless Noise-Cancelling Headphones', 'cat' => 'electronics', 'price' => 349.99, 'sale' => 279.99, 'featured' => true,
             'variants' => [
                ['color' => 'Black', 'stock' => 40, 'mod' => 0],
                ['color' => 'White', 'stock' => 35, 'mod' => 0],
                ['color' => 'Blue',  'stock' => 20, 'mod' => 0],
            ]],
            ['name' => '4K Smart TV 55"', 'cat' => 'electronics', 'price' => 699.99, 'sale' => 549.99, 'featured' => true, 'stock' => 15],
            ['name' => 'Mechanical Gaming Keyboard', 'cat' => 'electronics', 'price' => 129.99,
             'variants' => [
                ['color' => 'Black', 'stock' => 50, 'mod' => 0],
                ['color' => 'White', 'stock' => 30, 'mod' => 0],
            ]],
            ['name' => 'Ergonomic Gaming Mouse', 'cat' => 'electronics', 'price' => 79.99,
             'variants' => [
                ['color' => 'Black', 'stock' => 60, 'mod' => 0],
                ['color' => 'White', 'stock' => 40, 'mod' => 0],
            ]],
            ['name' => 'Portable Bluetooth Speaker', 'cat' => 'electronics', 'price' => 89.99, 'sale' => 69.99,
             'variants' => [
                ['color' => 'Black',  'stock' => 45, 'mod' => 0],
                ['color' => 'Blue',   'stock' => 30, 'mod' => 0],
                ['color' => 'Orange', 'stock' => 25, 'mod' => 0],
            ]],
            ['name' => 'Smartwatch Pro Series 5', 'cat' => 'electronics', 'price' => 299.99, 'sale' => 249.99,
             'variants' => [
                ['color' => 'Black', 'stock' => 35, 'mod' => 0],
                ['color' => 'Gray',  'stock' => 25, 'mod' => 0],
            ]],
            ['name' => 'Tablet 10" HD Display', 'cat' => 'electronics', 'price' => 449.99,
             'variants' => [
                ['storage' => '64GB',  'color' => 'Gray',  'stock' => 20, 'mod' => 0],
                ['storage' => '128GB', 'color' => 'Gray',  'stock' => 18, 'mod' => 80],
                ['storage' => '128GB', 'color' => 'Black', 'stock' => 15, 'mod' => 80],
            ]],
            ['name' => 'USB-C Hub 7-in-1', 'cat' => 'electronics', 'price' => 49.99, 'stock' => 100],
            ['name' => 'Wireless Charging Pad', 'cat' => 'electronics', 'price' => 39.99, 'stock' => 80],
            ['name' => 'Action Camera 4K Waterproof', 'cat' => 'electronics', 'price' => 249.99, 'sale' => 199.99, 'stock' => 25],
            ['name' => 'Desktop Computer Mini PC', 'cat' => 'electronics', 'price' => 599.99,
             'variants' => [
                ['ram' => '8GB',  'storage' => '256GB', 'stock' => 10, 'mod' => 0],
                ['ram' => '16GB', 'storage' => '512GB', 'stock' => 8,  'mod' => 200],
            ]],
            ['name' => 'Smart Home Security Camera', 'cat' => 'electronics', 'price' => 89.99, 'stock' => 60],
            ['name' => 'Portable Power Bank 20000mAh', 'cat' => 'electronics', 'price' => 59.99,
             'variants' => [
                ['color' => 'Black', 'stock' => 70, 'mod' => 0],
                ['color' => 'White', 'stock' => 50, 'mod' => 0],
            ]],
            ['name' => 'Mechanical Keyboard Tenkeyless', 'cat' => 'electronics', 'price' => 99.99,
             'variants' => [
                ['color' => 'White', 'stock' => 40, 'mod' => 0],
                ['color' => 'Black', 'stock' => 35, 'mod' => 0],
            ]],
            ['name' => 'Monitor 27" 144Hz IPS', 'cat' => 'electronics', 'price' => 379.99, 'sale' => 319.99, 'stock' => 20],
            ['name' => 'Webcam 1080p with Ring Light', 'cat' => 'electronics', 'price' => 79.99, 'stock' => 55],
            ['name' => 'Smart Doorbell with Camera', 'cat' => 'electronics', 'price' => 149.99, 'stock' => 30],
            ['name' => 'Noise Isolating Earbuds', 'cat' => 'electronics', 'price' => 49.99, 'sale' => 39.99,
             'variants' => [
                ['color' => 'Black', 'stock' => 80, 'mod' => 0],
                ['color' => 'White', 'stock' => 60, 'mod' => 0],
                ['color' => 'Pink',  'stock' => 40, 'mod' => 0],
            ]],

            // ---- FASHION (20) ----
            ['name' => 'Classic Cotton T-Shirt', 'cat' => 'fashion', 'price' => 29.99, 'featured' => true,
             'variants' => [
                ['size' => 'S',  'color' => 'White', 'stock' => 30, 'mod' => 0],
                ['size' => 'M',  'color' => 'White', 'stock' => 40, 'mod' => 0],
                ['size' => 'L',  'color' => 'White', 'stock' => 35, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 45, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black', 'stock' => 38, 'mod' => 0],
                ['size' => 'XL', 'color' => 'Black', 'stock' => 25, 'mod' => 0],
            ]],
            ['name' => 'Slim Fit Chino Pants', 'cat' => 'fashion', 'price' => 59.99, 'sale' => 44.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Navy', 'stock' => 20, 'mod' => 0],
                ['size' => 'M',  'color' => 'Navy', 'stock' => 25, 'mod' => 0],
                ['size' => 'L',  'color' => 'Navy', 'stock' => 22, 'mod' => 0],
                ['size' => 'M',  'color' => 'Gray', 'stock' => 28, 'mod' => 0],
                ['size' => 'L',  'color' => 'Gray', 'stock' => 20, 'mod' => 0],
            ]],
            ['name' => 'Floral Summer Dress', 'cat' => 'fashion', 'price' => 49.99, 'sale' => 34.99,
             'variants' => [
                ['size' => 'XS', 'color' => 'Pink',   'stock' => 15, 'mod' => 0],
                ['size' => 'S',  'color' => 'Pink',   'stock' => 20, 'mod' => 0],
                ['size' => 'M',  'color' => 'Pink',   'stock' => 25, 'mod' => 0],
                ['size' => 'S',  'color' => 'Purple', 'stock' => 18, 'mod' => 0],
                ['size' => 'M',  'color' => 'Purple', 'stock' => 22, 'mod' => 0],
            ]],
            ['name' => 'Leather Biker Jacket', 'cat' => 'fashion', 'price' => 199.99, 'sale' => 159.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Black', 'stock' => 10, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 12, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black', 'stock' => 8,  'mod' => 0],
            ]],
            ['name' => 'Denim Jeans Straight Cut', 'cat' => 'fashion', 'price' => 79.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Blue', 'stock' => 25, 'mod' => 0],
                ['size' => 'M',  'color' => 'Blue', 'stock' => 30, 'mod' => 0],
                ['size' => 'L',  'color' => 'Blue', 'stock' => 28, 'mod' => 0],
                ['size' => 'XL', 'color' => 'Blue', 'stock' => 20, 'mod' => 0],
            ]],
            ['name' => 'Wool Blend Overcoat', 'cat' => 'fashion', 'price' => 249.99, 'sale' => 199.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Gray',  'stock' => 8,  'mod' => 0],
                ['size' => 'M',  'color' => 'Gray',  'stock' => 10, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black', 'stock' => 9,  'mod' => 0],
            ]],
            ['name' => 'Athletic Running Shorts', 'cat' => 'fashion', 'price' => 34.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Black',  'stock' => 35, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black',  'stock' => 40, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black',  'stock' => 38, 'mod' => 0],
                ['size' => 'M',  'color' => 'Blue',   'stock' => 30, 'mod' => 0],
                ['size' => 'L',  'color' => 'Orange', 'stock' => 25, 'mod' => 0],
            ]],
            ['name' => 'Casual Hoodie Pullover', 'cat' => 'fashion', 'price' => 54.99, 'sale' => 44.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Gray',   'stock' => 30, 'mod' => 0],
                ['size' => 'M',  'color' => 'Gray',   'stock' => 35, 'mod' => 0],
                ['size' => 'L',  'color' => 'Gray',   'stock' => 28, 'mod' => 0],
                ['size' => 'M',  'color' => 'Navy',   'stock' => 32, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black',  'stock' => 30, 'mod' => 0],
            ]],
            ['name' => 'Silk Evening Blouse', 'cat' => 'fashion', 'price' => 89.99,
             'variants' => [
                ['size' => 'XS', 'color' => 'White', 'stock' => 12, 'mod' => 0],
                ['size' => 'S',  'color' => 'White', 'stock' => 15, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 18, 'mod' => 0],
                ['size' => 'L',  'color' => 'Pink',  'stock' => 14, 'mod' => 0],
            ]],
            ['name' => 'Canvas Sneakers Low-Top', 'cat' => 'fashion', 'price' => 69.99, 'sale' => 54.99,
             'variants' => [
                ['size' => 'S',  'color' => 'White', 'stock' => 20, 'mod' => 0],
                ['size' => 'M',  'color' => 'White', 'stock' => 25, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black', 'stock' => 22, 'mod' => 0],
                ['size' => 'XL', 'color' => 'Black', 'stock' => 18, 'mod' => 0],
            ]],
            ['name' => 'Ribbed Turtleneck Sweater', 'cat' => 'fashion', 'price' => 74.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Beige', 'stock' => 15, 'mod' => 0],
                ['size' => 'M',  'color' => 'Beige', 'stock' => 18, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black', 'stock' => 20, 'mod' => 0],
            ]],
            ['name' => 'Pleated Midi Skirt', 'cat' => 'fashion', 'price' => 59.99, 'sale' => 49.99,
             'variants' => [
                ['size' => 'XS', 'color' => 'Pink',  'stock' => 12, 'mod' => 0],
                ['size' => 'S',  'color' => 'Pink',  'stock' => 16, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 20, 'mod' => 0],
            ]],
            ['name' => 'Formal Button-Down Shirt', 'cat' => 'fashion', 'price' => 64.99,
             'variants' => [
                ['size' => 'S',  'color' => 'White', 'stock' => 25, 'mod' => 0],
                ['size' => 'M',  'color' => 'White', 'stock' => 30, 'mod' => 0],
                ['size' => 'L',  'color' => 'Blue',  'stock' => 28, 'mod' => 0],
                ['size' => 'XL', 'color' => 'Gray',  'stock' => 22, 'mod' => 0],
            ]],
            ['name' => 'Waterproof Rain Jacket', 'cat' => 'fashion', 'price' => 119.99, 'sale' => 94.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Blue',  'stock' => 15, 'mod' => 0],
                ['size' => 'M',  'color' => 'Blue',  'stock' => 18, 'mod' => 0],
                ['size' => 'L',  'color' => 'Green', 'stock' => 14, 'mod' => 0],
                ['size' => 'XL', 'color' => 'Black', 'stock' => 12, 'mod' => 0],
            ]],
            ['name' => 'High-Waist Yoga Leggings', 'cat' => 'fashion', 'price' => 44.99,
             'variants' => [
                ['size' => 'XS', 'color' => 'Black',  'stock' => 30, 'mod' => 0],
                ['size' => 'S',  'color' => 'Black',  'stock' => 35, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black',  'stock' => 40, 'mod' => 0],
                ['size' => 'M',  'color' => 'Purple', 'stock' => 25, 'mod' => 0],
                ['size' => 'L',  'color' => 'Gray',   'stock' => 30, 'mod' => 0],
            ]],
            ['name' => 'Leather Ankle Boots', 'cat' => 'fashion', 'price' => 149.99, 'sale' => 119.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Black', 'stock' => 10, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 12, 'mod' => 0],
                ['size' => 'L',  'color' => 'Brown', 'stock' => 8,  'mod' => 0],
            ]],
            ['name' => 'Printed Graphic Sweatshirt', 'cat' => 'fashion', 'price' => 49.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Gray',  'stock' => 22, 'mod' => 0],
                ['size' => 'M',  'color' => 'Gray',  'stock' => 28, 'mod' => 0],
                ['size' => 'L',  'color' => 'Black', 'stock' => 30, 'mod' => 0],
            ]],
            ['name' => 'Linen Blazer Jacket', 'cat' => 'fashion', 'price' => 139.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Beige', 'stock' => 8,  'mod' => 0],
                ['size' => 'M',  'color' => 'Beige', 'stock' => 10, 'mod' => 0],
                ['size' => 'L',  'color' => 'Navy',  'stock' => 9,  'mod' => 0],
            ]],
            ['name' => 'Sports Compression Socks', 'cat' => 'fashion', 'price' => 19.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Black', 'stock' => 50, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 60, 'mod' => 0],
                ['size' => 'L',  'color' => 'White', 'stock' => 55, 'mod' => 0],
            ]],
            ['name' => 'Wide-Brim Sun Hat', 'cat' => 'fashion', 'price' => 39.99, 'sale' => 29.99,
             'variants' => [
                ['color' => 'Beige', 'stock' => 25, 'mod' => 0],
                ['color' => 'Black', 'stock' => 30, 'mod' => 0],
                ['color' => 'White', 'stock' => 20, 'mod' => 0],
            ]],

            // ---- HOME & GARDEN (10) ----
            ['name' => 'Ceramic Planter Set (3pc)', 'cat' => 'home-garden', 'price' => 44.99, 'featured' => true,
             'variants' => [
                ['color' => 'White',  'stock' => 30, 'mod' => 0],
                ['color' => 'Black',  'stock' => 25, 'mod' => 0],
                ['color' => 'Orange', 'stock' => 20, 'mod' => 0],
            ]],
            ['name' => 'Bamboo Cutting Board Set', 'cat' => 'home-garden', 'price' => 34.99, 'stock' => 60],
            ['name' => 'Linen Throw Blanket', 'cat' => 'home-garden', 'price' => 59.99, 'sale' => 49.99,
             'variants' => [
                ['color' => 'Gray',  'stock' => 25, 'mod' => 0],
                ['color' => 'Beige', 'stock' => 22, 'mod' => 0],
                ['color' => 'Blue',  'stock' => 18, 'mod' => 0],
            ]],
            ['name' => 'Scented Soy Candle Set', 'cat' => 'home-garden', 'price' => 29.99, 'stock' => 80],
            ['name' => 'Cast Iron Dutch Oven 5Qt', 'cat' => 'home-garden', 'price' => 89.99, 'sale' => 69.99,
             'variants' => [
                ['color' => 'Black',  'stock' => 15, 'mod' => 0],
                ['color' => 'Orange', 'stock' => 12, 'mod' => 0],
                ['color' => 'Red',    'stock' => 10, 'mod' => 0],
            ]],
            ['name' => 'Stainless Steel Water Bottle', 'cat' => 'home-garden', 'price' => 24.99,
             'variants' => [
                ['color' => 'Black',  'stock' => 60, 'mod' => 0],
                ['color' => 'Blue',   'stock' => 50, 'mod' => 0],
                ['color' => 'Green',  'stock' => 45, 'mod' => 0],
                ['color' => 'Pink',   'stock' => 40, 'mod' => 0],
            ]],
            ['name' => 'Hanging String Lights 10m', 'cat' => 'home-garden', 'price' => 19.99, 'stock' => 100],
            ['name' => 'Monstera Plant Pot 6"', 'cat' => 'home-garden', 'price' => 39.99, 'stock' => 40],
            ['name' => 'Wooden Serving Tray Set', 'cat' => 'home-garden', 'price' => 49.99, 'sale' => 39.99, 'stock' => 35],
            ['name' => 'Smart LED Bulbs 4-Pack', 'cat' => 'home-garden', 'price' => 49.99, 'stock' => 55],

            // ---- BOOKS (10) ----
            ['name' => 'The Art of Productivity', 'cat' => 'books', 'price' => 16.99, 'stock' => 100],
            ['name' => 'JavaScript: The Good Parts', 'cat' => 'books', 'price' => 29.99, 'stock' => 75],
            ['name' => 'Atomic Habits', 'cat' => 'books', 'price' => 18.99, 'sale' => 14.99, 'featured' => true, 'stock' => 150],
            ['name' => 'Clean Code Handbook', 'cat' => 'books', 'price' => 34.99, 'stock' => 60],
            ['name' => 'The Midnight Garden (Novel)', 'cat' => 'books', 'price' => 12.99, 'stock' => 120],
            ['name' => 'Digital Marketing Mastery', 'cat' => 'books', 'price' => 24.99, 'stock' => 85],
            ['name' => 'Cooking for Beginners', 'cat' => 'books', 'price' => 22.99, 'sale' => 17.99, 'stock' => 90],
            ['name' => 'Philosophy of Mind', 'cat' => 'books', 'price' => 19.99, 'stock' => 70],
            ['name' => 'Financial Freedom Blueprint', 'cat' => 'books', 'price' => 21.99, 'stock' => 110],
            ['name' => 'The Creative Process', 'cat' => 'books', 'price' => 17.99, 'stock' => 95],

            // ---- SPORTS & OUTDOORS (10) ----
            ['name' => 'Adjustable Dumbbell Set 20kg', 'cat' => 'sports-outdoors', 'price' => 149.99, 'sale' => 119.99, 'featured' => true, 'stock' => 25],
            ['name' => 'Yoga Mat Premium Non-Slip', 'cat' => 'sports-outdoors', 'price' => 49.99,
             'variants' => [
                ['color' => 'Purple', 'stock' => 40, 'mod' => 0],
                ['color' => 'Black',  'stock' => 45, 'mod' => 0],
                ['color' => 'Blue',   'stock' => 35, 'mod' => 0],
            ]],
            ['name' => 'Running Shoes Lightweight', 'cat' => 'sports-outdoors', 'price' => 99.99, 'sale' => 79.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Black', 'stock' => 20, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 25, 'mod' => 0],
                ['size' => 'L',  'color' => 'Blue',  'stock' => 22, 'mod' => 0],
                ['size' => 'XL', 'color' => 'Gray',  'stock' => 18, 'mod' => 0],
            ]],
            ['name' => 'Resistance Bands Set 5pc', 'cat' => 'sports-outdoors', 'price' => 29.99, 'stock' => 80],
            ['name' => 'Mountain Bike Helmet', 'cat' => 'sports-outdoors', 'price' => 89.99,
             'variants' => [
                ['size' => 'S',  'color' => 'Black', 'stock' => 15, 'mod' => 0],
                ['size' => 'M',  'color' => 'Black', 'stock' => 18, 'mod' => 0],
                ['size' => 'L',  'color' => 'Red',   'stock' => 12, 'mod' => 0],
            ]],
            ['name' => 'Jump Rope Speed Cable', 'cat' => 'sports-outdoors', 'price' => 19.99, 'stock' => 120],
            ['name' => 'Foam Roller Deep Tissue', 'cat' => 'sports-outdoors', 'price' => 34.99, 'stock' => 60],
            ['name' => 'Camping Backpack 50L', 'cat' => 'sports-outdoors', 'price' => 129.99, 'sale' => 99.99,
             'variants' => [
                ['color' => 'Green',  'stock' => 15, 'mod' => 0],
                ['color' => 'Gray',   'stock' => 18, 'mod' => 0],
                ['color' => 'Orange', 'stock' => 12, 'mod' => 0],
            ]],
            ['name' => 'Tennis Racket Carbon Fiber', 'cat' => 'sports-outdoors', 'price' => 79.99, 'stock' => 30],
            ['name' => 'Hydration Running Belt', 'cat' => 'sports-outdoors', 'price' => 39.99,
             'variants' => [
                ['color' => 'Black', 'stock' => 50, 'mod' => 0],
                ['color' => 'Blue',  'stock' => 40, 'mod' => 0],
            ]],

            // ---- BEAUTY & HEALTH (10) ----
            ['name' => 'Vitamin C Serum 30ml', 'cat' => 'beauty-health', 'price' => 34.99, 'sale' => 27.99, 'featured' => true, 'stock' => 80],
            ['name' => 'Retinol Night Cream', 'cat' => 'beauty-health', 'price' => 44.99, 'stock' => 65],
            ['name' => 'Hyaluronic Acid Moisturizer', 'cat' => 'beauty-health', 'price' => 39.99, 'stock' => 70],
            ['name' => 'Natural Bamboo Toothbrush 4-Pack', 'cat' => 'beauty-health', 'price' => 14.99, 'stock' => 150],
            ['name' => 'Aromatherapy Essential Oils Set', 'cat' => 'beauty-health', 'price' => 29.99, 'stock' => 90],
            ['name' => 'Collagen Peptides Powder', 'cat' => 'beauty-health', 'price' => 49.99, 'sale' => 39.99, 'stock' => 55],
            ['name' => 'Jade Facial Roller Set', 'cat' => 'beauty-health', 'price' => 24.99,
             'variants' => [
                ['color' => 'Green', 'stock' => 40, 'mod' => 0],
                ['color' => 'Pink',  'stock' => 35, 'mod' => 0],
            ]],
            ['name' => 'Electric Toothbrush Sonic', 'cat' => 'beauty-health', 'price' => 79.99, 'sale' => 59.99,
             'variants' => [
                ['color' => 'White', 'stock' => 30, 'mod' => 0],
                ['color' => 'Black', 'stock' => 25, 'mod' => 0],
            ]],
            ['name' => 'Lip Care Set 6-Pack', 'cat' => 'beauty-health', 'price' => 19.99, 'stock' => 110],
            ['name' => 'Probiotic Supplement 60 Caps', 'cat' => 'beauty-health', 'price' => 34.99, 'stock' => 75],

            // ---- TOYS & GAMES (10) ----
            ['name' => 'Strategy Board Game Deluxe', 'cat' => 'toys-games', 'price' => 44.99, 'featured' => true, 'stock' => 40],
            ['name' => 'STEM Building Blocks 200pc', 'cat' => 'toys-games', 'price' => 39.99, 'stock' => 55],
            ['name' => 'Remote Control Racing Car', 'cat' => 'toys-games', 'price' => 59.99,
             'variants' => [
                ['color' => 'Red',  'stock' => 25, 'mod' => 0],
                ['color' => 'Blue', 'stock' => 20, 'mod' => 0],
            ]],
            ['name' => 'Classic Chess Set Wooden', 'cat' => 'toys-games', 'price' => 34.99, 'stock' => 45],
            ['name' => 'Dinosaur Figure Set 12pc', 'cat' => 'toys-games', 'price' => 24.99, 'stock' => 70],
            ['name' => 'Watercolor Paint Set 48 Colors', 'cat' => 'toys-games', 'price' => 29.99, 'stock' => 60],
            ['name' => 'Puzzle 1000 Pieces Landscape', 'cat' => 'toys-games', 'price' => 19.99, 'sale' => 14.99, 'stock' => 85],
            ['name' => 'Card Game Party Pack', 'cat' => 'toys-games', 'price' => 22.99, 'stock' => 90],
            ['name' => 'Magnetic Drawing Board Kids', 'cat' => 'toys-games', 'price' => 27.99,
             'variants' => [
                ['color' => 'Blue',  'stock' => 30, 'mod' => 0],
                ['color' => 'Pink',  'stock' => 28, 'mod' => 0],
                ['color' => 'Green', 'stock' => 25, 'mod' => 0],
            ]],
            ['name' => 'Science Experiment Kit', 'cat' => 'toys-games', 'price' => 49.99, 'stock' => 35],

            // ---- AUTOMOTIVE (5) ----
            ['name' => 'Car Phone Mount Magnetic', 'cat' => 'automotive', 'price' => 29.99, 'stock' => 80],
            ['name' => 'Portable Car Jump Starter', 'cat' => 'automotive', 'price' => 79.99, 'sale' => 64.99, 'featured' => true, 'stock' => 30],
            ['name' => 'Car Vacuum Cleaner Cordless', 'cat' => 'automotive', 'price' => 49.99, 'stock' => 45],
            ['name' => 'Tire Pressure Gauge Digital', 'cat' => 'automotive', 'price' => 19.99, 'stock' => 100],
            ['name' => 'Car Seat Organizer Back', 'cat' => 'automotive', 'price' => 34.99,
             'variants' => [
                ['color' => 'Black', 'stock' => 40, 'mod' => 0],
                ['color' => 'Gray',  'stock' => 30, 'mod' => 0],
            ]],

            // ---- FOOD & GROCERY (5) ----
            ['name' => 'Organic Coffee Beans 1kg', 'cat' => 'food-grocery', 'price' => 24.99, 'featured' => true, 'stock' => 100],
            ['name' => 'Artisan Dark Chocolate Box', 'cat' => 'food-grocery', 'price' => 19.99, 'sale' => 15.99, 'stock' => 80],
            ['name' => 'Premium Green Tea Collection', 'cat' => 'food-grocery', 'price' => 29.99, 'stock' => 75],
            ['name' => 'Mixed Nuts Deluxe 500g', 'cat' => 'food-grocery', 'price' => 17.99, 'stock' => 120],
            ['name' => 'Gourmet Olive Oil Extra Virgin', 'cat' => 'food-grocery', 'price' => 22.99, 'stock' => 90],
        ];

        foreach ($products as $index => $data) {
            $category = $categories[$data['cat']];
            $isVariable = isset($data['variants']);
            $slug = \Str::slug($data['name']);

            // Calculate total stock
            $totalStock = 0;
            if ($isVariable) {
                foreach ($data['variants'] as $v) {
                    $totalStock += $v['stock'];
                }
            } else {
                $totalStock = $data['stock'] ?? rand(20, 100);
            }

            $product = Product::create([
                'category_id'       => $category->id,
                'name'              => $data['name'],
                'slug'              => $slug,
                'short_description' => $this->shortDesc($data['name'], $data['cat']),
                'description'       => $this->longDesc($data['name'], $data['cat']),
                'base_price'        => $data['price'],
                'sale_price'        => $data['sale'] ?? null,
                'sku'               => 'MKT-' . strtoupper(substr($slug, 0, 6)) . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'stock_quantity'    => $totalStock,
                'is_featured'       => $data['featured'] ?? false,
                'is_active'         => true,
                'is_variable'       => $isVariable,
                'sort_order'        => $index,
            ]);

            // Category-specific Unsplash images
            $imgs = $this->categoryImages($data['cat']);
            $offset = $index % count($imgs);
            $img0 = $imgs[$offset % count($imgs)];
            $img1 = $imgs[($offset + 1) % count($imgs)];
            $img2 = $imgs[($offset + 2) % count($imgs)];
            ProductImage::create(['product_id' => $product->id, 'image_url' => $this->img($img0), 'is_primary' => true,  'sort_order' => 0]);
            ProductImage::create(['product_id' => $product->id, 'image_url' => $this->img($img1), 'is_primary' => false, 'sort_order' => 1]);
            ProductImage::create(['product_id' => $product->id, 'image_url' => $this->img($img2), 'is_primary' => false, 'sort_order' => 2]);

            // Variants
            if ($isVariable) {
                foreach ($data['variants'] as $vData) {
                    $variantSku = $product->sku . '-' . strtoupper(substr(implode('-', array_filter([
                        $vData['color'] ?? null,
                        $vData['size'] ?? null,
                        $vData['storage'] ?? null,
                        $vData['ram'] ?? null,
                    ])), 0, 12));

                    $variant = $product->allVariants()->create([
                        'sku'            => $variantSku,
                        'price_modifier' => $vData['mod'] ?? 0,
                        'stock_quantity' => $vData['stock'],
                        'is_active'      => true,
                    ]);

                    $attrIds = [];
                    if (isset($vData['color']) && isset($colors[$vData['color']])) {
                        $attrIds[] = $colors[$vData['color']]->id;
                    }
                    if (isset($vData['size']) && isset($sizes[$vData['size']])) {
                        $attrIds[] = $sizes[$vData['size']]->id;
                    }
                    if (isset($vData['storage']) && isset($storages[$vData['storage']])) {
                        $attrIds[] = $storages[$vData['storage']]->id;
                    }
                    if (isset($vData['ram']) && isset($rams[$vData['ram']])) {
                        $attrIds[] = $rams[$vData['ram']]->id;
                    }

                    if (!empty($attrIds)) {
                        $variant->variantAttributes()->attach($attrIds);
                    }
                }
            }
        }
    }

    private function shortDesc(string $name, string $cat): string
    {
        $descs = [
            'electronics'     => "High-quality {$name} designed for performance and reliability. Perfect for everyday use and professional applications.",
            'fashion'         => "Stylish and comfortable {$name} crafted from premium materials. A wardrobe essential for every occasion.",
            'home-garden'     => "Beautifully designed {$name} to enhance your living space. Durable, functional, and aesthetically pleasing.",
            'books'           => "A must-read title that will broaden your perspective and deepen your knowledge. Highly rated by readers worldwide.",
            'sports-outdoors' => "Professional-grade {$name} built for durability and peak performance. Ideal for athletes at every level.",
            'beauty-health'   => "Premium {$name} formulated with high-quality ingredients. Achieve visible results with consistent use.",
            'toys-games'      => "Fun and educational {$name} that sparks creativity and brings joy to all ages.",
            'automotive'      => "Reliable {$name} designed to keep your vehicle in top condition. Easy to install and built to last.",
            'food-grocery'    => "Premium quality {$name} sourced from the finest ingredients. Enjoy exceptional taste and freshness.",
            'office-supplies' => "Professional {$name} to boost your productivity. Designed for comfort and efficiency in the workplace.",
        ];
        return $descs[$cat] ?? "Premium quality product with excellent features and great value.";
    }

    private function longDesc(string $name, string $cat): string
    {
        return "<p>Introducing the <strong>{$name}</strong> — a premium product designed to exceed your expectations in quality, performance, and style.</p>
<p>Whether you're a seasoned enthusiast or just starting out, this product delivers exceptional value and lasting satisfaction. Crafted with attention to detail and built to withstand the demands of daily use, it's the perfect choice for discerning customers.</p>
<h4>Key Features</h4>
<ul>
<li>Premium materials and expert craftsmanship</li>
<li>Designed for durability and long-term reliability</li>
<li>Ergonomic design for maximum comfort and usability</li>
<li>Backed by our quality guarantee and customer support</li>
</ul>
<p>Join thousands of satisfied customers who trust Marketory for their everyday needs. Order today and experience the difference quality makes.</p>";
    }
}
