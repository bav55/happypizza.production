<?php

namespace App\Http\Controllers\View;

use App\Models\Category;
use App\Models\Good;
use App\Models\Ingredient;
use App\Models\Preference;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request, $url){
        $category = Category::where('url',$url)->get();
        if($request->order){
            $goods = Good::where('category_id',$category[0]->id)->orderBy($request->order,'ASC')->get();
        } else {
            $goods = Good::where('category_id',$category[0]->id)->orderBy('position','ASC')->get();
        }
        $urlAlias = array ();
        foreach ($goods as $product) {
            
            if (!empty($product->url) ) {
                  //return redirect()->route('product_link', $goods[0]->url);
                $urlAlias[$product->id] = $product->url;
            }
        }
            
        
        $preferences = Preference::where('category_id',$category[0]->id)->get();
        $ingredients = Ingredient::where('category_id',$category[0]->id)->get();
        return view('view.category', compact('goods', 'category','preferences','ingredients','urlAlias'));
    }
}
