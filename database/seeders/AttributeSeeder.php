<?php

namespace Database\Seeders;

use App\Models\AttributeType;
use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Size', 'slug' => 'size', 'display_type' => 'button',
                'attributes' => [
                    ['value' => 'XS', 'sort_order' => 1],
                    ['value' => 'S',  'sort_order' => 2],
                    ['value' => 'M',  'sort_order' => 3],
                    ['value' => 'L',  'sort_order' => 4],
                    ['value' => 'XL', 'sort_order' => 5],
                    ['value' => 'XXL', 'sort_order' => 6],
                ],
            ],
            [
                'name' => 'Color', 'slug' => 'color', 'display_type' => 'color_swatch',
                'attributes' => [
                    ['value' => 'Red',    'color_hex' => '#EF4444', 'sort_order' => 1],
                    ['value' => 'Blue',   'color_hex' => '#3B82F6', 'sort_order' => 2],
                    ['value' => 'Green',  'color_hex' => '#22C55E', 'sort_order' => 3],
                    ['value' => 'Black',  'color_hex' => '#111827', 'sort_order' => 4],
                    ['value' => 'White',  'color_hex' => '#F9FAFB', 'sort_order' => 5],
                    ['value' => 'Gray',   'color_hex' => '#6B7280', 'sort_order' => 6],
                    ['value' => 'Orange', 'color_hex' => '#F97316', 'sort_order' => 7],
                    ['value' => 'Purple', 'color_hex' => '#A855F7', 'sort_order' => 8],
                    ['value' => 'Pink',   'color_hex' => '#EC4899', 'sort_order' => 9],
                    ['value' => 'Navy',   'color_hex' => '#1E3A5F', 'sort_order' => 10],
                ],
            ],
            [
                'name' => 'Storage', 'slug' => 'storage', 'display_type' => 'button',
                'attributes' => [
                    ['value' => '64GB',  'sort_order' => 1],
                    ['value' => '128GB', 'sort_order' => 2],
                    ['value' => '256GB', 'sort_order' => 3],
                    ['value' => '512GB', 'sort_order' => 4],
                    ['value' => '1TB',   'sort_order' => 5],
                ],
            ],
            [
                'name' => 'RAM', 'slug' => 'ram', 'display_type' => 'button',
                'attributes' => [
                    ['value' => '4GB',  'sort_order' => 1],
                    ['value' => '8GB',  'sort_order' => 2],
                    ['value' => '16GB', 'sort_order' => 3],
                    ['value' => '32GB', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Material', 'slug' => 'material', 'display_type' => 'select',
                'attributes' => [
                    ['value' => 'Cotton',    'sort_order' => 1],
                    ['value' => 'Polyester', 'sort_order' => 2],
                    ['value' => 'Wool',      'sort_order' => 3],
                    ['value' => 'Leather',   'sort_order' => 4],
                    ['value' => 'Canvas',    'sort_order' => 5],
                    ['value' => 'Denim',     'sort_order' => 6],
                ],
            ],
        ];

        foreach ($types as $typeData) {
            $attributes = $typeData['attributes'];
            unset($typeData['attributes']);
            $type = AttributeType::create($typeData);

            foreach ($attributes as $attr) {
                $type->attributes()->create($attr);
            }
        }
    }
}
