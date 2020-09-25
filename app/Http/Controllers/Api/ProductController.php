<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Products;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index($id){

         $user=User::findorfail($id);
         $products=$user->productss()->paginate(2);
            // $products=Products::paginate(2);


        return ProductResource::collection($products);
    }
    public function destroy($id)
    {
        // Get article
        $product= Products::findOrFail($id);

        if ($product->delete()) {
            return new ProductResource($product);
        }

        return null;
    }
}
