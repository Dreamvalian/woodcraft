<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sortBy = $request->input('sort_by', 'newest');

        $products = Product::query()
            ->when($query, function ($q) use ($query) {
                return $q->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                });
            })
            ->when($category, function ($q) use ($category) {
                return $q->whereHas('categories', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->when($minPrice, function ($q) use ($minPrice) {
                return $q->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($q) use ($maxPrice) {
                return $q->where('price', '<=', $maxPrice);
            });

        switch ($sortBy) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->orderBy('created_at', 'desc');
                break;
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $products */
        $products = $products->paginate(12)->withQueryString();

        return view('search.index', compact('products', 'query', 'category', 'minPrice', 'maxPrice', 'sortBy'));
    }
}
