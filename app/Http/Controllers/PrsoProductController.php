<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrsoProduct as Product;
use App\Models\PrsoCategory as Category;

use App\Http\Requests;

class PrsoProductController extends Controller
{

    public function show($slug, $categoryid=null)
    {
        if ( $product = Product::where('slug',$slug)->first()) {
            $parentCategores=$product->categories;
            $pathCategory=Category::find($categoryid);
            return view('Spares::product_show', compact('product','parentCategores', 'pathCategory'));
        }
        abort(404);
    }

    public function getAddToCard(Request $request, $arguments = [])
    {
    }

}
