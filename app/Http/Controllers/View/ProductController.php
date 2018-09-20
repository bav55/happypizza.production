<?php

namespace App\Http\Controllers\View;

use App\Models\Category;
use App\Models\Good;
use App\Models\Ingredient;
use App\Models\Preference;
use App\Models\Recomend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request, $url){
        $product_id = $url;
        
        $product = Good::where('url',$product_id)->get();
        //dd($product[0]);
        if (!isset($product[0]->id)) {
            $product = Good::where('id',$product_id)->get();
            if (!empty($product[0]->url) ) {
                  return redirect()->route('product_link', $product[0]->url);
            }
        }

         $categoryProduct = Category::where('id',$product[0]->category_id)->get();
         
        // $recommendeds = Recomend::all();
         $recommended_id = json_decode($product[0]->recommended);
         
         $banners = array();
         if($recommended_id){
            foreach($recommended_id as $id){
              $banner = Recomend::where('id',$id)->get();
              $banners[] = $banner[0];
             }
         }
        // print_r($banners);exit();
         
        return view('view.product', compact('product','categoryProduct','recommendeds','banners'));
    }
}
