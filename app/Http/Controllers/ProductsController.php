<?php

namespace App\Http\Controllers;

use App\Products;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\User;

class ProductsController extends Controller
{
    public function products(){
        $products= Products::all();
        return view('user.products',['products'=>$products] );
    }
    public function addproduct( $products_id){

       $user1= Sentinel::check();
       $user=User::findorfail($user1->id);
        $user->productss()->attach($products_id);
        return redirect()->route('products');


     }
     public function deletefromchart( $products_id){

        $user1= Sentinel::check();

        $user=User::findorfail($user1->id);
         $user->productss()->detach($products_id);
         return redirect()->route('user.orders',$user1->id);


      }

}
