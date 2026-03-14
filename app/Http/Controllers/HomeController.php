<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured  = Product::active()->featured()->inStock()->with(['images', 'category', 'reviews'])->limit(8)->get();
        $categories = Category::active()->orderBy('sort_order')->limit(8)->get();
        $newArrivals = Product::active()->inStock()->with(['images', 'category'])->latest()->limit(4)->get();
        $onSale     = Product::active()->whereNotNull('sale_price')->inStock()->with(['images', 'category'])->inRandomOrder()->limit(4)->get();

        return view('pages.home', compact('featured', 'categories', 'newArrivals', 'onSale'));
    }
}
