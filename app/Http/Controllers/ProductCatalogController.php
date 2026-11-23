<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->with('category')
            ->where('is_active', true);

        if ($request->filled('q')) {
            $search = $request->string('q')->trim();
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category)
                    ->orWhereHas('category', function ($sub) use ($category) {
                        $sub->where('slug', $category);
                    });
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        if ($request->boolean('in_stock') || $request->boolean('available')) {
            $query->where('stock', '>', 0);
        }

        switch ($request->input('sort')) {
            case 'price_asc':
            case 'cheap':
            case 'lowest':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
            case 'expensive':
            case 'highest':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, function ($q) use ($product) {
                $q->where('category_id', $product->category_id);
            })
            ->latest()
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}